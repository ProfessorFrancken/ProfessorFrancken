@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @include('symposium.mails._header', ['symposium' => $symposium])
    @endslot

    {{-- Body --}}
# Hi {{ $fullname }},

Thank you for signing up for the Symposium '{{ $symposium->name }}'.

### Verify your registration

Please verify your registration by clicking the link below.

@component('mail::button', ['url' => $url])
Verify registration
@endcomponent

### About the symposium

The symposium will be held on {{ $symposium->start_date->format("l")  }} the <strong>{{ $symposium->start_date->format("j")  }}th of {{ $symposium->start_date->format("F") }}</strong> and will be held online with potential limited live viewing at Zernike campus.
We will gradually update the website with more information about speakers and the Symposium's schedule.

@include('symposium.mails._footer', ['symposium' => $participant->symposium])

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
