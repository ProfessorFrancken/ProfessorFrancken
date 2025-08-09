@props([
    'name',
    'label' => null,
    'value' => null,
    'help' => '',
    'placeholder' => 'yyyy-mm-dd hh:mm:ss',
    'required' => false,
    'disabled' => false,
    'readonly' => false,
])

<x-forms.form-group :name="$name" :label="$label" :help="$help">
    {!!
           Form::datetime(
               $name,
               $value,
               [
                   'class' => 'form-control' . ($errors->has($name) ? ' is-invalid' : ''),
                   'placeholder' => $placeholder,
                   'id' => $name,
                   'required' => $required,
                   'disabled' => $disabled,
                   'readonly' => $readonly
               ]
           )
    !!}
</x-forms.form-group>
