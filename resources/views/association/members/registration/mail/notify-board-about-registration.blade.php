@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
            T.F.V. 'Professor Francken'
        @endcomponent
    @endslot

    {{-- Body --}}
# Hoi,

{{ $fullname}} has submitted a registration request, check their details [here]({{ $registration_details_url }}).

Kind regards,

The 36th board of T.F.V. ‘Professor Francken’

    {{-- Subcopy --}}
    @isset($subcopy)
        @slot('subcopy')
            @component('mail::subcopy')
                {{ $subcopy }}
            @endcomponent
        @endslot
    @endisset

    {{-- Footer --}}
    @slot('footer')
        @component('mail::footer')
            {{ config('app.name') }}.
        @endcomponent
    @endslot
@endcomponent
