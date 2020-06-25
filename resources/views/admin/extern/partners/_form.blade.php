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

        <div class="form-group">
            <label for="status">Partner status</label>
            {!! Form::select('status', $statuses, null, ['class' =>'form-control', 'id' => 'status']) !!}
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
            <div class="form-group">
                <label for="add-partner-logo" class="btn btn-block btn-sm btn-primary mb-0">
                    <i class="fas fa-upload"></i>
                    Partner logo
                </label>
                {!! Form::file('logo', ['class' => 'sr-only form-control-file', 'id' => 'add-partner-logo']) !!}

                <small  class="form-text text-muted">
                    We will use this logo when displaying the partner's logo in the company profiles pages.
                </small>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
 (function() {
     var loadFile = function(event) {
         console.log(event);
         var reader = new FileReader();
         reader.onload = function(){
             var output = document.getElementById('partner-logo');
             output.src = reader.result;
             console.log(output);
         };
         reader.readAsDataURL(event.target.files[0]);
     };

     var addPartnerLogo = document.getElementById('add-partner-logo');
     addPartnerLogo.addEventListener('change', loadFile);

     console.log()
     var partnerLogo = document.getElementById('partner-logo');
     partnerLogo.addEventListener('click', function() {
         addPartnerLogo.click();
     });
 })()
</script>
@endpush
