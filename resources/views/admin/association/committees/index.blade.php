@extends('admin.layout')
@section('page-title', 'Committees')

@section('content')
    <div class="row">
        <div class="col-9">
            <div class="card">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th colspan="2">Committee</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($committees as $committee)
                            <tbody>
                                <tr class=" border-bottom-0">
                                    <td style="width: 200px;" class="align-middle">
                                        <img
                                            class="rounded ml-2 my-2"
                                            src="{{ $committee->logo }}"
                                            alt="Logo of {{ $committee->name }}"
                                            style="
                                                   width: 150px;
                                                   max-width: 150px;
                                                   max-height: 80px;
                                                   object-fit: contain;"
                                        />
                                    </td>
                                    <td>
                                        <a href="{{ action(
                                                    [\Francken\Association\Committees\Http\AdminCommitteesController::class, 'show'],
                                                    ['committee' => $committee, 'board' => $board]
                                                    ) }}"
                                        >
                                            <h4 class='d-flex flex-column h6'>
                                                <span>
                                                    {{ $committee->name }}
                                                </span>
                                                <small class="text-muted mt-1">
                                                    Last updated
                                                    {{ $committee->updated_at->diffForHumans() }}
                                                </small>
                                            </h4>
                                        </a>
                                        @if ($committee->email)
                                        <small class="mt-1">
                                            <a class="text-muted" href="malto: {{ $committee-> email }}">
                                                {{ $committee->email }}
                                            </a>
                                        </small>
                                        @endif
                                        @if ($committee->goal)
                                        <small class="mt-1">
                                            {{ $committee->goal }}
                                        </small>
                                        @endif
                                    </td>
                                </tr>
                                <tr class="border-top-0">
                                    <td colspan="2" class="border-top-0 bg-light">
                                        @foreach ($committee->committeeMembers() as $member)
                                            <span class="badge badge-light bg-white font-weight-light font-weight-light">
                                                {{ $member->member->fullname }}
                                            </span>
                                        @endforeach
                                    </td>
                                </tr>
                            </tbody>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-3">
            @include('admin.association.committees._continuable-committees', ['continueable_committees' => $continueable_committees])
        </div>
    </div>
@endsection

@section('actions')
    <div class="d-flex align-items-start">

        {!!
           Form::open(
               [
                   'url' => action(
                       [\Francken\Association\Committees\Http\AdminRedirectCommitteesController::class, 'index']
                   ),
                   'method' => 'get',
                   'class' => 'form-inline mr-3',
               ]
           )
        !!}
        <x-forms.select name="board_id" :value="$board->id" :options="$board_years">
            <x-slot name="label">
                <span class="mx-3">Board</span>
            </x-slot>
        </x-forms.select>

        <button class='btn btn-primary btn-sm ml-3'>
            <i class="fas fa-eye"></i>
            View
        </button>
        {!! Form::close() !!}

        <a href="{{ action([\Francken\Association\Committees\Http\AdminActiveMembersExportController::class, 'index'], ['board' => $board]) }}"
           class="btn btn-primary btn-sm mr-3"
        >
            <i class="fas fa-cloud-download-alt"></i>
            Export active members
        </a>

        <a href="{{ action([\Francken\Association\Committees\Http\AdminCommitteesController::class, 'create'], ['board' => $board]) }}"
           class="btn btn-primary btn-sm"
        >
            <i class="fas fa-plus"></i>
            Start a committee
        </a>
    </div>
@endsection
