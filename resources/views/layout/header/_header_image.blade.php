<style>
 .header-image::before {
     background-image: url({{ banner_image($__env->yieldContent('header-image-url', '/uploads/images/boards/2022-2023/fusion.jpg'), []) }}) !important;
 }
</style>
<div class="stop-overflow">
    <div class="header-image d-flex align-items-center justify-content-center" style="box-shadow: inset 0.5rem -0.5rem 1rem rgba(0,0,0,.125) !important">

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
