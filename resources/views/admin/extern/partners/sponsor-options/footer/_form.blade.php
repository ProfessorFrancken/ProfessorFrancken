<div class="form-group form-check">
    {!!
       Form::checkbox(
           'is_enabled',
           true,
           $footer->is_enabled,
           ['class' => 'form-check-input', 'id' => 'is_enabled']
       )
    !!}
    <label class="form-check-label" for="is_enabled">Show on website</label>
</div>

<div class="form-group">
    <label for="referral_url">Referral url</label>
    {!!
       Form::text(
           'referral_url',
           $footer->referral_url ?? $partner->referral_url,
           ['class' => 'form-control', 'placeholder' => 'https://scriptcie.nl', 'id' => 'referral_url']
       )
    !!}

    <small  class="form-text text-muted">
        The refferal url is used when linking to the partner's website in our footer.
        Partners can use this to determine the amount of trafick that they receive from out website.
    </small>
</div>

<div class="d-flex flex-column justify-content-end h-100">
    <div>
        <img
            id="footer-logo"
            alt="Logo of the partner used in footer"
            src="{{ optional($footer)->logo }}"
            class="mb-3 img-fluid rounded"
            style="object-fit: cover"
        />
    </div>

    <x-forms.image-upload
        name="logo"
        label="Footer logo"
        output-image-id="footer-logo"
    >
        <x-slot name="help">
            <p class="form-text text-muted">
                We will use this logo when displaying the partner's logo in the footer.
                Images for the footer should have a size of 200x80 pixels and should not include any color.
            </p>
            <p class="form-text text-muted">
                if you're on linux you can use the following command to convert any image to a grayscale 200x80 image:
            </p>
            <pre>
                <code>convert optiver.png -background none -resize 200x80 -gravity center -extent 200x80 -colorspace Gray optiver-gray.png</code>
            </pre>
        </x-slot>
    </x-forms.image-upload>
</div>
