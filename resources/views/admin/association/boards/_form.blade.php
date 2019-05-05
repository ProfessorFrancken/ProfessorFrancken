<h4>Board</h4>
<div class="form-group">
    <label for="name">Board name</label>
    {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Hè Watt?', 'id' => 'name']) !!}
</div>

<div class="form-group">
    <label for="name">Board photo</label>
    {!! Form::file('photo', ['class' => 'form-control-file', 'id' => 'photo']) !!}
</div>

<div class="form-group">
    <label for="photo_position">Photo position</label>
    {!!
       Form::select('photo_position', $photo_positions, null, ['class' => 'form-control', 'id' => 'photo_position']);
    !!}
</div>

<div class="form-group">
    <label for="installed_at">Install datae</label>
    {!!
       Form::date('installed_at', null, ['class' => 'form-control', 'id' => 'installed_at']);
    !!}
</div>
