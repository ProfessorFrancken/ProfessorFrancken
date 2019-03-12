@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => config('app.url'), 'src' => url('/images/mail/symposium/in-a-materialistic-world.jpeg')])
            Symposium<br/>
            'In a materialistic world'
        @endcomponent
    @endslot

    {{-- Body --}}
# Lieve commissie,

    Er is een nieuwe inschrijving van <strong>{{ $full_name }}</strong>, wat betekent dat <strong>{{ $who_needs_to_take_an_adt }}</strong> een leermomentje krijgt.

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
