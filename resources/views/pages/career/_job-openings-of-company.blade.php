<section class="job-opening">
    <div class="col-md-9">
        <h2 class="job-opening__company-name">{{ $company['name'] }}</h2>
        <ul>
            @foreach ($company['job-openings'] as $job)
                <li>
                    <a href="{{ $job['link'] }}">{{ $job['job'] }}</a>
                </li>
            @endforeach
        </ul>
    </div>
    <div class="col-md-3">
        <img class="img-fluid job-opening__company-logo" alt="{{ $company['name'] }}" src="{{ $company['logo'] }}"/>
    </div>
</section>
