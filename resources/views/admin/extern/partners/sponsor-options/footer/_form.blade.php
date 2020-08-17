<x-forms.checkbox name="is_enabled" label="Show on website" :value="$footer->is_enabled" />
<x-forms.text
    name="referral_url"
    label="Referral url"
    placeholder="https://scriptcie.nl"
    :value="$footer->referral_url ?? $partner->referral_url"
>
    <x-slot name="help">
        The refferal url is used when linking to the partner's website in our footer.
        Partners can use this to determine the amount of trafick that they receive from out website.
    </x-slot>
</x-forms.text>

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
