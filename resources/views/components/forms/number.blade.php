@props([
    'name',
    'label',
    'value' => null,
    'placeholder' => '',
    'help' => '',
])

<x-forms.form-group :name="$name" :label="$label" :help="$help">
    {!!
           Form::number(
               $name,
               $value,
               [
                   'class' => 'form-control' . ($errors->has($name) ? ' is-invalid' : ''),
                   'placeholder' => $placeholder,
                   'id' => $name,
               ]
           )
    !!}
</x-forms.form-group>
