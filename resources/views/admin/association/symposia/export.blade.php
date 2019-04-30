<table class="table">
    <thead>
        <tr>
            <th>Symposium</th>
            <th>Location</th>
            <th>Start date</th>
            <th>End date</th>
            <th>Website</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>{{ $symposium->name }}</td>
            <td>{{ $symposium->location }}</td>
            <td>{{ $symposium->start_date->format('Y-m-d H:i:s') }}</td>
            <td>{{ $symposium->end_date->format('Y-m-d H:i:s') }}</td>
            <td>{{ $symposium->website_url }}</td>
        </tr>
        <tr></tr>
    </tbody>
    <thead>
        <tr>
            <th>Firstname</th>
            <th>Lastname</th>
            <th>Email</th>
            <th>Francken?</th>
            <th>Member Id</th>
            <th>NNV?</th>
            <th>NNV Number</th>
            <th>Payment method</th>
            <th>IBAN</th>
            <th>Has paid</th>
            <th>Received information mail</th>
        </tr>
    </thead>
    <tbody>
    @foreach($participants as $participant)
        <tr>
            <td>{{ $participant->firstname }}</td>
            <td>{{ $participant->lastname }}</td>
            <td>{{ $participant->email }}</td>
            <td>{{ $participant->is_francken_member ? "Yes" : "No" }}</td>
            <td>{{ $participant->member_id }}</td>
            <td>{{ $participant->is_nnv_member ? "Yes" : "No" }}</td>
            <td>{{ $participant->nnv_number }}</td>
            <td>{{ $participant->pays_with_iban ? "IBAN" : "Cash" }}</td>
            <td>{{ decrypt($participant->iban) }}</td>
            <td>{{ $participant->has_paid }}</td>
            <td>{{ $participant->received_information_mail }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
