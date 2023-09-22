@props([
    'name',
    'label' => null,
    'value' => null,
    'placeholder' => 'yyyy-mm-dd',
    'help' => '',
    'required' => false,
    'disabled' => false,
    'min' => null,
    'max' => null,
])

<x-forms.form-group :name="$name" :label="$label" :help="$help">
    {!!
           Form::date(
               $name,
               $value,
               [
                   'class' => 'form-control' . ($errors->has($name) ? ' is-invalid' : ''),
                   'placeholder' => $placeholder,
                   'id' => $name,
                   'required' => $required,
                   'disabled' => $disabled,
                   'min' => $min,
                   'max' => $max,
               ]
           )
    !!}
</x-forms.form-group>
