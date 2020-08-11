<div class="row">
    <div class="col">
        <div class="form-group">
            <label for="name">Name</label>
            {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'S[ck]rip(t|t?c)ie In[ck]', 'id' => 'name']) !!}
        </div>

        <div class="form-group">
            <label for="sector_id">Sector</label>
            {!! Form::select('sector_id', $sectors, null, ['class' =>'form-control', 'id' => 'sector_id']) !!}
        </div>
    </div>
    <div class="col">
        <div class="form-group">
            <label for="status">Partner status</label>
            {!! Form::select('status', $statuses, null, ['class' =>'form-control', 'id' => 'status']) !!}
        </div>

        <div class="form-group">
            <label for="last_contract_ends_at">(Last) Contract ends at</label>
            {!! Form::date('last_contract_ends_at', optional($partner->last_contract_ends_at)->format('Y-m-d'), ['class' =>'form-control', 'id' => 'last_contract_ends_at']) !!}
            <small class="form-text text-muted">
                Use this field to keep track of partners with an active contract.
            </small>
        </div>
    </div>
    <div class="col">
        <div class="form-group">
            <label for="homepage_url">Homepage url</label>
            {!! Form::text('homepage_url', null, ['class' => 'form-control', 'placeholder' => 'https://scriptcie.nl', 'id' => 'homepage_url']) !!}
        </div>

        <div class="form-group">
            <label for="referral_url">Referral url</label>
            {!! Form::text('referral_url', null, ['class' => 'form-control', 'placeholder' => 'https://scriptcie.nl', 'id' => 'referral_url']) !!}

            <small  class="form-text text-muted">
                The refferal url is used when linking to the partner's website in our footer, company profile etc.
                Partners can use this to determine the amount of trafick that they receive from out website.
            </small>
        </div>
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
