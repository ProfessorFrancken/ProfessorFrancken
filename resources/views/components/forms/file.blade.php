@props([
    'name',
    'label' => null,
    'value' => null,
    'placeholder' => '',
    'help' => '',
    'required' => false,
    'disabled' => false,
    'readonly' => false,
])

<x-forms.form-group :name="$name" :label="$label" :help="$help">
    {!!
           Form::file(
               $name,
               [
                   'class' => 'form-control-file' . ($errors->has($name) ? ' is-invalid' : ''),
                   'id' => $name,
                   'required' => $required,
                   'disabled' => $disabled,
                   'readonly' => $readonly,
               ]
           )
    !!}
</x-forms.form-group>
