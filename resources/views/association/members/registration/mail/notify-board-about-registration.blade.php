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

@if ($comments !== null && $comments !== '')
They've added a comment / question:

> {{ $comments }}

Make sure to answer their comments / questions by sending an email to: <a href="malto: {{ $email }}">{{ $email }}</a>.
@endif

Kind regards,

The board of T.F.V. ‘Professor Francken’

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
