@props(['name'])

@error($name)
<p class="invalid-feedback">
    {{ $message  }}
</p>
@enderror
