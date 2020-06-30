<div class="card mt-4">
    <div class="card-body">
        <h4 class="font-weight-bold">
            <i class="fas fa-key"></i>
            Website Permissions
        </h4>
        <p>
            Members installed to this committee are given the following permissions, based on the role "{{ $committee->role->name }}".
        </p>
        <ul>
            @foreach ($committee->permissions as $permission)
                <li>{{ $permission->name }}</li>
            @endforeach
        </ul>
    </div>
</div>
