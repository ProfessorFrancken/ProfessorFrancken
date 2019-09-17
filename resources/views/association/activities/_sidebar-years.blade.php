@foreach ($years as $year)
    <li>
        <a
            href="/association/activities/{{ $year }}/{{ $selectedMonth }}"
            class="aside-link {{ $year === $selectedYear ? 'text-primary' : 'text-secondary' }}">
            {{ $year }}
        </a>
    </li>
@endforeach
