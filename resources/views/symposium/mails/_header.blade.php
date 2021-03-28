@component('mail::header', ['url' => config('app.url'), 'src' => $symposium->logo])
    Symposium<br/>
    '{{ $symposium->name  }}'
@endcomponent
