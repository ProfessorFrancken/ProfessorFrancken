<div class="row">
    <div class="col">
        <x-forms.text name="color" label="Color" />
    </div>

    <div class="col">
        <div class="d-flex flex-column justify-content-end h-100">
            <div>
                <img
                    id="splash-photo"
                    alt="Photo of the product"
                    src="{{ optional($extra)->splash_url }}"
                    class="mb-3 img-fluid rounded"
                    style="object-fit: cover"
                />
            </div>

            <x-forms.image-upload
                name="splash_photo"
                label="Splash photo"
                output-image-id="splash-photo"
            >
                <x-slot name="help">
                    <small  class="form-text text-muted">
                    We will use this logo when displaying the partner's logo in the company profiles pages.
                    </small>
                </x-slot>
            </x-forms.image-upload>
        </div>
    </div>
</div>
