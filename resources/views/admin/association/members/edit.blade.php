@extends('admin.layout')
@section('page-title', 'Members / ' . $member->fullname . ' / Edit')

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                {!!
                       Form::model($member, [
                           'url' => action([\Francken\Association\Members\Http\Controllers\Admin\MembersController::class, 'update'], ['member' => $member]),
                           'method' => 'PUT',
                       ])
                !!}
                <div class="card-body">

                    @include('admin.association.members._form', ['member' => $member])

                </div>
                <div class="card-footer">
                    <x-forms.submit>Save</x-forms.submit>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
