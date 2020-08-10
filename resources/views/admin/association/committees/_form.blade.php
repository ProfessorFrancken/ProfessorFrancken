<div class="row">
    <div class="col">
        <div class="row">
<div class="col-3">
                <div class="d-flex flex-column justify-content-end h-100">
                    <div>
                        <img
                            id="committee-logo"
                            alt="Logo of the committee"
                            src="{{ optional($committee)->logo }}"
                            class="mb-3 img-fluid rounded"
                            style="object-fit: cover"
                        />
                    </div>
                    <div class="form-group">
                        <label for="add-committee-logo" class="btn btn-block btn-sm btn-primary mb-0">
                            <i class="fas fa-upload"></i>
                            Committee logo
                        </label>
                        {!! Form::file('logo', ['class' => 'sr-only form-control-file', 'id' => 'add-committee-logo']) !!}

                        <small  class="form-text text-muted">
                            We will use this logo when displaying the committee's logo in the company profiles pages.
                        </small>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label for="name">Name</label>
                    {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'S[ck]rip(t|t?c)ie', 'id' => 'name']) !!}
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    {!! Form::text('email', null, ['class' => 'form-control', 'placeholder' => 'kathinka@scriptcie.nl', 'id' => 'email']) !!}
                </div>

                <div class="form-group">
                    <label for="goal">Goal</label>
                    {!! Form::text('goal', null, ['class' => 'form-control', 'placeholder' => 'Digital anarchy at Francken', 'id' => 'goal']) !!}
                    <small class="form-text text-muted">
                        Fill in a short description of the committee.
                        This text is used as a description for the committee page and will be shown in google search results.
                    </small>
                </div>

                <div class="form-group form-check">
                    {!! Form::checkbox('is_public', true, null, ['class' => 'form-check-input', 'id' => 'is_public'])  !!}
                    <label class="form-check-label" for="is_public">Show committee page on website</label>
                </div>

                <div class="form-group">
                    <label for="parent_committee_id">
                        Parent committee
                    </label>
                    {!!
                       Form::select(
                           'parent_committee_id',
                           $parent_committees,
                           null,
                           ['class' => 'form-control', 'placeholder' => 'Select a committee from a previous board year', 'id' => 'parent_committee_id']
                       )
                    !!}
                    <small class="form-text text-muted">
                        Setting the parent committee to a pervious committee will allow us to suggest members for this committee based on its previous committee members.
                    </small>
                </div>
            </div>

            <div class='col-12'>
                <div class="d-flex flex-column justify-content-end h-100">
                    <div>
                        <img
                            id="committee-photo"
                            alt="Photo of the committee"
                            src="{{ optional($committee)->photo }}"
                            class="mb-3 img-fluid rounded"
                            style="object-fit: cover"
                        />
                    </div>
                    <div class="form-group">
                        <label for="add-committee-photo" class="btn btn-block btn-sm btn-primary mb-0">
                            <i class="fas fa-upload"></i>
                            Committee photo
                        </label>
                        {!! Form::file('photo', ['class' => 'sr-only form-control-file', 'id' => 'add-committee-photo']) !!}

                        <small  class="form-text text-muted">
                            We will use this photo when displaying the committee's photo in the company profiles pages.
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <x-forms.markdown />
    </div>
</div>

@push('scripts')
<script>
 (function() {
     var loadFile = function(event) {
         var reader = new FileReader();
         reader.onload = function(){
             var output = document.getElementById('committee-logo');
             output.src = reader.result;
         };
         reader.readAsDataURL(event.target.files[0]);
     };

     var addCommitteeLogo = document.getElementById('add-committee-logo');
     addCommitteeLogo.addEventListener('change', loadFile);

     var committeeLogo = document.getElementById('committee-logo');
     committeeLogo.addEventListener('click', function() {
         addCommitteeLogo.click();
     });
 })()
</script>

<script>
 (function() {
     var loadFile = function(event) {
         var reader = new FileReader();
         reader.onload = function(){
             var output = document.getElementById('committee-photo');
             output.src = reader.result;
         };
         reader.readAsDataURL(event.target.files[0]);
     };

     var addCommitteePhoto = document.getElementById('add-committee-photo');
     addCommitteePhoto.addEventListener('change', loadFile);

     var committeePhoto = document.getElementById('committee-photo');
     committeePhoto.addEventListener('click', function() {
         addCommitteePhoto.click();
     });
 })()
</script>
@endpush
