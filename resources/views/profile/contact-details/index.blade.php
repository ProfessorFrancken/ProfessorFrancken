@extends('profile.layout')

@section('content')
    <h4 class="font-weight-bold section-header">
        <i class="fas fa-message"></i>
        Change contact details
    </h4>


    <div class="card my-3">
        {!!
               Form::model(
                   $member, [
                   'url' => action([\Francken\Association\Members\Http\ContactDetailsController::class, 'update']),
               ])
        !!}
        <div class="card-body">

            @method('PUT')

            <x-forms.email name="email" :value="$member->email->toString()">
                <x-slot name="label">
                    <span class="h5">
                        <i class="fas fa-envelope-open-text text-primary"></i>
                        Email
                    </span>
                </x-slot>
            </x-forms.email>

            <div class="mt-2 mb-4 px-3 py-2 bg-light border rounded">
                <x-forms.checkbox
                    name="newsletter"
                    label="Receive the bi-weekly newsletter"
                    form-group-class="mb-0"
                    :value="$member->mailinglist_email"
                />
            </div>

            <h5 class="mt-3">
                <i class="fas fa-map-marker-alt"></i>
                Address
            </h5>

            <x-forms.text
                name="address"
                label="Address"
                placeholder="Nijenborgh 9"
                :value="$member->address->address()"
            />

            <div class="row">
                <div class="col-sm-6">
                    <x-forms.text
                        name="city"
                        label="City"
                        placeholder="Groningen"
                        :value="$member->address->city()"
                    />
                </div>

                <div class="col-sm-6">
                    <x-forms.text
                        name="postal_code"
                        label="Postal code"
                        placeholder="9742 AG"
                        :value="$member->address->postalCode()"
                    />
                </div>
            </div>

            <x-forms.text
                name="country"
                label="Country"
                placeholder="Nijenborgh 9"
                :value="$member->address->country()"
            />

            <div class="mt-2 mb-4 px-3 py-2 bg-light border rounded">
                <x-forms.checkbox
                    name="francken_vrij"
                    label="Receive the Francken Vrij"
                    form-group-class="mb-0"
                    :value="$member->mailinglist_franckenvrij"
                />
            </div>

            <x-forms.text name="phone_number" placeholder="+31 50 363 4978">
                <x-slot name="label">
                    <span class="h5">
                        <i class="fas fa-mobile"></i>
                        Phone number
                    </span>
                </x-slot>
            </x-forms.text>
        </div>

        <div class="card-footer">
            <x-forms.submit>Save</x-forms.submit>
        </div>

        {!! Form::close() !!}
    </div>
@endsection
