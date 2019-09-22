@if (count($symposia) > 0)
    <table class="table table-hover table-small">
        <thead>
            <tr>
                <th>Name</th>
                <th>Date</th>
                <th class="text-right">Registered participants</th>
            </tr>
        </thead>
        @foreach ($symposia as $symposium)
            <tr>
                <td>
                    <a href="{{ action([\Francken\Association\Symposium\Http\AdminSymposiaController::class, 'show'], $symposium->id) }}">
                        {{ $symposium->name }}
                    </a>
                </td>
                <td>
                    <small class="text-muted">
                        {{ $symposium->start_date->format('d M Y')}}
                    </small>
                </td>
                <td class="text-right">
                    {{ $symposium->participants_count }}
                </td>
            </tr>
        @endforeach
    </table>
@endif
