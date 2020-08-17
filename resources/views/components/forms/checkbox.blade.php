@props([
    'name',
    'label',
    'value' => null,
    'help' => '',
    'formGroupClass' => ''
])

<x-forms.form-group :name="$name" :label="null" :help="$help" form-group-class="form-check {{ $formGroupClass }}">
    {!!
           Form::checkbox(
               $name,
               true,
               $value,
               [
                   'class' => 'form-check-input' . ($errors->has($name) ? ' is-invalid' : ''),
                   'checked' => $value,
                   'id' => $name
               ]
           )
    !!}
    <label class="form-check-label" for="{{ $name }}">
        {!! $label !!}
    </label>
</x-forms.form-group>
