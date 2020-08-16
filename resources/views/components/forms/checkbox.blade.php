@props([
    'name',
    'label',
    'value' => null,
    'help' => '',
])

<div class="form-group form-check">
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

    @error($name)
    <p class="invalid-feedback">
        {{ $message  }}
    </p>
    @enderror

    {!! $help !!}
</div>
