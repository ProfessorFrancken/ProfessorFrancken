{{--
    On edit show a dropdown that indicates the privacy setting of this section
--}}
<li class="profile-section d-flex border">
    <div class="profile-section__icon d-flex flex-column justify-content-between align-items-center px-4 pt-3">
        <i class="{{ $icon  }} fa-fw fa-2x text-white"></i>
    </div>
    <div class="profile-section__body w-100 p-3 d-flex flex-column justify-content-center">
        {{ $slot }}
    </div>
</li>
