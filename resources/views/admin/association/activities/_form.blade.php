<div class="alert alert-warning" role="alert">
    Making changes to activities via this ui is currently disabled. Use the Google Calendar to change a description, date etc.
    We update the activities hourly based on the current google calendar.
</div>

<div class="row">
    <div class="col-6">
        <h4 class="font-weight-bold">
            Activity
        </h4>
        <div class="row">
            <div class="form-group col-6">
                <label for="name">Name</label>
                {!!
                       Form::text(
                           'name',
                           null,
                           ['class' => 'form-control', 'placeholder' => 'S[ck]rip(t|t?c)ie', 'id' => 'name', 'disabled' => 'disabled']
                       )
                !!}
            </div>

            <div class="form-group col-6">
                <label for="location">Location</label>
                {!!
                       Form::text(
                           'location',
                           null,
                           ['class' => 'form-control', 'placeholder' => 'S[ck]rip(t|t?c)ie', 'id' => 'location', 'disabled' => 'disabled']
                       )
                !!}
            </div>
        </div>

        <div class="row">
            <div class="form-group col-6">
                <label for="start_date">Start date</label>
                {!!
                       Form::datetime(
                           'start_date',
                           null,
                           ['class' =>'form-control', 'id' => 'start_date', 'disabled' => 'disabled']
                       )
                !!}
            </div>

            <div class="form-group col-6">
                <label for="end_date">End date</label>
                {!!
                       Form::datetime(
                           'end_date',
                           null,
                           ['class' =>'form-control', 'id' => 'end_date', 'disabled' => 'disabled']
                       )
                !!}
            </div>

        </div>

        <div class="form-group">
            <label for="summary">Summary</label>
            {!!
                   Form::text(
                       'summary',
                       null,
                       ['class' => 'form-control', 'id' => 'summary', 'disabled' => 'disabled']
                   )
            !!}
            <small class="form-text text-muted">
                This text is shown in the agenda on the front page.
            </small>
        </div>
    </div>
    <div class="col-6">
        <x-forms.markdown />
    </div>
</div>
