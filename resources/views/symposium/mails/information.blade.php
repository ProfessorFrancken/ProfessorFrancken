@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @include('symposium.mails._header', ['symposium' => $symposium]) @endslot

    {{-- Body --}}
# Hi {{ $fullname }},

Thank you once again for signing up for the Symposium 'In a materialistic world'.
With this email we would like to inform you about the location, dresscode and schedule of the symposium.

### The location: {{ $symposium->location }}

This year the Symposium is held at the <a href="{{ $symposium->location_google_maps_url }}" target="_blank">{{ $symposium->location }}</a>.
Click the link below to get travel directions.

@component('mail::button', ['url' => $symposium->location_google_maps_url])
    Travel directions to {{ $symposium->location }}
@endcomponent

### Colloquium points

By visiting the symposium you can earn 1 physics colloquium point.
The attendance list for the colloquium points can be found at the entrance of the venue.

### Dresscode

The dresscode for the symposium is business casual.

### Schedule

The doors of the symposium open at 09:00.
We hope to see you before the start of the official program at 9.25.
If this doesn't suit you, you are of course welcome to join at any later moment.

@component('mail::table')
| Time          |               |
| ------------- |:-------------|
@foreach ($schedule as $slot)
| <strong>{{ $slot['time'] }}</strong> | {{ $slot['title'] }} |
@endforeach
@endcomponent

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
