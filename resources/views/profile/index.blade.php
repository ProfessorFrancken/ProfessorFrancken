@extends('profile.layout')

@section('content')

    <ul class="list-unstyled profile-container border rounded" style="">
        @component('profile._profile', ['icon' => 'fas fa-user'])
            <img
                src="{{ image('/images/person.png', ['width' => '100', 'height' => '100'], true) }}"
                class="rounded-circle border border-dark float-right"
                style="width: 100px; height: 100px; margin-top: -3em; margin-right: -3em;"
            />

            <h6 class="text-body font-weight-light">
                {{ $member->fullName() }} - Bsc
            </h6>


            <hr/>

            <i class="far fa-calendar-alt fa-xs text-primary"></i>
            <strong>Member since</strong>: {{ $member->startMembership()->diffForHumans()  }}
            <br/>
            <i class="fas fa-birthday-cake fa-xs text-primary"></i>
            <strong>Birthday</strong>: {{ $member->birthDate()->format('F j Y') }}
            <br/>
            @if ($member->nnvNumber())
                <i class="fas fa-passport fa-xs text-primary"></i>
                <strong>NNV Number</strong>: {{ $member->nnvNumber() }}
            @endif

            <a href="/" class="float-right text-secondary">Edit</a>
        @endcomponent

        @component('profile._profile', ['icon' => 'fas fa-graduation-cap'])
            <h5>
                <strong>Student number</strong>:
                <span class="font-weight-light h6">
                    {{ $member->student()->studentNumber() }}
                </span>
            </h5>
            <ul class="list-unstyled">
                @foreach ($member->student()->studies() as $study)
                <li class="border-bottom w-100">
                    <h6>
                        {{ $study }}
                    </h6>
                    {{ $study->startYear() }} - {{ $study->endYear() }}

                    @unless ($loop->last)
                        <hr/>
                    @endunless
                </li>
                @endforeach
            </ul>

            <a href="/" class="float-right text-secondary" style="color: #46988e">Edit</a>
        @endcomponent

        @component('profile._profile', ['icon' => 'fas fa-at'])
            <h6 class="text-body font-weight-light">
                {{ $member->email() }}
            </h6>

            <i class="fas fa-check fa-xs text-primary"></i> Receive biweekly newsletter

            <a href="/" class="float-right text-secondary" style="color: #46988e">Edit</a>
        @endcomponent

        @component('profile._profile', ['icon' => 'fas fa-map-marker'])
            <h6 class="text-body font-weight-light">
                {{ $member->address() }}
            </h6>

            <i class="fas fa-check fa-xs text-primary"></i> Receive the <a href="/association/francken-vrij">Francken Vrij</a> per mail

            <a href="/" class="float-right text-secondary" style="color: #46988e">Edit</a>
        @endcomponent

        @component('profile._profile', ['icon' => 'fas fa-phone'])

            <h6 class="text-body font-weight-light">
                {{ $member->phoneNumber()  }}
            </h6>

            <i class="fas fa-check fa-xs text-primary"></i> Subscribe to the Francken whatsapp broadcast

            <a href="/" class="float-right text-secondary" style="color: #46988e">Edit</a>
        @endcomponent

        @component('profile._profile', ['icon' => 'fas fa-money-check-alt'])

            <h6 class="text-body font-weight-light">
                {{ $member->iban()  }}
            </h6>

            <p>
                You've authorized T.F.V. 'Professor Francken' to withdraw money from the bank account listed above, due to:
            </p>
            <i class="fas fa-check fa-xs text-primary"></i> Membership (€5,- per year)
            <br/>

            <i class="fas fa-check fa-xs text-primary"></i> Drinking and eating expenses and any potential costs incurred at other activities of the association.

            <a href="/" class="float-right text-secondary" style="color: #46988e">Edit</a>
        @endcomponent

        @if (count($committees) > 0)
            @component('profile._profile', ['icon' => 'fas fa-users'])
                <h6 class="text-body font-weight-light">
                    Committees
                </h6>

                <ul class="">
                    @foreach ($committees as $committee)
                        <li>
                            <a href="{{ $committee->link() }}">
                                {{ $committee->name() }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endcomponent
        @endif

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

            <a href="/" class="float-right text-secondary" style="color: #46988e">Edit</a>
        @endcomponent

        @component('profile._profile', ['icon' => 'fas fa-cogs'])
            <h6 class="text-body font-weight-light">
                Settings
            </h6>

            Change password
        @endcomponent

        {{-- Settings: reset password --}}
    </ul>
@endsection
