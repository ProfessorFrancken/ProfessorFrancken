@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => config('app.url'), 'src' => '/images/mail/symposium/in-a-materialistic-world.jpeg'])
            Symposium<br/>
            'In a materialistic world'
        @endcomponent
    @endslot

    {{-- Body --}}
# Hi {{ $participant->full_name }},

Thank you for signing up for the Symposium 'In a materialistic world'.
Please verify your registration by clicking the link below.

@component('mail::button', ['url' => $url])
Verify registration
@endcomponent

We will gradually update the website with more information about speakers and the Symposium's schedule.

Thanks,<br>
Symposium committee 18'-19'

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
