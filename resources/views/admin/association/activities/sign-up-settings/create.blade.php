@extends('admin.layout')
@section('page-title', 'Activities / ' . $activity->name . '/ Add sign up settings')

@section('content')
    <div class="card">
        <div class="card-body">
            <x-forms.form
                :model="$activity"
                :url="action(
                    [\Francken\Association\Activities\Http\AdminSignUpSettingsController::class, 'store'],
                    ['activity' => $activity]
                )"
            >
                @include('admin.association.activities.sign-up-settings._form', ['committee' => $activity])

                <x-forms.submit text="Add sign up settings"/>
            </x-forms.form>
        </div>
    </div>
@endsection
