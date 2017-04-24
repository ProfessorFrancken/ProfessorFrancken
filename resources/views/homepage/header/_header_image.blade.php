<style>
 .header-image::before {
     background-image: url(@yield('header-image-url', '/images/header/board-buitengewoon.jpg')) !important;
 }
</style>
<div class="stop-overflow">
    <div class="header-image">

        {{--
            Add a bit of margin to make the container in the header image align with
            the default containers
        --}}
        <div class="header-image__align">

            <div class="header-image__body container">
                {{ $slot }}
            </div>

        </div>
    </div>
</div>
