@props([
    'name',
    'label',
    'value' => null,
    'help' => '',
    'placeholder' => 'yyyy-mm-dd hh:mm:ss',
    'required' => false,
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
               ]
           )
    !!}
</x-forms.form-group>
