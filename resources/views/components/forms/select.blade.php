@props([
    'name',
    'label',
    'value' => null,
    'options' => [],
    'placeholder' => '',
    'help' => '',
])

<div class="form-group">
    <label for="{{ $name }}">{{ $label }}</label>
    {!!
           Form::select(
               $name,
               $options,
               $value,
               [
                   'class' => 'form-control' . ($errors->has($name) ? ' is-invalid' : ''),
                   'id' => $name
               ]
           );
    !!}

    @error($name)
    <p class="invalid-feedback">
        {{ $message  }}
    </p>
    @enderror

    {!! $help !!}
</div>
