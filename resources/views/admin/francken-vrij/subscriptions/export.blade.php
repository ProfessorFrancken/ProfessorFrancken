<table>
    <thead>
    <tr>
        <th>Initials</th>
        <th>Insertion</th>
        <th>Surname</th>
        <th>Address</th>
        <th>Postal code</th>
        <th>City</th>
        <th>Country</th>
    </tr>
    </thead>
    <tbody>
    @foreach($subscriptions as $subscription)
        <tr>
            <td>{{ $subscription->member->initialen }}</td>
            <td>{{ $subscription->member->tussenvoegsel }}</td>
            <td>{{ $subscription->member->achternaam }}</td>
            <td>{{ $subscription->member->adres }}</td>
            <td>{{ $subscription->member->postcode }}</td>
            <td>{{ $subscription->member->plaats }}</td>
            <td>{{ $subscription->member->land }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
