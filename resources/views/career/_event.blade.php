<li id="{{ str_slug($excursion['name']) }}" class="excursion-list-item">
    <div class="excursion-container rounded excursion-container--with-image my-2">
	      <h2 class="section-header section-header--centered section-header--light excursion-header" >
            {{ $excursion['name'] }}
        </h2>
        @if ($excursion['promo-image'] != '')
            <img src="{{ image($excursion['promo-image'], ['width' => 1110, 'height' => 200]) }}" class="img-fluid rounded excursion-image"/>
        @endif
    </div>

    @if (! is_null($excursion['description']))
        <p class="lead">
            {{ $excursion['description'] }}
        </p>
    @endif

    <dl class="row">
        @foreach ($excursion['metadata'] as $metadata)
            <dt class="col-sm-3">{{ $metadata['term'] }}</dt>
            <dd class="col-sm-9">{!! $metadata['description'] !!}</dd>
        @endforeach
    </dl>
</li>
