@section('header-image-url', $header_image)

@component('layout.header._header_image')
    {{-- registration call to action --}}
    <div class="row align-items-center h-100 my-5 my-md-0">
        <div class="registration-cta__body col-md-9 offset-md-3 align-self-center">
            <h1>
                <strong>T.F.V. 'Professor Francken'</strong>
            </h1>
            <h2>
                The study association for
                <strong>
                    engineering physics
                </strong>
                in Groningen
            </h2>
            @guest
                <div class="d-inline-block border-top mb-4 mb-md-0 mt-4 pt-4 px-5 pr-md-0" style="border-width: 3px !important;">
                    <a class="btn btn-primary position-relative" href="/register" style="z-index: 1">Become a member</a>
                </div>
            @endguest
        </div>
    </div>
@endcomponent
