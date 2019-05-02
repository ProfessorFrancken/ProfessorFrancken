@extends('admin.layout')
@section('page-title', 'Symposia / ' . $symposium->name . ' / Attendance')

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <h3>
                        Participants
                    </h3>
                </div>

                <table class="table">
                    <thead class="">
                        <tr>
                            <th scope="col">Particpant</th>
                            <th scope="col">NNV</th>
                            <th scope="col">Francken</th>
                            <th scope="col">Has paid</th>
                            <th scope="col" class="text-right">Signature</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($participants as $participant)
                            <tr>
                                <td class="d-flex align-items-end">
                                    <h4 class="mr-2 mb-0">
                                        {{ $participant->full_name }}
                                    </h4>
                                    <span>{{ $participant->email }}</span>
                                </td>
                                <td class="w-25">
                                    {{ $participant->nnv_number }}
                                </td>
                                <td class="w-25">
                                    {{ $participant->has_paid ? "Yes" : "No" }}<br />
                                </td>
                                <td>
                                    @if ($participant->pays_with_iban)
                                        {{ decrypt($participant->iban) }}
                                    @else
                                        Cash
                                    @endif
                                </td>
                                <td class="text-right">

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
