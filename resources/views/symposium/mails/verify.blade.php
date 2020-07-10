@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => config('app.url'), 'src' => url('/images/mail/symposium/in-a-materialistic-world.jpeg')])
            Symposium<br/>
            'Cognitive Matters - Physics of cognitive advancements'
        @endcomponent
    @endslot

    {{-- Body --}}
# Hi {{ $fullname }},

Thank you for signing up for the Symposium 'Cognitive Matters - Physics of cognitive advancements'.

### Verify your registration

Please verify your registration by clicking the link below.

@component('mail::button', ['url' => $url])
Verify registration
@endcomponent

### About the symposium

The symposium will be held on Wednesday the <strong>13th of May</strong> located at <a href="{{ $location_url }}" target="_blank">the Puddingfabriek</a> in Groningen.
We will gradually update the website with more information about speakers and the Symposium's schedule.

### Payment information

@if ($is_nnv_member && $is_francken_member)
Since you are both a member of Francken and the NNV you will receive a &euro;5,- discount, which means the symposium will cost you &euro;5,-.
@elseif ($is_nnv_member)
Since you are a member of the NNV you will receive a &euro;2,50 discount, which means the symposium will cost you &euro;7,50.
@elseif ($is_francken_member)
Since you are a member of Francken you will receive a &euro;2,50 discount, which means the symposium will cost you &euro;7,50.
@else
The price of the symposium is &euro;10,-.
@endif
@if ($pays_with_cash)
Since you have chosen to pay in cash you will have to pay at the entrance of the symposium.
@else
The entrance fee will be deducted from your bank account by the treasurer of  T.F.V. 'Professor Francken'.
@endif

We hope you will enjoy the symposium,<br>
Symposium committee 19'-20'

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
