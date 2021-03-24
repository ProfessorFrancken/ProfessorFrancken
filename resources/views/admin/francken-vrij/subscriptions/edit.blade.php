@extends('admin.layout')
@section('page-title', 'Subscriptions / ' . $subscription->member->fullname . ' / Edit')

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    {!!
                       Form::model($subscription, [
                           'url' => action([\Francken\Association\FranckenVrij\Http\AdminSubscriptionsController::class, 'update'], ['subscription' => $subscription]),
                           'method' => 'PUT',
                           'enctype' => 'multipart/form-data'
                       ])
                    !!}

                        @include('admin.francken-vrij.subscriptions._form', ['subscription' => $subscription])

                        <x-forms.submit>Save</x-forms.submit>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
