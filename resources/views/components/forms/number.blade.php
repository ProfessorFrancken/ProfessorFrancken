@props([
    'name',
    'label',
    'value' => null,
    'placeholder' => '',
    'help' => '',
])

<div class="form-group">
    <label for="{{ $name }}">{{ $label }}</label>
    {!!
           Form::number(
               $name,
               $value,
               [
                   'class' => 'form-control' . ($errors->has($name) ? ' is-invalid' : ''),
                   'placeholder' => $placeholder,
                   'id' => $name,
               ]
           )
    !!}

    <x-forms.error :name="$name" />

    {!! $help !!}
</div>
