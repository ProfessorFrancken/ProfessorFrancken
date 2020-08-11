<x-forms-autocomplete-member
    :value="isset($alumnus) ? optional($alumnus->member)->fullname : null"
    :value-id="isset($alumnus) ? optional($alumnus->member)->id : null"
/>

<div class="form-group">
    <label for="position">Position / job title</label>
    {!!
       Form::text(
           "position",
           $alumnus->position,
           ['class' => 'form-control', 'id' => 'position']
       )
    !!}
</div>
<div class="form-group">
    <label for="started_position_at">Started position at</label>
    {!!
       Form::date(
           "started_position_at",
           optional($alumnus->started_position_at)->format('Y-m-d'),
           ['class' => 'form-control', 'id' => 'started_position_at']
       );
    !!}
</div>
<div class="form-group">
    <label for="stopped_position_at">Stopped position at</label>
    {!!
       Form::date(
           "stopped_position_at",
           optional($alumnus->stopped_position_at)->format('Y-m-d'),
           ['class' => 'form-control', 'id' => 'stopped_position_at']
       );
    !!}
</div>

<div class="form-group">
    <label for="notes">Notes</label>
    {!!
       Form::textarea(
           'notes',
           null,
           ['class' => 'form-control', 'id' => 'notes', 'rows' => 3]
       )
    !!}
    <small class="form-text text-muted">
        Keep specific notes for this alumnus.
    </small>
</div>
