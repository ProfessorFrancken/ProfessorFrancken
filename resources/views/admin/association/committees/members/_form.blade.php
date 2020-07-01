<div class="row">
    <div class="form-group col">
        <label for="member">Member</label>
        {!!
           Form::text(
               'member',
               isset($member) ? $member->member->full_name : null,
               ['class' => 'form-control member', 'placeholder' => 'Member', 'id' => 'member']
           )
        !!}
        {!!
           Form::hidden(
               'member_id',
               isset($member) ? $member->member_id : null,
               ['class' => 'member_id']
           )
        !!}
    </div>
    <div class="form-group col">
        <label for="function">Function</label>
        {!! Form::text('function', null, ['class' => 'form-control', 'placeholder' => 'President', 'id' => 'function']) !!}
    </div>
    <div class="form-group col">
        <label>Install date</label>
        {!!
           Form::date(
               'installed_at',
               $committee->board->installed_at->format('Y-m-d'),
               ['class' => 'form-control', 'id' => 'installed_at']
           );
        !!}
        <small class="form-text text-muted">
            By defautl we've selected the install dater of the board, but you can ofcourse choose a different install date
        </small>
    </div>
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
