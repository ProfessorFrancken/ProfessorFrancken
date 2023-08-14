<h4>Personal details</h4>
<div class="row">
    <div class="col col-md-4">
        <h6>
            Name
        </h6>
        <ul class="list-unstyled">
            <li><strong>Initials</strong>: {{ $member->initialen  }}</li>
            <li><strong>Firstname</strong>: {{ $member->voornaam  }}</li>
            @if($member->tussenvoegsel)
                <li><strong>Insertion (tussenvoegsel)</strong>: {{ $member->tussenvoegsel  }}</li>
            @endif
            <li><strong>Surname</strong>: {{ $member->achternaam  }}</li>
        </ul>
    </div>
    <div class="col col-md-4">
        <h6>
            Birthdate & title
        </h6>

        <ul class="list-unstyled">
            <li>
                <strong>Gender</strong>
                @if ($member->gender === \Francken\Association\Members\Gender::FEMALE)
                    <i class="fas fa-venus"></i>
                @elseif ($member->gender === \Francken\Association\Members\Gender::MALE)
                    <i class="fas fa-mars"></i>
                @else
                    {{ $member->gender }}
                @endif
            </li>
            <li>
                <strong><i class="fas fa-birthday-cake"></i> Birthdate </strong>
                @if ($member->birthdate)
                    {{ $member->birthdate->format('Y-m-d') }}
                @else
                    Unknown
                @endif
            </li>
            @if ($member->titel)
                <li>
                    <strong>Title</strong>
                    {{ $member->titel  }}
                </li>
            @endif
        </ul>
    </div>
    <div class="col col-md-4">
        <h6>
            Nationality & language
        </h6>

        <ul class="list-unstyled">

            <li>
                @if($member->nederlands)
                    <i class="far fa-fw fa-check-square"></i>
                @else
                    <i class="far fa-fw fa-square"></i>
                @endif
                <strong>Knows Dutch</strong>
            </li>
            
            <li>
                @if($member->is_nederland)
                    <i class="far fa-fw fa-check-square"></i>
                @else
                    <i class="far fa-fw fa-square"></i>
                @endif
                <strong>Has Dutch nationality</strong>
            </li>
        </ul>
    </div>
</div>
