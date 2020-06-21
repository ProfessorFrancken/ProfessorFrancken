@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
            T.F.V. 'Professor Francken'
        @endcomponent
    @endslot

    {{-- Body --}}
# Hi {{ $fullname }},

Thank you for requesting registration with T.F.V ‘Professor Francken’!
Once your registration has been reviewed, your membership will be confirmed and a personal account will be activated.

Click the link below to verify your email and confirm your personal details.
Please inform the board if any information is incorrect, or if there are any other problems.

@component('mail::button', ['url' => $email_verification_url])
Verify registration
@endcomponent

In the meantime, let us introduce you to our wonderful association.
T.F.V. ‘Professor Francken’ was named after Groningen’s first professor of applied physics and has welcomed over 900 members.
A variety of activities are hosted for all members throughout the year, including borrels, excursions, and a Buixie - a week-long trip to a European destination.

Be sure to swing by the Franckenroom for a cup of coffee or a game of klaverjas, and check out the many committees you can join!

Stay up to date with upcoming activities and news by subscribing to our WhatsApp broadcast (+31 50 363 4978) and follow us on Instagram ([@tfvprofessorfrancken](https://www.instagram.com/tfvprofessorfrancken/)).


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
