@extends('layout.two-column-layout')
@section('title', 'Synchronize our calendar')
@section('description', "Synchronize the calendar of T.F.V. 'Professor Francken' with your own online agenda.")

@section('content')
    <h1>Synchronize our calendar</h1>
    <p>
        Synchronize our calendar by importing its url into your preferred external calendar.
    </p>
    <p class="bg-white p-3 text-left rounded d-flex justify-content-between align-items-center">
        <code id="calendar-url">{{ $calendarUrl }}</code>
        <button id="copy-calendar-url" class="btn btn-text font-weight-light text-muted">Copy</button>
    </p>
    <h3>Google Calendar</h3>
    <p>
        To import our calendar into your Google Calendar account, go to <code>Settings > Add Calendar > From URL</code> and paste the url from above.
    </p>

    <h3>Outlook Calendar</h3>
    <p>
        To add our calendar on Outlook, on the top menu bar, click <code>Add Calendar</code>.
        Then click <code>From Internet</code>, paste the URL and name your calendar.
        Click save. That’s it!
    </p>
@endsection

@push('scripts')
<script>
 // This script allows us to easily copy the Google Calendar url
 const copyToClipboard = str => {
     const el = document.createElement('textarea');  // Create a <textarea> element
     el.value = str;                                 // Set its value to the string that you want copied
     el.setAttribute('readonly', '');                // Make it readonly to be tamper-proof
     el.style.position = 'absolute';
     el.style.left = '-9999px';                      // Move outside the screen to make it invisible
     document.body.appendChild(el);                  // Append the <textarea> element to the HTML document
     const selected =
         document.getSelection().rangeCount > 0        // Check if there is any content selected previously
                                            ? document.getSelection().getRangeAt(0)     // Store selection if found
                                            : false;                                    // Mark as false to know no selection existed before
     el.select();                                    // Select the <textarea> content
     document.execCommand('copy');                   // Copy - only works as a result of a user action (e.g. click events)
     document.body.removeChild(el);                  // Remove the <textarea> element
     if (selected) {                                 // If a selection existed before copying
         document.getSelection().removeAllRanges();    // Unselect everything on the HTML document
         document.getSelection().addRange(selected);   // Restore the original selection
     }
 };

 $(document).ready(function () {
     $('#copy-calendar-url').click(function (e) {
         e.preventDefault();
         copyToClipboard($('#calendar-url').text())
     })
 });
</script>
@endpush

@section('aside')
<div class="agenda">
    <h3 class="section-header agenda-header">
        Calendar
    </h3>
    <ul class="agenda-list list-unstyled">
        <div class="agenda-item d-flex justify-content-between font-weight-bold mb-2 pb-2">
            @include('association.activities._sidebar-years', ['years' => $visibleYears])
        </div>
        @foreach ($months as $month)
            @include('association.activities._sidebar-month', [
                'year' => $selectedYear, 'month' => $month
            ])
        @endforeach
    </ul>
</div>
@endsection
