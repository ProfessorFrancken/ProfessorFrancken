@if ($partner->contactDetails->has_address)
    <div class="col">
        <h6 class="mb-0">
            <i class="fas fa-map-marker-alt"></i>
            Address
        </h6>

        <address>
            {{ $partner->contactDetails->department }}<br />
            {{ $partner->contactDetails->address }}<br />
            {{ $partner->contactDetails->postal_code }} {{ $partner->contactDetails->city }}<br />
            {{ $partner->contactDetails->country }}
        </address>
    </div>
@endif

@if ($partner->contactDetails->has_email)
    <div class="col">
        <h6 class="mb-0">
            <i class="fas fa-envelope-open-text text-primary"></i>
            Email
        </h6>
        <p>
            {{ $partner->contactDetails->email }}
        </p>
    </div>
@endif
@if ($partner->contactDetails->has_phone_number)
    <div class="col">
        <h6 class="mb-0">
            <i class="fas fa-mobile text-primary"></i>
            Phone number
        </h6>
        <p>
            {{ $partner->contactDetails->phone_number }}
        </p>
    </div>
@endif
