@php
use Francken\Treasurer\Http\Controllers\DeductionsController;
@endphp

<tr class="position-relative">
    <td>
        <a href="{{ action([DeductionsController::class, 'show'], $deduction->id) }}"
           class="stretched-link"
        >
            {{ $deduction->id }}
        </a>
    </td>

    <td>
        {{ $deduction->deducted_at->format('Y-m-d') }}
    </td>

    <td class="text-right">
        {{ $deduction->amount_of_members }}
    </td>

    <td class="text-right text-muted">
        @isset ($deduction->emails_sent_at)
            <i class="fas fa-check"></i>
            {{ $deduction->emails_sent_at->format('Y-m-d') }}
        @else
            <i class="fas fa-times"></i>
            Not yet sent
        @endisset
    </td>
</tr>
