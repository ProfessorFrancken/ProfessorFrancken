@php
use Francken\Treasurer\Http\Controllers\DeductionsController;
@endphp

<tr class="position-relative">
    <td class="position-static">
        <a href="{{ action([DeductionsController::class, 'show'], $deduction->id) }}"
           class="stretched-link text-decoration-none"
        >
            @isset ($deduction->emails_sent_at)
            <i class="fas fa-check"></i>
            @else
            <i class="fas fa-times"></i>
            @endisset
            {{ $deduction->deducted_at->format('Y-m-d') }}
        </a>
    </td>

    <td class="text-right">
        {{ $deduction->amount_of_members }}
    </td>

    <td class="text-right">
        €{{ number_format($deduction->total_amount, 2) }}
    </td>
</tr>
