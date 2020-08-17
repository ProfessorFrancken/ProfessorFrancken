@props([
    'name',
    'label' => null,
    'help' => '',
    'formGroupClass' => ''
])

<div class="form-group {{ $formGroupClass }}">
    @if($label !== null)
        <label for="{{ $name }}">{{ $label }}</label>
    @endif

    {{-- Include the input field from our parent component --}}
    {!! $slot !!}

    <x-forms.error :name="$name" />

    @if ($help)
        <small class="form-text text-muted">
            {!! $help !!}
        </small>
    @endif
</div>
