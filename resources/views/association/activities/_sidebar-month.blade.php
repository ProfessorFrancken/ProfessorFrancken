<li class="agenda-item mb-2 pb-2">
    <a
        href="/association/activities/{{ $year }}/{{ $month['number'] }}"
        class="aside-link"
    >
        <div class="media align-items-center">
            <div class="media-body">
                <h5 class="agenda-item__header {{ $month['number'] === $selectedMonth ? 'text-primary' : '' }}">
                    {{ $month['name']  }}
                </h5>
            </div>
        </div>
    </a>

</li>
