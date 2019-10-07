@extends('admin.layout')
@section('page-title', $crew->name)

@section('content')
    <div class="card my-5">
        <div class="card-header">
            <h3>Adtchievements</h3>
        </div>

        <div class="card-body">
            {!!
               Form::model(
                   null,
                   [
                       'url' => action(
                           [
                               \Francken\Lustrum\Http\Controllers\Admin\PirateAdtchievementsController::class,
                               'store'
                           ],
                           ['pirateCrew' => $crew->slug]
                       ),
                       'method' => 'post'
                   ]
                )
            !!}

            @include('admin.association.boards._member-selection', ['name' => "adtchievement"])

            <div class="form-group">
                <label for="permission">Adtchievement</label>
                <select class="form-control" id="adtchievement" name="adtchievement_id">
                    @foreach ($adtchievements as $adtchievement)
                        <option value="{{ $adtchievement->id }}">
                            {{ $adtchievement->title }} ({{ $adtchievement->points }} points)
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="points">Points</label>
                {!! Form::number('points', null, ['class' => 'form-control', 'placeholder' => '', 'id' => 'points']) !!}
            </div>

            <div class="form-group">
                <label for="reason">Reason</label>
                {!! Form::text('reason', null, ['class' => 'form-control', 'placeholder' => '', 'id' => 'reason']) !!}
            </div>

            {!! Form::submit('Add adtchievement', ['class' => 'btn btn-outline-success']) !!}
            {!! Form::close() !!}
        </div>

        <table class="table table-hover table-small table-striped">

            <thead>
                <tr>
                    <th>Pirate</th>
                    <th>Adtchievement</th>
                    <th class="text-right">Points</th>
                    <th class="text-right">Date</th>
                    <th class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($crew->earnedAdtchievements as $earnedAdtchievement)
                    <tr>
                        <td>
                            {{ $earnedAdtchievement->pirate->name }}
                        </td>
                        <td>
                            {{ $earnedAdtchievement->adtchievement->title }}
                        </td>
                        <td class="text-right">
                            {{ $earnedAdtchievement->points }}
                        </td>
                        <td class="text-right">
                            {{ $earnedAdtchievement->created_at->diffForHumans() }}
                        </td>
                        <td class="text-right">
                            <form action="{{
                                          action(
                                          [\Francken\Lustrum\Http\Controllers\Admin\PirateAdtchievementsController::class, 'remove'],
                                          ['pirateCrew' => $crew->slug, 'adtchievement' => $earnedAdtchievement->id]
                                          )
                                          }}"
                                  class="form"
                                  method="post"
                            >
                                @method('DELETE')
                                @csrf
                                <button type="submit" class="btn btn-sm btn-outline-primary">
                                    Remove
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>


    <div class="card">
        <div class="card-header">
            <h3>Members</h3>
        </div>
        <div class="card-body">
            <ul>
                @foreach ($crew->crewMembers as $pirate)
                    <li>{{ $pirate->name }}</li>
                @endforeach
            </ul>
        </div>
        <div class="card-footer">
            {!!
               Form::model(
                   null,
                   [
                       'url' => action(
                           [
                               \Francken\Lustrum\Http\Controllers\Admin\PirateCrewController::class,
                               'store'
                           ],
                           ['pirateCrew' => $crew->slug]
                       ),
                       'method' => 'post'
                   ]
                )
            !!}

            @include('admin.association.boards._member-selection', ['name' => "pirate"])

            {!! Form::submit('Add member to crew', ['class' => 'btn btn-outline-success']) !!}
            {!! Form::close() !!}
        </div>
    </div>

@endsection

@section('actions')
    <div class="d-flex align-items-end">
    </div>
@endsection
