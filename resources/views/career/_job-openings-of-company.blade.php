<section class="job-opening row">
    <div class="col-md-4 d-none">
        <img class="company-card__logo img-fluid" alt="{{ $job['name'] }}" src="{{ $job['logo'] }}"/>

        <a href="{{ $job['link'] }}">
            <i class="fa fa-globe" aria-hidden="true"></i>
            {{ $job['name'] }}
        </a>
    </div>
    <div class="col-md-12">
        <img class="pull-right img-fluid job-opening__company-logo job-opening__company-logo " style="max-width: 100px;" alt="{{ $job['name'] }}" src="{{ $job['logo'] }}"/>
        <h3 class="h4 job-opening__title">{{ $job['job'] }}</h3>

        <ul class="list-inline">
            <li class="list-inline-item">
                <a href="{{ $job['link'] }}" class="text-muted"><i class="fa fa-globe" aria-hidden="true"></i> {{ $job['name'] }} </a>
            </li>
            <li class="list-inline-item">
                <a href="{{ route('job-openings', array_merge(request()->all(), ['sector' => $job['sector']])) }}">
                    <i class="fa fa-{{ $sectors[$job['sector']] }}" aria-hidden="true"></i> {{ $job['sector'] }}
                </a>
            </li>
            <li class="list-inline-item">
                <a href="{{ route('job-openings', array_merge(request()->all(), ['jobType' => $job['type']])) }}">
                    <i class="fa fa-{{ $types[$job['type']] }}" aria-hidden="true"></i> {{ $job['type'] }}
                </a>
            </li>
            <li class="list-inline-item">
                <i class="fa fa-map-marker" aria-hidden="true"></i> {{ $job['location'] or 'Eindhoven' }}
            </li>
        </ul>

        <p>
            {{ $job['description'] ?? (app(\Faker\Generator::class))->text }}
        </p>

        <p>
            <a class="" href="{{ $job['link'] }}">Show details</a>
        </p>
    </div>
</section>
