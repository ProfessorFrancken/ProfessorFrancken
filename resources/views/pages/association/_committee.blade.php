<h2>
    {{ $name }}
    @if ($translated != '')
        ({{ $translated }})
    @endif
</h2>

<p>
    {{ $slot }}
</p>

<a class="btn btn-primary" href="{{ $link }}">Visit the {{ $name }} page</a>

<hr/>
