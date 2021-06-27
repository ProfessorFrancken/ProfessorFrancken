@props([
    'name',
    'label',
    'value' => null,
    'placeholder' => '',
    'help' => '',
    'required' => false,
    'disabled' => false,
    'readonly' => false,
           'step' => 'any'
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
                   'required' => $required,
                   'disabled' => $disabled,
                   'readonly' => $readonly,
                   'step' => $step,
               ]
           )
    !!}
</x-forms.form-group>
