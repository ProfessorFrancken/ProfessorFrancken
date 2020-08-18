@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
            T.F.V. 'Professor Francken'
        @endcomponent
    @endslot

    {{-- Body --}}
# Hi {{ $fullname }},


Your account has now been activated! Now you can log in to the website of our association T.F.V. 'Professor Francken'.

You can use this account to view your [latest expenses]({{ $expenses_url }}) at our association, [view photos]({{ $photos_url }}), [sign up to our activities]({{ $activities_url }}) as well as [update your profile]({{ $profile_url }})!

### Reset your password

To log in, please first set a password by clicking the button below.
Use your email, **{{ $email }}**

@component('mail::button', ['url' => $password_reset_url])
    Set your password
@endcomponent

If you face any problems, please let the board now and they will try to resolve them quickly.

We look forward to seeing you around Francken!


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
