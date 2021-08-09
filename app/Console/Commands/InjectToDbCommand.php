<?php

namespace App\Console\Commands;

use App\Events\CreateEntity;
use App\Models\Category;
use App\Services\ProductsService;
use App\Transformers\{CategoryFromFileTransformer, ProductFromFileTransformer};
use App\Validators\CategoryValidator;
use Exception;
use File;
use Illuminate\Console\Command;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;

class InjectToDbCommand extends Command {
   private $fractal;
   private $config;
   private $productsService;

   /**
    * The name and signature of the console command.
    *
    * @var string
    */
   protected $signature = 'app:inject {--categories=true} {--products=true}';

   /**
    * The console command description.
    *
    * @var string
    */
   protected $description = 'Добавить записи из файлов JSON';

   /**
    * Create a new command instance.
    *
    * @return void
    */
   public function __construct(ProductsService $productsService) {
      parent::__construct();

      $this->fractal = new Manager();
      $this->config = collect(config('inject'));
      $this->productsService = $productsService;
   }

   /**
    * Execute the console command.
    *
    * @return mixed
    */
   public function handle() {
      $basePath = $this->config->get('path');

      $files = collect($this->config->get('files'));

      $files->each(
         function (string $file) use ($basePath) {
            try {
               $data = File::get($basePath . DIRECTORY_SEPARATOR . $file);
               $data = json_decode($data, true);

               if (Str::startsWith($file, 'categor')) {
                  if ($this->option('categories') === 'true') {
                     $this->createCategories($data);
                  }
               }

               if (Str::startsWith($file, 'product')) {
                  if ($this->option('products') === 'true') {
                     $this->createProducts($data);
                  }
               }
            } catch (Exception $e) {
               if ($e instanceof FileNotFoundException) {
                  $this->error("Файл {$file} не найден");
               } else {
                  throw $e;
               }
            }
         }
      );
   }

   private function createCategories(array $data) {
      $data = new Collection($data, new CategoryFromFileTransformer);
      $data = collect($this->fractal->createData($data)->toArray()['data']);

      $data->each(
         function ($item) {
            $this->createCategoryItem($item);
         }
      );
   }

   /**
    * @throws ValidationException
    */
   private function createCategoryItem($item): void {
      try {
         CategoryValidator::validate($item)->validate();

         $category = new Category();

         $category->title = $item['title'];
         $category->eId = $item['eId'] ?? null;

         if ($category->save()) {
            $this->info("Категория {$category->title} успешно добавлена");

            \Event::dispatch(new CreateEntity($category));
 
            return;
         }

         $this->error(
            "Что-то пошло не так с добавлением категории {$category->id}"
         );

         return;
      } catch (Exception $e) {
         $this->error('Категория не была создана/обновлена');

         switch (true) {
            case $e instanceof ValidationException:
               $this->line("Список ошибок {$item['title']}:");
               $this->createErrors($e->errors());
               break;
            default:
               throw $e;
         }
      }
   }

   private function createProducts(array $data) {
      $data = new Collection($data, new ProductFromFileTransformer);
      $data = collect($this->fractal->createData($data)->toArray()['data']);

      $data->each(
         function ($item) {
            $this->createProductItem($item);
         }
      );
   }

   /**
    * @throws Exception
    */
   public function createProductItem($item) {
      try {
         $product = $this->productsService->create($item);

         $this->info("Товар {$product->title} успешно добавлен");
      } catch (Exception $e) {
         $this->error('Товар не был создан/обновлен');
         switch (true) {
            case $e instanceof ValidationException:
               $this->line("Список ошибок {$item['title']}:");
               $this->createErrors($e->errors());
               break;
            default:
               throw $e;
         }
      }
   }

   private function createErrors(array $errors) {
      $errors = collect($errors)->flatMap(
         function ($item, $name) {
            return [
               collect($item)->flatMap(
                  function ($value) use ($name) {
                     return [$name, $value];
                  }
               )
            ];
         }
      )->toArray();

      $this->table(['Ключ', 'Описание'], $errors);
   }
}
