<table>
    <thead>
    <tr>
        <th>id</th>
        <th>initialen</th>
        <th>tussenvoegsel</th>
        <th>achternaam</th>
        <th>rekenignnummer</th>
        <th>plaats_bank</th>
        <th>adres</th>
        <th>plaats</th>
        <th>land</th>
        <th>start_lidmaatschap</th>
        <th>totale_kosten</th>
    </tr>
    </thead>
    <tbody>
    @foreach($transactions as $transaction)
        <tr>
            <td>{{ $transaction->id }}</td>
            <td>{{ $transaction->initialen }}</td>
            <td>{{ $transaction->tussenvoegsel }}</td>
            <td>{{ $transaction->achternaam }}</td>
            <td>{{ $transaction->rekeningnummer }}</td>
            <td>{{ $transaction->plaats_bank }}</td>
            <td>{{ $transaction->adres }}</td>
            <td>{{ $transaction->plaats }}</td>
            <td>{{ $transaction->land }}</td>
            <td>{{ $transaction->start_lidmaatschap }}</td>
            <td>{{ $transaction->totale_kosten }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
