@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
            T.F.V. 'Professor Francken'
        @endcomponent
    @endslot

    {{-- Body --}}
# Hi {{ $fullname }},

Your membership has been approved!

Your account will soon be activated, after which you can log in to the website of our association T.F.V. 'Professor Francken'.

Moreover, you will now receive our fortnightly newsletter, in which we will inform you of all the upcoming activities and the latest news.

We look forward to seeing you around Francken!

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
