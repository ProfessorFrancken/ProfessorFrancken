@extends('admin.layout')
@section('page-title', 'Accounts / Activate new account')

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <p>
                        Here you can see the currently activated accounts.
                        An account belongs to a member and can be used to do stuff on our website.
                        You can view an account to manually add permissions and roles, however it is unlikely that this is necessary as an account roles will be automatically get roles based on the committees its member is in.
                    </p>
                    {!! Form::model($account, ['url' => action([\Francken\Auth\Http\Controllers\Admin\AccountsController::class, 'store']), 'method' => 'psot', 'autocomplete' => 'new-password']) !!}

                    <div class="form-group">
                        <label for="member">Member</label>
                        {!! Form::text('member', optional($account->member)->fullName, ['class' => 'form-control member', 'placeholder' => 'Member', 'id' => 'member']) !!}
                        {!! Form::hidden('member_id', $account->member_id, ['class' => 'member-id']) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::checkbox('send_notification_email', true, null, ['id' => 'send_notification_email']); !!}
                        <label for="send_notification_email">Send notification email</label>
                    </div>

                    <button class="btn btn-primary">Activate</button>

                    {!! Form::close() !!}
                </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('css')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
@endpush
@push('scripts')
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<script type="text/javascript">
 $(document).ready(function () {
     var members = {!! json_encode($members) !!};
     var membersSource = members.map(function (member) {
         return {
             label: [member.voornaam, member.tussenvoegsel, member.achternaam].filter(function (val) { return val }).join(' '),
             id: member.id
         };
     });

     $('.member').autocomplete({
         source: membersSource,
         select: function (event, ui) {
             $('.member-id').val(ui.item.id);
         },
         minLength: 2
     });
 });
</script>
@endpush
