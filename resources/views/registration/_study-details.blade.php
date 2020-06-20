<div class="form-group row">
    <div class="col-sm-8">
        <label for="student-number">Student number</label>
        {!!
           Form::text(
               'student_number',
               null,
               [
                   'placeholder' => 'Student number',
                   'class' => 'form-control',
                   'required'
               ]
           )
        !!}
        @error('stdent_number')
        <p class="invalid-feedback">
            {{ $message  }}
        </p>
        @enderror
    </div>
</div>

<ul class="list-unstyled studies">
    @foreach (range(0, $amountOfStudies) as $number)
        <li>
            <div class="form-group row">
                <div class="col-sm-3">
                    <label for="study_name[${number}]">Study</label>
                    {!!
                       Form::text(
                           "study_name[${number}]",
                           null,
                           [
                               'placeholder' => 'Bsc Applied Physics',
                               'class' => 'form-control',
                               'required'
                           ]
                       )
                    !!}
                    @error('study_name[${number}]')
                    <p class="invalid-feedback">
                        {{ $message  }}
                    </p>
                    @enderror
                </div>
                <div class="col-sm-3">
                    <label for="study_starting_date[${number}]">Starting date</label>
                    {!!
                       Form::input(
                           'month',
                           "study_starting_date[${number}]",
                           null,
                           [
                               'placeholder' => 'yyyy-mm',
                               'class' => 'form-control',
                               'required'
                           ]
                       )
                    !!}
                    @error('study_starting_date[${number}]')
                    <p class="invalid-feedback">
                        {{ $message  }}
                    </p>
                    @enderror
                </div>
                <div class="col-sm-3">
                    <label for="study_graduation_date[${number}]">Graduation date (optional)</label>
                    {!!
                       Form::input(
                           'month',
                           "study_graduation_date[${number}]",
                           null,
                           [
                               'placeholder' => 'yyyy-mm',
                               'class' => 'form-control',
                           ]
                       )
                    !!}
                    @error('study_graduation_date[${number}]')
                    <p class="invalid-feedback">
                        {{ $message  }}
                    </p>
                    @enderror
                </div>
            </div>
        </li>
    @endforeach
</ul>

<button class="btn btn-link" id="addAdditionalStudy">
    <i class="fa fa-plus-circle" aria-hidden="true"></i>
    Add another study
</button>
