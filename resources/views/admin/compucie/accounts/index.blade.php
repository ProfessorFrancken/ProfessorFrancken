@extends('admin.layout')

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">

                    <h1 class="section-header">
                        Accounts
                    </h1>

                    <p>
                        Here you can see the currently activated accounts.
                        An account belongs to a member and can be used to do stuff on our website.
                        You can view an account to manually add permissions and roles, however it is unlikely that this is necessary as an account roles will be automatically get roles based on the committees its member is in.
                    </p>
                </div>

                <table class="table table-hover table-small">
                    <thead>
                        <tr>
                            <th>Email</th>
                            <th>Member id</th>
                            <th>Nr. roles</th>
                            <th>Nr. permissions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($accounts as $account)
                            <tr>
                                <td>
                                    <a href="{{ action([\Francken\Auth\Http\Controllers\Admin\AccountsController::class, 'show'], $account->id)}}"
                                       class="stretched-link"
                                    >
                                        {{ $account->email }}
                                    </a>
                                </td>
                                <td>
                                    {{ $account->member_id }}
                                </td>
                                <td>
                                    {{ $account->roles->count() }}
                                </td>
                                <td>
                                    {{ $account->permissions->count() }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{ $accounts->links() }}
            </div>
        </div>
    </div>
@endsection
