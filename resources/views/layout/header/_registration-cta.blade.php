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
            {{-- Members don't see the button, but it keeps its space so the header has the same height for everyone --}}
            <div @class(['d-inline-block border-top mb-4 mb-md-0 mt-4 pt-4 px-5 pr-md-0', 'invisible' => auth()->check()]) style="border-width: 3px !important;" @auth aria-hidden="true" @endauth>
                <a class="btn btn-primary position-relative" href="/register" style="z-index: 1">Become a member</a>
            </div>
        </div>
    </div>
@endcomponent
