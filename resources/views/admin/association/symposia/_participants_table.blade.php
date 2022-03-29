<table class="table">
    <thead class="">
        <tr>
            <th scope="col">Particpant</th>
            <th scope="col">Submitted</th>
            <th scope="col">NNV</th>
            <th scope="col">Francken</th>
            <th scope="col">Has paid</th>
            <th scope="col">Lunch</th>
            <th scope="col" class="text-right">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($participants as $participant)
            <tr>
                <td>
                    <h4 class="h6 mb-0">
                        {{ $participant->fullname }}
                    </h4>
                    <span>{{ $participant->email }}</span>
                    @if (is_null($participant->email_verified_at))
                        (Not yet verified)
                    @endif
                </td>
                <td>
                    {{ $participant->created_at->diffForHumans()  }}
                </td>
                <td>
                    {{ $participant->is_nnv_member ? "Yes" : "No" }}<br />
                    {{ $participant->nnv_number }}
                </td>
                <td>
                    {{ $participant->is_francken_member ? "Yes" : "No" }}<br />
                    {{ $participant->member_id }}
                </td>
                <td>
                    {{ $participant->has_paid ? "Yes" : "No" }}<br />
                </td>
                <td>
                    {{ $participant->lunch_option}}<br />
                </td>
                <td class="text-right d-flex justify-content-end">
                    <form method="POST" action="{{ action([\Francken\Association\Symposium\Http\AdminSymposiumParticipantsController::class, 'toggleSpam'], [$symposium->id, $participant->id]) }}">
                        @csrf
                        @method("PUT")

                        <button class="btn btn-text text-primary btn-sm mx-3">
                            @if ($participant->is_spam)
                                Don't mark as spam
                            @else
                                Mark as spam
                            @endif
                        </button>
                    </form>

                    <a class="btn btn-primary btn-sm mr-3" href="{{ action([\Francken\Association\Symposium\Http\AdminSymposiumParticipantsController::class, 'edit'], [$symposium->id, $participant->id]) }}">
                        Edit
                    </a>

                    <form method="POST" action="{{ action([\Francken\Association\Symposium\Http\AdminSymposiumParticipantsController::class, 'remove'], [$symposium->id, $participant->id]) }}">
                        @csrf
                        @method("DELETE")

                        <button class="btn btn-primary btn-sm">
                            Remove
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th colspan="6" class="text-left">
                Total:
                <span class="font-weight-normal">
                    {{ $participants->count() }}
                </span>
            </th>
            <td></td>
        </tr>
    </tfoot>
</table>
