<div class="col">
    <h4>Board members</h4>
    <div class="form-group">
        <p>

        </p>
        <label for="name">Name</label>
        {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'name']) !!}
    </div>

    <div class="form-group">
        <label for="title">Title</label>
        {!! Form::text('title', null, ['class' => 'form-control', 'id' => 'title']) !!}
    </div>

    <div class="form-group">
        <label for="name">Photo</label>
        {!! Form::file('board_mebmer[][photo]', ['class' => 'form-control-file', 'id' => 'photo']) !!}
    </div>

    <div class="form-group">
        <label for="name">Installed at</label>
        {!! Form::date('board_mebmer[][installed_at]', null, ['class' => 'form-control', 'id' => 'photo']) !!}
    </div>
    <button class="btn btn-outline-success">
        <i class="fas fa-plus"></i>
        Install member
    </button>
</div>
