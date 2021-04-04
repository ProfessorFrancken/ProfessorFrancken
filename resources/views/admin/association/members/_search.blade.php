<div class="card">
    <div class="card-header">
        <h4>Search</h4>
    </div>
    <div class="card-body">
        <form action="{{ action([\Francken\Association\Members\Http\Controllers\Admin\MembersController::class, 'index']) }}"
            method="GET"
            class="form"
        >
            <x-forms.text name="firstname" label="Firstname" :value="$request->firstname()" />
            <x-forms.text name="surname" label="Surname"  :value="$request->surname()"/>
            <x-forms.text name="email" label="Email"  :value="$request->email()"/>
            <x-forms.select name="study" label="Study" :options="$studies" :value="$request->study()" />
            <x-forms.select name="type" label="Member type" :options="$memberTypes" :value="$request->type()" />

            <x-forms.form-group name="search" formGroupClass="d-flex align-items-end">
                <button type="submit" class="btn btn-sm btn-primary mt-2">
                    <i class="fas fa-search"></i>
                    Apply filters
                </button>

                <a href="{{ action([\Francken\Association\Members\Http\Controllers\Admin\MembersController::class, 'index'], ['select' => $request->select()])  }}"
                    class="btn btn-sm btn-text text-primary"
                >
                    <i class="fas fa-times"></i>
                    Clear filters
                </a>
            </x-forms.form-group>

            {!! Form::hidden("select", $request->select()) !!}
        </form>
    </div>
</div>
