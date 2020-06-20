<h4>Studying from abroad?</h4>
<p class="text-muted">
    We would like to keep track of the amount of international members, please provide your nationality and indicate if you've got a Dutch high school diploma.
</p>
<div class="form-group mt-3 mb-0">
    <div class="form-check">
        {!!
           Form::checkbox(
               'no_dutch_high_school_diploma',
               true,
               false,
               [
                   'class' => 'form-check-input',
                   'id' => 'no_dutch_high_school_diploma',
               ]
           )
        !!}
        <label class="form-check-label" for="no_dutch_high_school_diploma">
            I don't have a Dutch high school diploma
        </label>
    </div>
    @error('no_dutch_high_school_diploma')
    <p class="invalid-feedback">
        {{ $message  }}
    </p>
    @enderror
</div>
<div class="form-group mb-0">
    <label for="nationality">Nationality</label>
    {!!
       Form::text(
           'nationality',
           '',
           [
               'class' => 'form-control',
               'placeholder' => 'Netherlands',
           ]
       )
    !!}
    @error('nationality')
    <p class="invalid-feedback">
        {{ $message  }}
    </p>
    @enderror
</div>

