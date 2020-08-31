<div class="bg-white shadow py-5 mb-5">
    <div class="px-5 mb-3">
        <h3 class="section-header">
            Agenda
        </h3>
    </div>
    <ul class="agenda-list list-unstyled">
        @foreach ($activities as $activity)
            @include('./homepage._agenda-item', ['activity' => $activity])
        @endforeach
        <li class="agenda-item d-flex d-flex align-items-center px-5">
            <div class="agenda-item__date align-self-start">
                <h5 class="agenda-item__date-day">
                    <i class="fa fa-calendar" aria-hidden="true"></i>
                </h5>
            </div>

            <div class="agenda-item__body">
                <a href="{{ action([\Francken\Association\Activities\Http\IcalController::class, 'index']) }}">
                    <h5 class="agenda-item__header">Download our ical</h5>
                    <p class="agenda-item__description">
                        Upload our agenda to your own by downloading our ical
                    </p>
                </a>
            </div>
        </li>
    </ul>
</div>
