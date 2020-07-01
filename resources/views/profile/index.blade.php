@extends('profile.layout')

@section('content')
    <div class="alert alert-warning" role="alert">
        Currently it is not possible to change your data using our website.
        If you'd like to change or remove any of your personal information then please send an email to the <a href="mailto:board@professorfrancken.nl">board</a>.
    </div>

    <ul class="list-unstyled profile-container border rounded" style="">
        @component('profile._profile', ['icon' => 'fas fa-user'])
            <div>
                <img
                    src="{{ image('/images/person.png', ['width' => '100', 'height' => '100'], true) }}"
                    class="rounded-circle border border-dark float-right bg-light"
                    style="width: 100px; height: 100px; margin-top: -2em; margin-right: -2em;"
                />

                <h4 class="text-body font-weight-light">
                    {{ $member->fullName() }}
                </h4>
                <ul class="list-unstyled">
                    <li>
                        <i class="far fa-calendar-alt fa-xs text-primary"></i>
                        <strong>Member since</strong>: {{ $member->startMembership()->diffForHumans()  }}
                    </li>
                    <li>
                        <i class="fas fa-birthday-cake fa-xs text-primary"></i>
                        <strong>Birthday</strong>: {{ $member->birthDate()->format('F j Y') }}
                    </li>
                    @if ($member->nnvNumber())
                        <li>
                            <i class="fas fa-passport fa-xs text-primary"></i>
                            <strong>NNV Number</strong>: {{ $member->nnvNumber() }}
                        </li>
                    @endif
                </ul>
            </div>
        @endcomponent

        @include('profile._study-profile', ['student' => $member->student()])

        @component('profile._profile', ['icon' => 'fas fa-at'])
            <h6 class="text-body font-weight-light">
                {{ $member->email() }}
            </h6>

            <ul class="list-unstyled">
                <li>
                    @if ($member->receivesBiWeeklyMailing())
                        <i class="fas fa-check fa-xs text-primary"></i> Receive our biweekly newsletter
                    @else
                        <i class="fas fa-times fa-xs text-primary"></i> You are not subscribed to our biweekly newsletter
                    @endif
                </li>
            </ul>
        @endcomponent

        @component('profile._profile', ['icon' => 'fas fa-map-marker'])
            <h6 class="text-body font-weight-light">
                {{ $member->address()->toString() }}
            </h6>

            <ul class="list-unstyled">
                <li>
                    @if ($member->receivesFranckenVrij())
                        <i class="fas fa-check fa-xs text-primary"></i> Receive the <a href="/association/francken-vrij">Francken Vrij</a> per mail
                    @else
                        <i class="fas fa-times fa-xs text-primary"></i> You won't receive the <a href="/association/francken-vrij">Francken Vrij</a> per mail
                    @endif
                </li>
            </ul>
        @endcomponent

        @component('profile._profile', ['icon' => 'fas fa-phone'])

            <h6 class="text-body font-weight-light">
                {{ $member->phoneNumber()  }}
            </h6>

            {{--
            <i class="fas fa-check fa-xs text-primary"></i> Subscribe to the Francken whatsapp broadcast
            --}}
        @endcomponent

        @include('profile._payment-info', ['member' => $member, 'paymentInfo' => $member->paymentDetails()])

        @if ($committees->isNotEmpty())
            @component('profile._profile', ['icon' => 'fas fa-users'])
                <h6 class="text-body font-weight-light">
                    Committees
                </h6>

                <ul class="">
                    @foreach ($committees as $committee)
                        <li>
                            <a href="{{ action(
                                        [\Francken\Association\Committees\Http\CommitteesController::class, 'show'],
                                        ['board' => $committee->board, 'committee' => $committee]
                                        ) }}"
                            >
                                {{ $committee->name  }} ({{ $committee->board->board_name->toString() }})
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endcomponent
        @endif

        @if (1 == 2)
        @component('profile._profile', ['icon' => 'fas fa-user-secret'])
            <h6 class="text-body font-weight-light">
                Privacy settings
            </h6>

            <ul class="list-unstyled">
                <li>
                    <i class="fas fa-check fa-xs text-primary"></i> Let others know what activities I've signed up
                </li>
                <li>
                    <i class="fas fa-check fa-xs text-primary"></i> Share my <em>streep-statistics</em> on <a href="https://borrelcie.vodka">borrelcie.vodka</a>.
                </li>
                <li>
                    <i class="fas fa-check fa-xs text-primary"></i> Track my phone location in the Francken Room
                </li>
            </ul>
        @endcomponent
        @endif

        @component('profile._profile', ['icon' => 'fas fa-cogs'])
            <h6 class="text-body font-weight-light">
                Settings
            </h6>

            Change password
        @endcomponent

        {{-- Settings: reset password --}}
    </ul>
@endsection
