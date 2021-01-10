@props([
    'class' => 'btn btn-outline-success',
    'disabled' => false,
    'block' => false,
    'text' => '',
])

{!!
       Form::submit(
           $slot == '' ? $text : $slot,
           [
               'class' => $class . ($block ? ' btn-block' : ''),
               'disabled' => $disabled
           ]
       )
!!}
