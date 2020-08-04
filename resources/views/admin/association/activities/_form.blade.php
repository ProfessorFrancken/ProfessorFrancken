<div class="alert alert-warning" role="alert">
    Making changes to activities via this ui is currently disabled. Use the Google Calendar to change a description, date etc.
    We update the activities hourly based on the current google calendar.
</div>

<div class="row">
    <div class="col">
        <div class="form-group">
            <label for="name">Name</label>
            {!!
                   Form::text(
                       'name',
                       null,
                       ['class' => 'form-control', 'placeholder' => 'S[ck]rip(t|t?c)ie', 'id' => 'name', 'disabled' => 'disabled']
                   )
            !!}
        </div>

        <div class="form-group">
            <label for="summary">Summary</label>
            {!!
                   Form::text(
                       'summary',
                       null,
                       ['class' => 'form-control', 'placeholder' => 'S[ck]rip(t|t?c)ie', 'id' => 'summary', 'disabled' => 'disabled']
                   )
            !!}
        </div>

        <div class="form-group">
            <label for="location">Location</label>
            {!!
                   Form::text(
                       'location',
                       null,
                       ['class' => 'form-control', 'placeholder' => 'S[ck]rip(t|t?c)ie', 'id' => 'location', 'disabled' => 'disabled']
                   )
            !!}
        </div>

        <div class="form-group">
            <label for="start_date">Start date</label>
            {!!
                   Form::datetime(
                       'start_date',
                       null,
                       ['class' =>'form-control', 'id' => 'start_date', 'disabled' => 'disabled']
                   )
            !!}
        </div>

        <div class="form-group">
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
</div>

<div class="row d-flex align-items-stretch">
    <div class="col">
        <div class="form-group">
            <label for="source_content">Content</label>
            {!!
                   Form::textarea(
                       'source_content',
                       null,
                       ['class' => 'form-control', 'id' => 'source_content', 'disabled' => 'disabled']
                   )
            !!}
            <small class="form-text text-muted">
                Use <a href="https://github.com/adam-p/markdown-here/wiki/Markdown-Cheatsheet" target="_blank">
                Markdown</a> to format the activity page.
            </small>
        </div>
    </div>
    <div class="col-md-6 d-none">
        <div style="overflow-y: scroll" class="card">
            <div class="card-body" id="preview">
                {!! $activity->compiled_content !!}
            </div>
        </div>
    </div>
</div>
