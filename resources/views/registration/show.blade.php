@extends('layout.one-column-layout')

@section('content')
    @if ($registration->email_verified_at === null)
        <div class="alert alert-warning my-5">
            We have sent you a confirmation email to <a href="malto: {{ $registration->email->toString() }}">{{ $registration->email->toString() }}</a>.
            Please verify your email by clicking the link in the email.
        </div>
    @endif

    <h1 class="section-header section-header--centered">
        Hi {{ $registration->fullname->toString() }}, thank you for registering!
    </h1>

    <p class="lead text-center">
        Your registration is being reviewed by one of our board members.
        Below your registration details are shown, if something is missing or incorrect please let us know by emailing to <a href="malto: board@professorfrancken.nl">board@professorfrancken.nl</a>.
    </p>

    <div class="bg-white p-4 rounded text-primary mt-5">
        <div class="d-flex justify-content-between">
            <h4>
                <strong>{{ $registration->fullname->toString() }}</strong> ({{ $registration->initials }} {{ $registration->surname }})
            </h4>
            <div class="text-right d-flex justify-content-between">
                <p class="text-muted mx-3">
                    @if ($registration->gender === \Francken\Association\Members\Gender::FEMALE)
                        <i class="fas fa-venus"></i>
                    @elseif ($registration->gender === \Francken\Association\Members\Gender::MALE)
                        <i class="fas fa-mars"></i>
                    @else
                        {{ $registration->gender }}
                    @endif
                </p>
                <p class="text-muted ml-3">
                    <i class="fas fa-birthday-cake"></i>
                    {{ $registration->birthdate->format('Y-m-d') }}
                </p>
            </div>
        </div>

        <h5 class="mt-4 mx-2">
            <i class="fas fa-address-card"></i>
            Contact details
        </h5>
        <div class="bg-light p-3">
            <p class="mb-0">
                <i class="fas fa-envelope-open-text"></i>
                {{ $registration->email->toString() }}

                @if ($registration->email_verified_at === null)
                    <small class="text-danger font-weight-bold">(not yet verified)</small>
                @endif
            </p>
            @if ($registration->address)
                <address class="mb-0 mt-2">
                    <i class="fas fa-map-marker-alt"></i>
                    {{ $registration->city }}
                    <br/>
                    {{ $registration->postal_code }} {{ $registration->address }}
                    <br/>
                    {{ $registration->country }}
                </address>
            @endif
            @if ($registration->phone_number !== null)
                <p class="mb-0 mt-2">
                    <i class="fas fa-mobile"></i>
                    {{ $registration->phone_number }}
                </p>
            @endif
        </div>

        <h5 class="mt-4 mx-2">
            <i class="fas fa-graduation-cap"></i>
            Study details
            <small class="text-muted" title="Student number">
                (Student number: {{ $registration->student_number }})
            </small>
        </h5>
        <div class="bg-light p-3">
            <ul class="list-unstyled mb-0">
                @foreach ($registration->studies as $study)
                    <li>
                        <strong>
                            {{ $study->study() }}
                        </strong>
                        ({{
                        $study->startDate()->format('Y-m')
                        }}{{
                        ($study->graduationDate() !== null) ? "- {$study->graduationDate()->format('Y-md')}" : ""
                        }})
                    </li>
                @endforeach

            </ul>
        </div>

        <h5 class="mt-4 mx-2">
            <i class="fas fa-money-check-alt" aria-hidden="true"></i>
            Billing details
        </h5>
        <div class="bg-light p-3">
            @if ($registration->paymentDetails->iban() !== null)
                <p>
                    <strong>IBAN</strong>
                    {{ $registration->paymentDetails->iban() }}
                </p>
                @if ($registration->paymentDetails->bic() !== null)
                    <p>
                        <strong>BIC</strong>
                        {{ $registration->paymentDetails->bic() }}
                    </p>
                @endif

                <p class="mb-1">
                    @if ($registration->paymentDetails->deductAdditionalCosts())
                        <i class="fas fa-check font-weight-bold"></i> Costs from activities and buying food & drinks will be deducted from your bank account
                    @else
                        <i class="fas fa-times font-weight-bold"></i> Costs from activities and buying food & drinks will have to be paid manually
                    @endif
                </p>
            @else
                <p class="mb-1">
                    You did not provide an IBAN when registering your membership.
                    Please let us know your IBAN
                </p>
            @endif
        </div>

        @if (1 == 2)
        <h5 class="mt-4 mx-2">
            <i class="fas fa-comments"></i>
            Other
        </h5>
        <div class="bg-light p-3">
            <blockquote class="blockquote bg-white p-3 rounded">
                <p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.</p>
            </blockquote>
            <p class="text-muted">
                A board member will email you about your questions and / or comments
            </p>
            <hr />
            <p>
                <i class="fas fa-check font-weight-bold"></i> You've shown interest in joining a committee
            </p>
        </div>
        @endif
    </div>
@endsection
