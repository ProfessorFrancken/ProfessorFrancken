@props([
    'name',
    'label',
    'value' => null,
    'help' => '',
    'placeholder' => 'yyyy-mm-dd hh:mm:ss',
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
