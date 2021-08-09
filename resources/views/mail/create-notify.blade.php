<h3>В приложении {{ $title }}</h3>
<p>Заголовок: <b>{{ $model->title }}</b></p>
@if($model->price)
   <p>Цена: <b>{{ $model->price }}</b></p>
@endif
<p>Сторонний ID: <b>{{ $model->eId ?? 'не указан' }}</b></p>