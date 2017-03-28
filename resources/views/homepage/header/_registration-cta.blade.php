@component('homepage.header._header_image')
    @slot('title')
        Experiences of a freshmen
    @endslot

    {{-- registration call to action --}}
    <div class="row align-items-center h-100">
        <div class="registration-cta__body col-md-4 offset-md-5 align-self-center">
            <h1>
                <strong>
                    Become part of
                </strong>
                <small>
                    the best<sup>*</sup> student association
                </small>
            </h1>

            <p class="small">
                *people tell us we are awesome
            </p>
        </div>
        <div class="col-md-1 registration-cta__action">
            <a class="btn btn-primary" href="/register">Register</a>
        </div>
    </div>
@endcomponent
