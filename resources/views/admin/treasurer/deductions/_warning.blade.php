<strong>Warning:</strong>
<small>
@foreach ($deduction['errors'] ?? [] as $error)
    <span class="">
        @if ($error === 'iban')
            Iban ("{{ $deduction['iban'] }}" ≠ "{{ $deduction['member']->rekeningnummer }}"),
        @elseif ($error === 'address')
            Address ("{{ $deduction['city'] }}, {{ $deduction['address'] }}" ≠ "{{ $deduction['member']->plaats }}, {{ $deduction['member']->adres }}"),
        @elseif ($error === 'name')
            Name ("{{ $deduction['name'] }}" ≠ "{{ $deduction['member']->initialen }} {{ $deduction['member']->surname }}"),
        @endif
    </span>
@endforeach
</small>
