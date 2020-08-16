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

    @error($name)
    <p class="invalid-feedback">
        {{ $message  }}
    </p>
    @enderror

    {!! $help !!}
</div>