<h5 class="mb-3 mt-4">Study details</h5>
<h6>
    <i class="fas fa-fw fa-graduation-cap"></i>
    <strong>
        Student number
    </strong>:
    <span class="font-weight-light">
        {{ $member->student_number }}
    </span>
</h6>

<ul class="list-unstyled">
    @foreach ($member->student->studies() as $study)
        <li class="my-3 bg-light p-3">
            <h6 class="mb-0">
                {{ $study }}
            </h6>
            {{ $study->startYear() }} - {{ $study->endYear() }}
        </li>
    @endforeach
    <li>
        @if($member->afgestudeerd)
            <i class="far fa-fw fa-check-square"></i>
        @else
            <i class="far fa-fw fa-square"></i>
        @endif
        <strong>Graduated</strong>
    </li>
    @if($member->afstudeerplek)
        <li>
            <strong>Place of graduation</strong> {{  $member->afstudeerplek }}
        </li>
    @endif
</ul>
