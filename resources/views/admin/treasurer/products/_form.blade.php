<div class="row">
    <div class="col">
        <x-forms.text name="name" label="Name" />
        <x-forms.number name="price" label="Price">
            <x-slot name="help">
                <small  class="form-text text-muted">
                    Price in cents (i.e. if the price is &euro;1,33, fill in 130)
                </small>
            </x-slot>
        </x-forms.number>
        <x-forms.select name="category" label="Category" :options="['Beer' => 'Beer', 'Food' => 'Food', 'Soda' => 'Soda']" />
        <x-forms.checkbox name="available" label="Available" />
        <x-forms.text name="position" label="Position" help="Determines the position in the consumption counter" />
    </div>

    <div class="col">
        <div class="d-flex flex-column justify-content-end h-100">
            <div>
                <img
                    id="product-photo"
                    alt="Photo of the product"
                    src="{{ optional($product)->photo_url }}"
                    class="mb-3 img-fluid rounded"
                    style="object-fit: cover"
                />
            </div>

            <x-forms.image-upload
                name="photo"
                label="Photo"
                output-image-id="product-photo"
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
