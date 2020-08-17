@props([
    'name',
    'label',
    'value' => null,
    'options' => [],
    'placeholder' => '',
    'help' => '',
])

<x-forms.form-group :name="$name" :label="$label" :help="$help">
    {!!
           Form::select(
               $name,
               $options,
               $value,
               [
                   'class' => 'form-control' . ($errors->has($name) ? ' is-invalid' : ''),
                   'id' => $name
               ]
           );
    !!}
</x-forms.form-group>
