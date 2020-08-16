@props([
    'name',
    'label',
    'value' => null,
    'placeholder' => 'yyyy-mm-dd',
    'help' => '',
    'required' => false,
])

<div class="form-group">
    <label for="{{ $name }}">{{ $label }}</label>
    {!!
           Form::date(
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
