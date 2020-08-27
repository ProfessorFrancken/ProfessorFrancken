@extends('association.borrelcie.layout')

@section('content')
    <div class="card">
        <div class="card-body">
            <h2 class="section-header mb-3">
                Activate your borrelcie account
            </h2>
            <p>
                Do you want to keep track of anytimers, borrelcie statistics and more?
                Then go ahead and activate your own Borrelcie account.
                After activating your account your consumptions from the consumption counter ("Streep systeem") will be included in the borrelcie statistics.
            </p>
            <p>
                By clicking on activate below you agree to:
            </p>

            <ul>
                <li>
                    Include your consumptions in the Borrelcie statistics
                </li>
                <li>
                    You give out 1 anytimer to a random member<sup class="ml-1">*</sup>
                </li>
            </ul>

            <p class="mb-4">
                You are free to deactivate your account if you no longer want your statistics to be public amongst members.
            </p>

            <x-forms.form-button
                class="btn btn-primary"
                :action="action([\Francken\Association\Borrelcie\Http\BorrelcieAccountActivationController::class, 'store'])"
            >
                Activate your account
            </x-forms.form-button>


            <small class="form-text text-muted mt-3">
                * Only members who have activated their Borrelcie account will be included
            </small>
        </div>
    </div>
@endsection
