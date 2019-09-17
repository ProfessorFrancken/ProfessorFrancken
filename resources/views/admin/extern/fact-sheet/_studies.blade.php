<div class="card my-3">
    <div class="card-body">
        <h4 class="card-title">Students - Master / Bachelor ratio</h4>
    </div>

    <table class="table table-hover mb-0">
        <thead class="thead-inverse">
            <tr>
                <th>Study</th>
                <th>Bachelor</th>
                <th>Master</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($studies->studies() as $study)
                <tr>
                    <td>{{ $study->study() }}</td>
                    <td>{{ $study->bachelor() }}</td>
                    <td>{{ $study->master() }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th>Total</th>
                <th>{{ $studies->total()->bachelor() }}</th>
                <th>{{ $studies->total()->master() }}</th>
            </tr>
        </tfoot>
    </table>
</div>
