<div class="row">
    <div class="col-sm-8">
        <div class="form-group">
            <label for="firstname">Name</label>
            <div class="row">
                <div class="col-sm-6">
                    {!! Form::text('firstname', null, ['placeholder' => 'Firstname', 'class' => 'form-control', 'required']) !!}
                </div>
                <div class="col-sm-6">
                    {!! Form::text('surname', null, ['placeholder' => 'Surname', 'class' => 'form-control', 'required']) !!}
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="mother-tongue">Mother tongue</label>
                    {!! Form::text('mother-tongue', null, ['placeholder' => 'Dutch', 'class' => 'form-control', 'required']) !!}
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="birthdate">Birthdate</label>
                    {!! Form::date('birthdate', null, ['placeholder' => 'yyyy-mm-dd', 'class' => 'form-control']) !!}
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="row">
                <div class="col-sm-6">
                    <label for="birthdate">Gender</label>
                    <div>
                        <label class="radio-inline">
                            {!! Form::radio('gender', 'female') !!}
                            Female
                        </label>
                        <label class="radio-inline">
                            {!! Form::radio('gender', 'male') !!}
                            Male
                        </label>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="col-md-3">

        <div class="row">
            <div class="col-3 col-sm-4 col-md-12">
                <img id="profilePicture" alt="" src="/images/person.png" style="cursor: pointer;" class="img-fluid w-100"/>
            </div>

            <div class="col-9 col-sm-8">
                <div class="form-group">
                    <label for="exampleInputFile">Profile picture (optional)</label>

                    <input type="file" class="form-control-file" name="profile-picture" id="addProfilePicture">
                </div>
            </div>
        </div>

    </div>
</div>

<script>
  var loadFile = function(event) {
    var reader = new FileReader();
    reader.onload = function(){
      var output = document.getElementById('profilePicture');
      output.src = reader.result;
    };
      console.log(event);
    reader.readAsDataURL(event.target.files[0]);
  };

 var addProfilePicture = document.querySelector('#addProfilePicture');
 addProfilePicture.addEventListener('change', loadFile);

 var profilePicture = document.getElementById('profilePicture');
 profilePicture.addEventListener('click', function() {
     addProfilePicture.click();
 });


</script>
