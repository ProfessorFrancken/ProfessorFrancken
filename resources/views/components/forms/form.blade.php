@props([
       'url',
       'method' => 'POST',
       'hasFiles' => false,
       'model' => null
])

@if ($model !== null)
{!!
       Form::model($model, [
           'url' => $url,
           'method' => $method,
           'enctype' => $hasFiles ? 'multipart/form-data' : null
       ])
!!}
@else
{!!
       Form::open([
           'url' => $url,
           'method' => $method,
           'enctype' => $hasFiles ? 'multipart/form-data' : null
       ])
!!}
@endif

{!! $slot !!}

{!! Form::close() !!}
