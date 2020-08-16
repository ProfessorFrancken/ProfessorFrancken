@props([
    'name',
    'label',
    'value' => null,
    'placeholder' => 'yyyy-mm',
    'help' => '',
    'required' => false,
])

<div class="form-group">
    <label for="{{ $name }}">{{ $label }}</label>
    {!!
           Form::input(
               'month',
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
