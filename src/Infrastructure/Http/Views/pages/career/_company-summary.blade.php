<section class="row company-summary">
    <div class="col-md-3">
        <img class="company-summary__logo" alt="{{ $company['name'] }}" src="{{ $company['logo'] }}"/>
    </div>
    <div class="col-md-9">
        <h3 class="company-summary__title">
            {{ $company['name'] }}
        </h3>
        <p>
            {{ $company['summary'] }}
        </p>
        <a class="company-summary__read-more" href="{{ $company['read-more-at'] }}">Read more</a>
    </div>
</section>
