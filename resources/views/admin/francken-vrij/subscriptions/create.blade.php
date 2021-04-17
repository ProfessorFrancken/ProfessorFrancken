@extends('admin.layout')
@section('page-title', 'Subscriptions / Create')

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    {!!
                       Form::model($subscription, [
                           'url' => action([\Francken\Association\FranckenVrij\Http\AdminSubscriptionsController::class, 'store']),
                           'method' => 'POST',
                       ])
                    !!}

                        {{-- TODO: allow setting via ?member_id so we can creaete it from member view--}}
                        <x-forms-autocomplete-member :value_id="$member->id" :value="$member->fullname" />

                        @include('admin.francken-vrij.subscriptions._form', ['subscription' => $subscription])

                        <x-forms.submit>Save</x-forms.submit>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
