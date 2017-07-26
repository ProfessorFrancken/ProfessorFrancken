<p>
    Although our association focusses on Applied Physics we also have members from other studies such as Physics, (applied) Mathematics, Astronomy and more.
    Additionally you might have enrolled for a double degree.
    We'd love to know more about your study as this will help us in organising relevant events for our members.
</p>
<div class="form-group row">
    <div class="col-sm-8">
        <label for="student-number">Student number</label>
        {!! Form::text('student-number', null, ['placeholder' => 'Student number', 'class' => 'form-control', 'required']) !!}
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
