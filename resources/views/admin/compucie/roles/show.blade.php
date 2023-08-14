@extends('admin.layout')
@section('page-title', 'Roles / ' . $role->name)

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">

                    <h1 class="section-header">
                        {{ $role->name }}
                    </h1>
                </div>
                <div class="card-body">
                    <h3 class="section-header">
                        Permissions
                    </h3>

                    <form action="{{ action([\Francken\Auth\Http\Controllers\Admin\RolePermissionsController::class, 'store'], [$role->id]) }}"
                          class="form"
                          method="post"
                    >
                        @csrf
                        <div class="form-group">
                            <div class="d-flex align-items-end">
                            <label for="permission">Add permission</label>
                                <div class="mx-3">
                                <select class="form-control" id="permission" name="permission_id">
                                    @foreach ($permissions as $permission)
                                        @if (! $role->hasPermissionTo($permission))
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

                    <p>The table below shows the direct permissions for this role. <strong>It does not contain indirect permissions from roles</strong></p>
                </div>
                <table class="table table-hover table-small">
                    <thead>
                        <tr>
                            <th>Permission</th>
                            <th class="text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($role->permissions as $permission)
                            <tr>
                                <td>
                                    {{ $permission->name }}
                                </td>
                                <td class="text-right">
                                    <form action="{{ action([\Francken\Auth\Http\Controllers\Admin\RolePermissionsController::class, 'remove'], [$role->id, $permission->id]) }}"
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
            <div class="card">
                <div class="card-body">
                    <h3>Accounts with this role</h3>

                    @if ($account->member)
                        <ul>
                            @foreach ($role->users as $account)
                                <li>
                                    <a href={{ action([\Francken\Auth\Http\Controllers\Admin\AccountsController::class, 'show'], ['account' => $account])  }}>
                                        {{ $account->member->fullname }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
