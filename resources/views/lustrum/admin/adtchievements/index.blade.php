@extends('admin.layout')
@section('page-title', 'Adtchievements')

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <p class="lead">
                        Lustrum adtchievements, ga meer adten!
                    </p>
                </div>

                <table class="table table-hover table-small table-striped">

                    <thead>
                        <tr>
                            <th>Title</th>
                            <th class="text-right">Points</th>
                            <th>Repeatable</th>
                            <th>Team effort</th>
                            <th>Hidden</th>
                            <th class="text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($adtchievements as $adtchievement)
                            <tr>
                                <td>
                                    {{ $adtchievement->title }}
                                </td>
                                <td class="text-right">
                                    {{ $adtchievement->points }}
                                </td>
                                <td>
                                    {{ $adtchievement->is_repeatable ? 'Yes' : 'No' }}
                                </td>
                                <td>
                                    {{ $adtchievement->is_team_effort ? 'Yes' : 'No' }}
                                </td>
                                <td>
                                    {{ $adtchievement->is_hidden ? 'Yes' : 'No' }}
                                </td>
                                <td>

                                    <a
                                        href="{{ action([\Francken\Lustrum\Http\Controllers\Admin\AdtchievementsController::class, 'edit'], $adtchievement->id) }}"
                                        class=""
                                    >
                                        Edit
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('actions')
    <div class="d-flex align-items-end">
        <a href="{{ action([\Francken\Lustrum\Http\Controllers\Admin\AdtchievementsController::class, 'create']) }}"
           class='btn btn-primary'
        >
            <i class="fas fa-plus"></i>
            Add a new adtchievement
        </a>
    </div>
@endsection
