<div class="col-sm-6 col-md-4">
    <div class="committee-card">
        <a href="/association/committees/{{ $link }}" class="committee-card__link">
            @if ($logo != '')
                <img
                    alt="{{ $name }}"
                    src="{{ image($logo, ['height' => 200, 'width' => 300]) }}"
                    class="committee-card__logo"
                />
            @else
                <h4 class="committee-card__name">
                    {{ $name }}
                </h4>
            @endif
        </a>
    </div>
</div>
