@extends('admin.layout')
@section('page-title', 'Lustrum / Adtchievements / ' . $adtchievement->title)

@section('content')
    <div class="card">
        <div class="card-body">
            {!!
               Form::model($adtchievement, [
                   'url' => action([\Francken\Lustrum\Http\Controllers\Admin\AdtchievementsController::class, 'update'], $adtchievement->id),
                   'method' => 'POST',
               ])
            !!}
            @method('PUT')
            @include('lustrum.admin.adtchievements._form', ['adtchievement' => $adtchievement])

            {!! Form::submit('Save', ['class' => 'btn btn-outline-success']) !!}
            {!! Form::close() !!}
        </div>
    </div>
@endsection
