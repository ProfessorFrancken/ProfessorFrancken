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

    <x-forms.error :name="$name" />

    {!! $help !!}
</div>
