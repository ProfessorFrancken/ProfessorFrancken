@extends('association.borrelcie.layout')

@section('content')
    <div class="card mb-4">
        <div class="card-body">
            <h2 class="section-header mb-3">
                Anytimers
            </h2>

            <p>
                Keeping track of your anytimers can be difficult, let's make it easy!
            </p>

            <section class="my-4">
                <div class="d-flex justify-content-between">
                    <h3 class="h5">
                        Your anytimers
                    </h3>

                    <div>
                        <button class="btn btn-sm btn-text open-claim-anytimer">
                            Claim an anytimer
                        </button>
                    </div>
                </div>

                <ul class="list-unstyled">
                    @foreach ($claimed as $anytimer)
                        <li class="p-2 bg-light my-2 rounded d-flex justify-content-between align-items-center">
                            <strong class="mr-1">
                                {{ $anytimer->drinker->member->fullname }}
                            </strong>
                            <button class="btn badge badge-primary use-anytimer-{{ $anytimer->drinker->id }}">
                                {{ $anytimer->count_active }}
                            </button>

                            @if ($anytimer->count_active > 0)
                                @include('association.borrelcie.anytimers._use', ['anytimer' => $anytimer])
                            @endif
                        </li>
                    @endforeach
                </ul>
            </section>

            <section class="my-4">
                <div class="d-flex justify-content-between">
                    <h3 class="h5">
                        Their anytimers
                    </h3>
                    <div>
                        <button class="btn btn-sm btn-text open-give-anytimer">
                            Give away an anytimer
                        </button>
                    </div>
                </div>

                <ul class="list-unstyled">
                    @foreach ($given as $anytimer)
                        <li class="p-2 bg-light my-2 rounded d-flex justify-content-between align-items-center">
                            <strong class="mr-1">
                                {{ $anytimer->owner->member->fullname }}
                            </strong>
                            <span class="badge badge-primary mx-1">{{ $anytimer->count_active }}</span>
                        </li>
                    @endforeach
                </ul>
            </section>

            <section class="my-4">
                <h3 class="h5">
                    Stagnating anytimers
                </h3>

                <p>
                    The anytimers below have not yet been accepted, tell them it is stagnating.
                </p>

                <ul class="list-unstyled">
                    @foreach ($pendingAnytimers as $anytimer)
                        <li class="p-2 bg-light my-3 rounded">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    @if ($anytimer->amount > 0)
                                        Claimed {{ $anytimer->amount }} {{ \Illuminate\Support\Str::plural('anytimer', $anytimer->amount) }} from
                                        <strong class="mr-1">
                                            {{ $anytimer->drinker->member->fullname }}
                                        </strong>
                                    @else
                                        Used {{ -1 * $anytimer->amount }} {{ \Illuminate\Support\Str::plural('anytimer', -$anytimer->amount) }} on
                                        <strong class="mr-1">
                                            {{ $anytimer->drinker->member->fullname }}
                                        </strong>
                                    @endif
                                </div>
                                <small class="text-muted">
                                    {{ $anytimer->created_at->diffForHumans() }}
                                </small>
                            </div>
                            @if ($anytimer->reason)
                                <p class="mb-0 mt-2 text-muted">
                                    Your reason:
                                    "{{ $anytimer->reason }}"
                                </p>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </section>
        </div>
    </div>
    @include('association.borrelcie.anytimers._claim')
    @include('association.borrelcie.anytimers._give_away')
@endsection
