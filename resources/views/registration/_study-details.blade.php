<p>
    Although our association focusses on Applied Physics we also have members from other studies such as Physics, (applied) Mathematics, Astronomy and more.
    Additionally you might have enrolled for a double degree.
    We'd love to know more about your study as this will help us in organising relevant events for our members.
    <!-- We would love to know which study you're doing and whether you've finished other studeis before. -->
    <!-- This will help us in organising relevant events for our members -->
</p>
        <div class="form-group row">
            <div class="col-sm-8">
                <label for="student-number">Student number</label>
                {!! Form::text('student-number', null, ['placeholder' => 'Student number', 'class' => 'form-control', 'required']) !!}
            </div>
            <div class="col-sm-8">
            </div>
        </div>

        <ul class="list-unstyled studies">
            <li>
                <div class="form-group row">
                    <div class="col-sm-3">
                        <label for="study">Study</label>
                        {!! Form::text('study-name', null, ['placeholder' => 'Bsc Applied Physics', 'class' => 'form-control', 'required']) !!}
                    </div>
                    <div class="col-sm-3">
                        <label for="starting-date-study">Starting date</label>
                        {!! Form::input('month', 'study-starting-date', null, ['placeholder' => 'yyyy-mm', 'class' => 'form-control', 'required']) !!}
                    </div>
                    <div class="col-sm-3">
                        <label for="starting-date-study">Graduation date (optional)</label>
                        {!! Form::input('month', 'study-graduation-date', null, ['placeholder' => 'yyyy-mm', 'class' => 'form-control']) !!}
                    </div>
                </div>
            </li>
        </ul>

        {{--

        We will probably switch to a React component

        <button class="btn btn-link" id="addAdditionalStudy">
            <i class="fa fa-plus-circle" aria-hidden="true"></i>
            Add another study
        </button>
        --}}

<script>
 var addStudy = document.querySelector('#addAdditionalStudy');
 var studies = document.querySelector('.studies');

 function newStudyHtml()
 {
     return `<div class="form-group row">
                    <div class="col-sm-3">
                        <label for="study">Study</label>
                        <input placeholder="Bsc Applied Physics" class="form-control" name="studies[]name[]" type="text" required>
                    </div>
                    <div class="col-sm-3">
                        <label for="starting-date-study">Starting date</label>
                        <input placeholder="yyyy-mm" class="form-control" name="studies[]starting-date[]" type="month" required>
                    </div>
                    <div class="col-sm-3">
                        <label for="starting-date-study">Graduation date (optional)</label>
                        <input placeholder="yyyy-mm" class="form-control" name="studies[]graduation-date[]" type="month">
                    </div>
                    <div class="col-sm-3 d-flex">
                        <button class="remove-study btn btn-secondary align-self-end">
                            <i class="fa fa-times" aria-hidden="true"></i>
                            Cancel
                        </button>
                    </div>
                </div>`;
 }

 addStudy.addEventListener('click', function(e) {
     e.preventDefault();
     e.stopPropagation();

     var li = document.createElement("li");
     li.innerHTML = newStudyHtml();
     var button = li.querySelector('.remove-study');
     button.addEventListener('click', function(btnEvent) {
         btnEvent.preventDefault();
         btnEvent.stopPropagation();
         li.parentNode.removeChild(li);
     });

     studies.appendChild(li);

     var study = li.querySelector('input[name="study"]');
     study.focus();
 });

</script>
