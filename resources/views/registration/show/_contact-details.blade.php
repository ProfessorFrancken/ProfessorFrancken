<h5 class="mt-4 mx-2">
    <i class="fas fa-address-card"></i>
    Contact details
</h5>
<div class="bg-light p-3">
    <p class="mb-0">
        <i class="fas fa-envelope-open-text"></i>
        {{ $registration->email->toString() }}

        @if ($registration->email_verified_at === null)
            <small class="text-danger font-weight-bold">(not yet verified)</small>
        @endif
    </p>
    @if ($registration->address)
        <address class="mb-0 mt-2">
            <i class="fas fa-map-marker-alt"></i>
            {{ $registration->city }}
            <br/>
            {{ $registration->postal_code }} {{ $registration->address }}
            <br/>
            {{ $registration->country }}
        </address>
    @endif
    @if ($registration->phone_number !== null)
        <p class="mb-0 mt-2">
            <i class="fas fa-mobile"></i>
            {{ $registration->phone_number }}
        </p>
    @endif
</div>
