<div class="card mb-3">
    <div class="card-body">
        <h4>Committees</h4>

        @foreach($committeesByBoard as $boardId => $committeeMembers)
            <h6>
                {{ $committeeMembers->first()->committee->board->board_name->toString()  }}
            </h6>
            <ul class="list-unstyled mb-0">
                @foreach ($committeeMembers as $committeeMember)
                    <li>
                        <a href="{{ action(
                                        [\Francken\Association\Committees\Http\AdminCommitteesController::class, 'show'],
                                        [
                                            'board' => $committeeMember->committee->board,
                                            'committee' => $committeeMember->committee
                                        ])
                                 }}">
                            <div class="d-flex">
                                <img
                                    class="rounded d-flex mr-3"
                                    src="{{ image($committeeMember->committee->logo, ['height' => 75, 'width' => 75]) }}"
                                    alt="{{ $committeeMember->committee->name }}'s logo"
                                    style="width: 75px; height: 75px; object-fit: cover; border-radius: 50%;"
                                >
                                <p class="d-flex pb-0">
                                    <strong>
                                        {{ $committeeMember->committee->name  }}
                                    </strong>
                                    @if ($committeeMember->title !== "")
                                        {{ $committeeMember->title  }}
                                    @endif
                                </p>
                            </div>
                        </a>
                    </li>
                @endforeach
            </ul>
        @endforeach
        @if($committeesByBoard->isEmpty())
            <div class="my-3 bg-light py-3 px-2">
                <p class="mb-0 text-center" style="font-size: 0.8rem">
                    {{ $member->fullname  }} has not been part of any committee.
                </p>
            </div>
        @endif
    </div>
</div>
