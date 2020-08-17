@extends('admin.layout')
@section('page-title', 'Committees / ' . $board->board_name->toString() . ' / ' . $committee->name . ' / Members / ' . $member->member->fullname)

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body bg-light">
                    {!!
                       Form::model($member, [
                           'url' => action(
                               [\Francken\Association\Committees\Http\AdminCommitteeMembersController::class, 'update'] ,
                               ['board' => $board, 'committee' => $committee, 'member' => $member]
                           ),
                           'method' => 'PUT',
                           'enctype' => 'multipart/form-data'
                       ])
                    !!}
                        @include('admin.association.committees.members._form', ['committee' => $committee, 'member' => $member])

                        <x-forms.submit>Save</x-forms.submit>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
    {!!
       Form::model(
           $committee,
           [
               'url' => action(
                   [\Francken\Association\Committees\Http\AdminCommitteeMembersController::class, 'destroy'],
                   ['board' => $board, 'committee' => $committee, 'member' => $member]
               ),
               'method' => 'post'
           ]
       )
    !!}
    @method('DELETE')
    <p class="mt-2 text-muted d-flex align-items-center justify-content-end">
        Click <button
                  class="btn btn-text px-1"
                  onclick='return confirm("Are you sure you want to remove this committee member?");'
              >here</button> to remove this committee member.
    </p>
    {!! Form::close() !!}
@endsection
