@props([
    'name',
    'label' => null,
    'value' => null,
    'placeholder' => '',
    'help' => '',
    'required' => false,
])

<x-forms.form-group :name="$name" :label="$label" :help="$help">
    {!!
           Form::email(
               $name,
               $value,
               [
                   'class' => 'form-control' . ($errors->has($name) ? ' is-invalid' : ''),
                   'placeholder' => $placeholder,
                   'id' => $name,
                   'required' => $required,
               ]
           )
    !!}
</x-forms.form-group>
