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

                    <x-forms-autocomplete-member :members="$members" />

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
