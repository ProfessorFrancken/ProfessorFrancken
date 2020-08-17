@props([
    'name',
    'label' => null,
    'value' => null,
    'placeholder' => '',
    'help' => '',
    'required' => false,
    'disabled' => false,
])

<x-forms.form-group :name="$name" :label="$label" :help="$help">
    {!!
           Form::text(
               $name,
               $value,
               [
                   'class' => 'form-control' . ($errors->has($name) ? ' is-invalid' : ''),
                   'placeholder' => $placeholder,
                   'id' => $name,
                   'required' => $required,
                   'disabled' => $disabled,
               ]
           )
    !!}
</x-forms.form-group>
