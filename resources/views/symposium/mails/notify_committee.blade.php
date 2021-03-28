@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @include('symposium.mails._header', ['symposium' => $participant->symposium])
    @endslot

    {{-- Body --}}
# Dear committee,

You've received a new sign up from <strong>{{ $fullname }}</strong>, which means that <strong>{{ $who_needs_to_take_an_adt }}</strong> deserves a learning opportunity, as is tradition.

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
