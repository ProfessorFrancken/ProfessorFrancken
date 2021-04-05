{{-- TODO add links --}}
<p class="lead">
    {{ $member->fullname }} has been a member of T.F.V. 'Professor Francken' since {{ $member->created_at->format('F j Y') }}
    @if ($member->eine_lidmaatschap !== null)
        until {{ $member->einde_lidmaatschap->format('F j Y') }}
    @endif.
    @foreach ($boardMembers as $boardMember)
        Was installed as <em>{{ $boardMember->title }}</em> during the board year of <em>"{{ $boardMember->board->board_name->toString()  }}"</em> from {{ $boardMember->installed_at->format('F j Y') }}
        @if ($boardMember->decharged_at)
            to {{ $boardMember->decharged_at->format('F j Y') }}
        @endif.
    @endforeach
    @if ($currentCommittees->isNotEmpty())
        Is part of {{ $currentCommittees->count() }} committees. 
    @endif
</p>
