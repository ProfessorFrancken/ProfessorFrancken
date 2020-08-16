@props([
    'name',
    'label',
    'help' => '',
    'formGroupClass' => ''
])

<div class="form-group {{ $formGroupClass }}">
    @isset($label)
        <label for="{{ $name }}">{{ $label }}</label>
    @endisset

    {{-- Include the input field from our parent component --}}
    {!! $slot !!}

    <x-forms.error :name="$name" />

    @if ($help)
        <small class="form-text text-muted">
            {!! $help !!}
        </small>
    @endif
</div>
