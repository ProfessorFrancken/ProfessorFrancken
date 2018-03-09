@component('layout.header._header_image')
    @slot('title')
        Experiences of a freshmen
    @endslot

    {{-- registration call to action --}}
    <div class="row align-items-center h-100">
        <div class="registration-cta__body col-md-5 offset-md-4 align-self-center">
            <h1>
                The study association for
                <strong>
                    engineering physics
                </strong>
                in Groningen
            </h1>
        </div>
        <div class="col-md-1 registration-cta__action">
            <a class="btn btn-primary" href="/register">Register</a>
        </div>
    </div>
@endcomponent
