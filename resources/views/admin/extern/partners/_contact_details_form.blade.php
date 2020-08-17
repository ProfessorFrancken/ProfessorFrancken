<h4>Contact details</h4>

<div class="row">
    <div class="col-sm-12 col-md-4">
        <x-forms.email name="email" placeholder="email@example.com" :value="$contactDetails->email">
            <x-slot name="label">
                <i class="fas fa-envelope-open-text text-primary"></i>
                Email
            </x-slot>
        </x-forms.email>
    </div>
    <div class="col-md-4">
        <x-forms.text name="phone_number" placeholder="+31 50 363 4978" :value="$contactDetails->phone_number">
            <x-slot name="label">
                <i class="fas fa-mobile text-primary"></i>
                Phone number
            </x-slot>
        </x-forms.text>
    </div>

    <div class="col-sm-12">
        <h5 class="mt-3">
            <i class="fas fa-map-marker-alt"></i> Address
        </h5>
        <div class="row">
            <div class="col-sm-4">
                <x-forms.text
                    name="department"
                    label="Department"
                    :value="$contactDetails->department"
                />
            </div>
            <div class="col-sm-4">
                <x-forms.text
                    name="city"
                    label="City"
                    placeholder="Groningen"
                    :value="$contactDetails->city"
                />
            </div>
            <div class="col-sm-4">
                <x-forms.text
                    name="address"
                    label="Address"
                    placeholder="Nijenborgh 9"
                    :value="$contactDetails->address"
                />
            </div>
            <div class="col-sm-4">
                <x-forms.text
                    name="postal_code"
                    label="Postal code"
                    placeholder="9742 AG"
                    :value="$contactDetails->postal_code"
                />
            </div>
            <div class="col-sm-4">
                <x-forms.text
                    name="country"
                    label="Country"
                    placeholder="Netherlands"
                    :value="$contactDetails->country"
                />
            </div>
        </div>
    </div>
</div>
