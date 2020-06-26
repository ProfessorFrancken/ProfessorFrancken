<h4>Contact details</h4>

<div class="row">
    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label>
                <i class="fas fa-envelope-open-text text-primary"></i>
                Email
            </label>
            {!!
               Form::email(
                   'email',
                   $contactDetails->email,
                   [
                       'placeholder' => 'email@example.com',
                       'class' => 'form-control',
                   ]
               )
            !!}

            @error('email')
            <p class="invalid-feedback">
                {{ $message  }}
            </p>
            @enderror
        </div>
    </div>
    <div class="col-md-4">
        <label for="phone_number">
            <i class="fas fa-mobile text-primary"></i>
            Phone number
        </label>
        {!!
           Form::text(
               'phone_number',
               $contactDetails->phone_number,
               [
                   'placeholder' => '+31 50 363 4978',
                   'class' => 'form-control',
                   'id' => 'phone_number'
               ]
           )
        !!}
    </div>
    <div class="col-sm-12">
        <h5 class="mt-3">
            <i class="fas fa-map-marker-alt"></i> Address
        </h5>
        <div class="row">
            <div class="col-sm-4">
                <div class="form-group">
                    <label>Department</label>
                    {!!
                       Form::text(
                           'department',
                           $contactDetails->department,
                           [
                               'class' => 'form-control',
                               'id' => 'department',
                           ]
                       )
                    !!}

                    @error('department')
                    <p class="invalid-feedback">
                        {{ $message  }}
                    </p>
                    @enderror
                </div>
            </div>

            <div class="col-sm-4">
                <div class="form-group">
                    <label>City</label>
                    {!!
                       Form::text(
                           'city',
                           $contactDetails->city,
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

            <div class="col-sm-4">
                <div class="form-group">
                    <label for="Address">Address</label>
                    {!!
                       Form::text(
                           'address',
                           $contactDetails->address,
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
            </div>

            <div class="col-sm-4">
                <div class="form-group">
                    <label for="postal_code">Postal code</label>
                    {!!
                       Form::text(
                           'postal_code',
                           $contactDetails->postal_code,
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
            <div class="col-sm-4">
                <div class="form-group">
                    <label for="country">Country</label>
                    {!!
                       Form::text(
                           'country',
                           $contactDetails->country,
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
            </div>
        </div>
    </div>
</div>
