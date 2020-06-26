<div class="form-group">
    <label for="member">Member</label>
    {!!
       Form::text(
           'member',
           optional($alumnus->member)->full_name,
           ['class' => 'form-control member', 'placeholder' => 'Member', 'id' => 'member']
       )
    !!}
    {!!
       Form::hidden(
           'member_id',
           $alumnus->member_id,
           ['class' => 'member_id']
       )
    !!}
</div>
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

@push('css')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
@endpush
@push('scripts')
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<script type="text/javascript">
 $(document).ready(function () {
     var members = {!! json_encode($members) !!};
     console.log(members);
     var membersSource = members.map(function (member) {
         return {
             label: [member.voornaam, member.tussenvoegsel, member.achternaam].filter(function (val) { return val }).join(' '),
             id: member.id
         };
     });

     $('.member').autocomplete({
         source: membersSource,
         select: function (event, ui) {
             $('.member_id').val(ui.item.id);
         },
         minLength: 2
     });
 });
</script>
@endpush
