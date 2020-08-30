<table>
    <thead>
    <tr>
        <th>{{ $activity->start_date->format('j M') }}</th>
        <th>Sign up list</th>
        <th>{{ $activity->name }}</th>
        <th></th>
        <th></th>
        <th></th>
        <th>Paid:</th>
        <th></th>
        <th>People</th>
        <th></th>
    </tr>
    <tr>

        <th>Who?</th>
        <th>Costs</th>
        <th>Total costs</th>
        <th>
            {{ number_format($totalCosts / 100, 2) }}
        </th>
    </tr>
    </thead>
    <tbody>
    @foreach($signUps as $signUp)
        <tr>
            <td>{{ $signUp->export_name }}</td>
            <td>
                {{ number_format($signUp->costs / 100, 2) }}
            </td>
            <td>{{ $signUp->notes }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
