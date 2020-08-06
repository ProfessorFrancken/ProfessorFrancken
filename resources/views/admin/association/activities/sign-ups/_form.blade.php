<div class="row">
    <div class="col-6">

        @if ($signUp->member)
            {!!
                   Form::hidden(
                       'member_id',
                       $signUp->member_id,
                       ['class' => 'member_id']
                   )
            !!}
        @else
            <div class="form-group">
                <label for="member">Member</label>
                {!!
                       Form::text(
                           'member',
                           null,
                           ['class' => 'form-control member', 'placeholder' => 'Member', 'id' => 'member']
                       )
                !!}
                {!!
                       Form::hidden(
                           'member_id',
                           null,
                           ['class' => 'member_id']
                       )
                !!}
            </div>
        @endif

        <div class="form-group">
            <label for="plus_ones">Plus ones</label>
            {!!
                   Form::number(
                       'plus_ones',
                       0,
                       ['class' => 'form-control', 'id' => 'plus_ones']
                   )
            !!}
        </div>



        @if ($activity->signUpSettings->ask_for_dietary_wishes)
            <div class="form-group">
                <label for="dietary_wishes">Dietary wishes</label>
                {!!
                       Form::text(
                           'dietary_wishes',
                           null,
                           ['class' => 'form-control', 'id' => 'dietary_wishes']
                       )
                !!}
            </div>
        @endif
        @if ($activity->signUpSettings->ask_for_drivers_license)
            <div class="form-group form-check">
                {!!
                       Form::checkbox(
                           'has_drivers_license',
                           true,
                           null,
                           ['class' => 'form-check-input', 'id' => 'has_drivers_license']
                       )
                !!}
                <label class="form-check-label" for="has_drivers_license">
                    Has drivers license
                </label>
            </div>
        @endif
    </div>
    <div class="col-6">
        <div class="form-group">
            <label for="notes">Board notes</label>
            {!!
                   Form::textarea(
                       'notes',
                       null,
                       ['class' => 'form-control', 'id' => 'notes', 'rows' => 4]
                   )
            !!}
            <small class="form-text text-muted">
                Use this field to keep track of any notes related to this member.
            </small>
        </div>
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
