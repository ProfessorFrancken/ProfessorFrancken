@props([
    'name',
    'label',
    'value' => null,
    'placeholder' => '',
    'help' => '',
    'required' => false,
])

<div class="form-group">
    <label for="{{ $name }}">{{ $label }}</label>
    {!!
           Form::text(
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
