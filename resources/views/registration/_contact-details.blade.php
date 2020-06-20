<div class="row">
    <div class="col-sm-12 col-md-8">
        <div class="form-group">
            <label><i class="fas fa-envelope-open-text text-primary"></i> Email</label>
            {!!
               Form::email(
                   'email',
                   null,
                   [
                       'placeholder' => 'email@example.com',
                       'class' => 'form-control', //
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
    </div>
    <div class="col-sm-12">
        <h5 class="mt-3">
            <i class="fas fa-map-marker-alt"></i> Get the Franken Vrij
        </h5>
        <p>
            Each year we publish three issues of our popular science magazine, the <a href="/association/francken-vrij">Francken Vrij</a>.
            Once you've been registered, we will send you a printed copy whenever a new issue of our magazine is released.
            You will also receive our biweekly newsletter to your email informing you of events at our association and university.
        </p>
        <div class="row">
            <div class="col-sm-4">
                <div class="form-group">
                    <label>City</label>
                    {!!
                       Form::text(
                           'city',
                           null,
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
                           null,
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
                    <label for="zip-code">ZIP code</label>
                    {!!
                       Form::text(
                           'zip_code',
                           null,
                           [
                               'placeholder' => '9742 AG',
                               'class' => 'form-control',
                           ]
                       )
                    !!}
                    @error('zip_code')
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
                           null,
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

    <div class="col-sm-12">
        <div class="form-group">
            <h5 class="mt-3">
                <i class="fab fa-whatsapp"></i> Join our WhatsApp broadcast
            </h5>
            <p>
                Would you like to stay informed about upcoming activities?
                Provide your phone number so that we can add you to our WhatsApp braodcast.
            </p>
            <div class="row">
                <div class="col-md-4">

                    <label for="phone_number">
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
        </div>
    </div>
</div>
