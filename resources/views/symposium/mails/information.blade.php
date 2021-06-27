@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @include('symposium.mails._header', ['symposium' => $symposium])
    @endslot

    {{-- Body --}}
Dear {{ $fullname }},

Thank you once again for signing up for the Symposium 'Cognitive Matters - Physics of cognitive advancements'. With this email we would like to inform you about the schedule of the symposium and the Zoom link.

### Zoom

This year the symposium will take place online using the platform Zoom. Click the link below to join the Zoom call. We kindly ask you to keep your microphone muted at all times, unless you have a question or comment of course.

@component('mail::button', ['url' =>  ''])
    Link to Zoom
@endcomponent

### Schedule

The Zoom call will open at 10:00 at Wednesday. The official program will start at 10:15 with a talk by our chair of the day, Prof. dr. Beatriz Noheda. If this doesn't suit you, you are of course welcome to join at any later moment. You can find more information about the program in the attached programme ().

@component('mail::button', ['url' =>  'https://professorfrancken.nl/uploads/association/symposia/cognitive-matters-programme.pdf'])
    Progamme booklet
@endcomponent

### Colloquium points

By visiting the symposium you can earn physics colloquium points. One colloquium point is rewarded for attending two talks and two colloquium points are rewarded for attending the whole day. Please email the committee if you want to make use of this, so that we can track your attendance.

### Lunch and borrelbox

If you have ordered lunch and/or a borrelbox these will be delivered to your home. The borrelbox will be delivered today by the committee. The lunch will be delivered by Broodje Ben between 10:30 and 13:00 on the day of the symposium.

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
