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
