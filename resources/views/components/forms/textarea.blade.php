@props([
    'name',
    'label' => null,
    'value' => null,
    'placeholder' => '',
    'help' => '',
    'required' => false,
    'rows' => 3,
])

<x-forms.form-group :name="$name" :label="$label" :help="$help">
    {!!
           Form::textarea(
               $name,
               $value,
               [
                   'class' => 'form-control' . ($errors->has($name) ? ' is-invalid' : ''),
                   'placeholder' => $placeholder,
                   'id' => $name,
                   'required' => $required,
                   'rows' => $rows,
               ]
           )
    !!}
</x-forms.form-group>
