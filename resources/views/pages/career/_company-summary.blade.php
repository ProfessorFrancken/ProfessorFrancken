<div class="col-sm-6 col-md-4">
    <div class="company-card">
        <a href="/career/companies/{{ str_slug($company['name']) }}" class="company-card__link">
            @if ( $company['logo'] != '')
                <img alt="{{ $company['name'] }}" src="{{ $company['logo'] }}" class="company-card__logo"/>
            @else
                <h4 class="company-card__name">
                    {{ $company['name'] }}
                </h4>
            @endif
        </a>
    </div>
</div>
