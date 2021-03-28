@if (count($symposia) > 0)
    <table class="table table-hover table-small">
        <thead>
            <tr>
                <th>Logo</th>
                <th>Name</th>
                <th>Date</th>
                <th class="text-right">Registered participants</th>
            </tr>
        </thead>
        @foreach ($symposia as $symposium)
            <tr>
                <td style="width: 200px;" class="align-middle">
                    <a href="{{ action([\Francken\Association\Symposium\Http\AdminSymposiaController::class, 'show'], $symposium->id) }}">
                        <img
                            class="rounded ml-2 my-2"
                            src="{{ $symposium->logo }}"
                            alt="Logo of {{ $symposium->name }}"
                            style="width: 150px; max-width: 150px; max-height: 80px; object-fit: cover;"
                        />
                    </a>
                </td>
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
