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

            <div class="form-group">
                <label class="h5">
                    <i class="fas fa-envelope-open-text text-primary"></i>
                    Email
                </label>
                {!!
                       Form::email(
                           'email',
                           $member->email->toString(),
                           [
                               'placeholder' => 'email@example.com',
                               'class' => 'form-control' . ($errors->has('email') ? ' is-invalid' : ''),
                               'required'
                           ]
                       )
                !!}

                @error('email')
                <p class="invalid-feedback">
                    {{ $message  }}
                </p>
                @enderror
            </div>

            <div class="mt-2 mb-4 px-3 py-2 bg-light border rounded">
                <div class="form-check">
                    {!!
                           Form::checkbox(
                               'newsletter',
                               true,
                               $member->mailinglist_email,
                               ['class' => 'form-check-input', 'id' => 'newsletter']
                           )
                    !!}
                    <label class="form-check-label" for="newsletter">
                        Receive the bi-weekly newsletter
                    </label>
                </div>
            </div>

            <h5 class="mt-3">
                <i class="fas fa-map-marker-alt"></i>
                Address
            </h5>

            <div class="form-group">
                <label for="Address">Address</label>
                {!!
                       Form::text(
                           'address',
                           $member->address->address(),
                           [
                               'placeholder' => 'Nijenborgh 9',
                               'class' => 'form-control',
                           ]
                       )
                !!}
                @error('address')
                <p class="invalid-feedback">
                    {{ $message  }}
                </p>
                @enderror
            </div>

            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>City</label>
                        {!!
                               Form::text(
                                   'city',
                                   $member->address->city(),
                                   [
                                       'placeholder' => 'Groningen',
                                       'class' => 'form-control',
                                   ]
                               )
                        !!}

                        @error('city')
                        <p class="invalid-feedback">
                            {{ $message  }}
                        </p>
                        @enderror
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="postal_code">Postal code</label>
                        {!!
                               Form::text(
                                   'postal_code',
                                   $member->address->postalCode(),
                                   [
                                       'placeholder' => '9742 AG',
                                       'class' => 'form-control',
                                       'id' => 'postal_code',
                                   ]
                               )
                        !!}
                        @error('postal_code')
                        <p class="invalid-feedback">
                            {{ $message  }}
                        </p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="country">Country</label>
                {!!
                       Form::text(
                           'country',
                           $member->address->country(),
                           [
                               'placeholder' => 'Netherlands',
                               'class' => 'form-control',
                           ]
                       )
                !!}
                @error('country')
                <p class="invalid-feedback">
                    {{ $message  }}
                </p>
                @enderror
            </div>

            <div class="mt-2 mb-4 px-3 py-2 bg-light border rounded">
                <div class="form-check">
                    {!!
                           Form::checkbox(
                               'francken_vrij',
                               true,
                               $member->mailinglist_franckenvrij,
                               ['class' => 'form-check-input', 'id' => 'francken_vrij']
                           )
                    !!}
                    <label class="form-check-label" for="francken_vrij">
                        Receive the Francken Vrij
                    </label>
                </div>
            </div>

            <div class="form-group">
                <label for="phone_number" class="h5">
                        <i class="fas fa-mobile"></i>
                        Phone number
                </label>
                {!!
                       Form::text(
                           'phone_number',
                           null,
                           [
                               'placeholder' => '+31 50 363 4978',
                               'class' => 'form-control',
                               'id' => 'phone_number'
                           ]
                       )
                !!}
            </div>

        </div>
        <div class="card-footer">
            {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
        </div>
        {!! Form::close() !!}
    </div>
@endsection
