@props([
    'name',
    'label',
    'value' => null,
    'placeholder' => 'yyyy-mm',
    'help' => '',
    'required' => false,
])

<x-forms.form-group :name="$name" :label="$label" :help="$help">
    {!!
           Form::input(
               'month',
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
