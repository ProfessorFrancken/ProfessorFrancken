@props([
    'name',
    'label',
    'value' => null,
    'help' => '',
    'placeholder',
    'required' => false,
])

<div class="form-group">
    <label for="{{ $name }}">{{ $label }}</label>
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

    <x-forms.error :name="$name" />

    {!! $help !!}
</div>
