{{-- https://freek.dev/1612-some-cool-laravel-7-blade-components --}}
{{-- content of formButton.blade.php --}}
<form method="POST" action="{{ $action }}">
    @csrf
    @method($method ?? 'POST')
        <button
            type="submit"
            class="{{ $class ?? '' }}"
        >
            {{ $slot }}
        </button>
</form>
