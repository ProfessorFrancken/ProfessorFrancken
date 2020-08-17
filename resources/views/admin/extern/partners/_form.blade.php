<div class="row">
    <div class="col">
        <x-forms.text name="name" label="Name" placeholder="S[ck]rip(t|t?c)ie In[ck]" />
        <x-forms.select name="sector_id" label="Sector" :options="$sectors" />
    </div>
    <div class="col">
        <x-forms.select name="status" label="Partner status" :options="$statuses" />
        <x-forms.date
            name="last_contract_ends_at"
            label="(Last) Contract ends at"
            :value="optional($partner->last_contract_ends_at)->format('Y-m-d')"
        >
            <x-slot name="help">
                Use this field to keep track of partners with an active contract.
            </x-slot>
        </x-forms.date>
    </div>
    <div class="col">
        <x-forms.text name="homepage_url" label="Homepage url" placeholder="https://scriptcie.nl" />
        <x-forms.text name="referral_url" label="Referral url" placeholder="https://scriptcie.nl">
            <x-slot name="help">
                The refferal url is used when linking to the partner's website in our footer, company profile etc.
                Partners can use this to determine the amount of trafick that they receive from out website.
            </x-slot>
        </x-forms.text>
    </div>
    <div class="col">
        <div class="d-flex flex-column justify-content-end h-100">
            <div>
                <img
                    id="partner-logo"
                    alt="Logo of the partner"
                    src="{{ optional($partner)->logo }}"
                    class="mb-3 img-fluid rounded"
                    style="object-fit: cover"
                />
            </div>

            <x-forms.image-upload
                name="logo"
                label="Partner logo"
                output-image-id="partner-logo"
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

@include('admin.extern.partners._contact_details_form', ['partner' => $partner])
