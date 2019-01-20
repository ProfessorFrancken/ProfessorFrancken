@inject('companies', "Francken\Application\Career\CompanyRepository")

<div class="sponsors text-center">
    <h5>T.F.V. 'Professor Francken' is sponsored by</h5>

    <div class="row">
        @foreach ($footer as $company)
            <div class="my-3 col-6 col-sm-4 col-md-3 col-lg-2 col-lx-1">
                <a href="{{ $company['footer-link'] }}">
                    <img class="img-fluid" src="{{ $company['footer-logo'] }}" alt="Logo of {{ $company['name'] }}">
                </a>
            </div>
        @endforeach
    </div>

    <p>
        &copy; Copyright {{ date('Y') }}
    </p>
</div>
