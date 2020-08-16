@props([
    'text' => 'Save',
    'class' => 'btn btn-outline-success',
])

{!! Form::submit($text, ['class' => $class]) !!}
