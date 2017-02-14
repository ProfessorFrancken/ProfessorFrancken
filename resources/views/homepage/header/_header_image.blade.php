@if (isset($image))
    <style>
     .header__registration-cta::before {
         background-image: url({{ $image }}) !important;
     }
    </style>
@endif
<div class="overflowwing">
    <div class="header__registration-cta {{ $headerImageClass or '' }}">
        <div class="registration-cta container h-100">
            <div class="row align-items-center h-100">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>
