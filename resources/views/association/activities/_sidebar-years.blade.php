@foreach ($years as $year)
    <li>
        <a href="/association/activities/{{ $year }}/{{ $selectedMonth }}" class="aside-link">{{ $year }}</a>
    </li>
@endforeach
