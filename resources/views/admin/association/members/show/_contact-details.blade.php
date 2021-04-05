<h5 class="mb-3 mt-4">Contact details</h5>
<div class="row">
    <div class="col col-md-4">
        <h6 class="">
            <i class="fas fa-fw fa-envelope-open-text"></i>
            Email
        </h6>
        <div class="my-3 bg-light p-3">
            <p class="mb-0">
                {{ $member->email }}
            </p>
        </div>
    </div>

    @if($member->address)
        <div class="col col-md-4">
            <h6>
                <i class="fas fa-fw fa-map-marker-alt"></i>
                Address
            </h6>

            <div class="my-3 bg-light p-3">
                <address class="my-0">
                    {{ $member->address->city() }}
                    <br/>
                    {{ $member->address->postalCode() }} {{ $member->address->address() }}
                    <br/>
                    {{ $member->address->country() }}
                </address>
            </div>
        </div>
    @endif
    @if($member->phone_number)
        <div class="col col-md-4">
            <h6>
                <i class="fas fa-fw fa-mobile"></i>
                Phonenumber
            </h6>

            <div class="my-3 bg-light p-3">
                <p class="my-0">
                    {{ $member->phone_number }}
                </p>
            </div>
        </div>
    @endif
</div>
