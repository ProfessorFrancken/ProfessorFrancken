@extends('admin.layout')
@section('page-title', 'Accounts / ' . $account->email)

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <h3 class="section-header">
                        Roles
                    </h3>

                    <p>
                        You can manually add or remove a role from this account.
                        Note however that if a member joins or leaves a committee / board, then their roles will be changed automatically.
                    </p>
                </div>
                <table class="table table-hover table-small">
                    <thead>
                        <tr>
                            <th>Role</th>
                            <th class="text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($roles as $role)
                            <tr>
                                <td>
                                    {{ $role->name }}
                                </td>
                                <td class="text-right">
                                    @if ( ! $account->hasRole($role->name))
                                        <form action="{{ action([\Francken\Auth\Http\Controllers\Admin\AccountRolesController::class, 'store'], [$account->id, $role->id]) }}"
                                              class="form"
                                              method="post"
                                        >
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-primary">Add</button>
                                        </form>
                                    @else
                                        <form action="{{ action([\Francken\Auth\Http\Controllers\Admin\AccountRolesController::class, 'remove'], [$account->id, $role->id]) }}"
                                              class="form"
                                              method="post"
                                        >
                                            @method('DELETE')
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-primary">Remove</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="card-body">
                    <h3 class="section-header">
                        Permissions
                    </h3>

                    <form action="{{ action([\Francken\Auth\Http\Controllers\Admin\AccountPermissionsController::class, 'store'], [$account->id]) }}"
                          class="form"
                          method="post"
                    >
                        @csrf
                        <div class="form-group">
                            <div class="d-flex align-items-end">
                            <label for="permission">Add direct permission</label>
                                <div class="mx-3">
                                <select class="form-control" id="permission" name="permission_id">
                                    @foreach ($permissions as $permission)
                                        @if (! $account->hasDirectPermission($permission))
                                            <option value="{{ $permission->id }}">{{ $permission->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                </div>
                                <button type="submit" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-plus"></i>Add
                                </button>
                            </div>
                        </div>
                    </form>

                    <p>The table below shows the direct permissions for this account. <strong>It does not contain indirect permissions from roles</strong></p>
                </div>
                <table class="table table-hover table-small">
                    <thead>
                        <tr>
                            <th>Permission</th>
                            <th class="text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($account->permissions as $permission)
                            <tr>
                                <td>
                                    {{ $permission->name }}
                                </td>
                                <td class="text-right">
                                    <form action="{{ action([\Francken\Auth\Http\Controllers\Admin\AccountPermissionsController::class, 'remove'], [$account->id, $permission->id]) }}"
                                          class="form"
                                          method="post"
                                    >
                                        @method('DELETE')
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-primary">Remove</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="card-body">
                </div>
            </div>
        </div>

        <div class="col-lg-4">

        </div>
    </div>
@endsection
