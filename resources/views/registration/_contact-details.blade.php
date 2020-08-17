<div class="row">
    <div class="col-sm-12 col-md-8">
        <x-forms.email name="email" placeholder="email@example.com" required>
            <x-slot name="label">
                <i class="fas fa-envelope-open-text text-primary"></i> Email
            </x-slot>
        </x-forms.email>
    </div>
    <div class="col-sm-12">
        <h5 class="mt-3">
            <i class="fas fa-map-marker-alt"></i> Get the Franken Vrij
            <small class="text-muted">(optional)</small>
        </h5>
        <p>
            Each year we publish three issues of our popular science magazine, the <a href="/association/francken-vrij">Francken Vrij</a>.
            Once you've been registered, we will send you a printed copy whenever a new issue of our magazine is released.
            You will also receive our biweekly newsletter to your email informing you of events at our association and university.
        </p>
        <div class="row">
            <div class="col-sm-4">
                <x-forms.text name="city" label="City" placeholder="Groningen" />
            </div>

            <div class="col-sm-4">
                <x-forms.text name="address" label="Address" placeholder="Nijenborgh 9" />
            </div>

            <div class="col-sm-4">
                <x-forms.text name="postal_code" label="Postal code" placeholder="9742 AG" />
            </div>
            <div class="col-sm-4">
                <x-forms.text name="country" label="Country" placeholder="Netherlands" />
            </div>
        </div>
    </div>

    <div class="col-sm-12">
        <div class="form-group">
            <h5 class="mt-3">
                <i class="fab fa-whatsapp"></i> Join our WhatsApp broadcast
                <small class="text-muted">(optional)</small>
            </h5>
            <p>
                Would you like to stay informed about upcoming activities?
                Provide your phone number so that we can add you to our WhatsApp braodcast.
            </p>
            <div class="row">
                <div class="col-md-4">
                    <x-forms.text name="phone_number" label="Phone number" placeholder="+31 50 363 4978" />
                </div>
            </div>
        </div>
    </div>
</div>
