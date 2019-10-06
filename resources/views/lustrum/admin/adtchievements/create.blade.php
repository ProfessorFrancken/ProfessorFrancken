@extends('admin.layout')
@section('page-title', 'Lustrum / Adtchievements / Add a new adtchievement')

@section('content')
    <div class="card">
        <div class="card-body">
            {!!
               Form::model($adtchievement, [
                   'url' => action([\Francken\Lustrum\Http\Controllers\Admin\AdtchievementsController::class, 'store']),
                   'method' => 'POST',
               ])
            !!}
            @include('lustrum.admin.adtchievements._form', ['adtchievement' => $adtchievement])

            {!! Form::submit('Add', ['class' => 'btn btn-outline-success']) !!}
            {!! Form::close() !!}
        </div>
    </div>
@endsection
