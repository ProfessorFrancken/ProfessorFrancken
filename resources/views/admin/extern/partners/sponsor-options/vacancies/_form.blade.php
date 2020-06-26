<div class="form-group">
    <label for="title">Title</label>
    {!!
       Form::text(
           'title',
           null,
           ['class' => 'form-control', 'placeholder' => 'Senior Engineer', 'id' => 'title']
       )
    !!}
</div>

<div class="form-group">
    <label for="description">Description</label>
    {!!
       Form::textarea(
           'description',
           null,
           ['class' => 'form-control', 'placeholder' => 'Doing engineering things', 'id' => 'description', 'rows' => 3]
       )
    !!}
</div>

<div class="form-group">
    <label for="sector_id">Sector</label>
    {!! Form::select('sector_id', $sectors, $vacancy->sector_id ?? $partner->sector_id, ['class' =>'form-control', 'id' => 'sector_id']) !!}
</div>

<div class="form-group">
    <label for="type">Type</label>
    {!! Form::select('type', $types, null, ['class' =>'form-control', 'id' => 'type']) !!}
</div>

<div class="form-group">
    <label for="vacancy_url">Vacancy url</label>
    {!! Form::text('vacancy_url', $partner->refferal_url, ['class' => 'form-control', 'placeholder' => 'https://scriptcie.nl', 'id' => 'vacancy_url']) !!}
    <small class="form-text text-muted">
        If no url was provided you may use the partner's website.
    </small>
</div>
