@extends('admin.layout')
@section('page-title')
    Deductions / {{ $deduction->deducted_at->format('Y-m-d') }} -
    <small>
        €{{ number_format($deduction->total_amount, 2) }}
    </small>
@endsection
@php
use Francken\Treasurer\Http\Controllers\DeductionEmailsController;
use Francken\Treasurer\Http\Controllers\DeductionMembersController;
use Francken\Treasurer\Http\Controllers\DeductionsController;
@endphp

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                @if ($deduction->emails_sent_at === null)
                    <div class="card-body">
                        <p>
                            The email notifications for this deduction have already been sent.
                        </p>
                    </div>
                @endif

                @if ($conflicts->isNotEmpty())
                <div class="card-body">
                    <p>
                        There were some conflicts while uploading the deduction file.
                        Before we send the email to inform members about the upcoming deduction please check and verify that these conflicts are not critical.
                        If the conflicts are not critical you can simply click the button below.
                    </p>

                    {!!
                       Form::open([
                           'url' => action([DeductionsController::class, 'update'], $deduction->id),
                           'method' => 'PUT',
                       ])
                    !!}
                    <button class="btn btn-sm btn-danger" name="action" value="resolve-conflict">
                        Mark conflicts as resolved
                    </button>

                    {!! Form::close() !!}
                </div>
                @endif
                <table class="table table-hover table-small">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Description</th>
                            <th class="text-right">Amount</th>
                            <th class="text-right">Actions</th>
                        </tr>
                    </thead>
                        @foreach ($deductions as $member)
                            <tr
                                @if ($member->contained_errors && $conflicts->isNotEmpty())
                                class="position-relative text-white {{ $conflicts[$member->member_id]->contains('iban') ? 'bg-danger' : 'bg-warning'}}"
                                @else
                                class="position-relative"
                                @endif
                            >
                            <td>
                                @if ($member->contained_errors && $conflicts->isNotEmpty())
                                    <i
                                        class="fas fa-exclamation-triangle mr-2"
                                        title="There were errors when importing deductions for this member. The following fields contained conflicts: {{ $conflicts[$member->member_id]->implode(', ') }}"
                                    ></i>
                                @endif
                                <a href="{{ action([\Francken\Association\Members\Http\Controllers\Admin\MembersController::class, 'show'], ['member' => $member->member])  }}">
                                    {{ $member->member->fullname }}
                                </a>
                            </td>
                            <td>
                                {{ $member->description }}
                            </td>
                            <td class="text-right">
                                €{{ $member->amount }}
                            </td>
                            <td class="text-right">
                                <a
                                    target="_blank"
                                    href="{{ action([DeductionMembersController::class, 'show'], [$deduction->id, $member->member_id]) }}"
                                    class="btn btn-sm btn-link {{ ($member->contained_errors && $conflicts->isNotEmpty()) ? 'text-white' : 'text-muted'}} "
                                >
                                    <i class="fas fa-envelope fa-fw"></i>
                                    Preview email
                                </a>
                            </td>
                        </tr>
                        @endforeach
                </table>
            </div>
        </div>
    </div>
@endsection

@section('actions')
    @if ($deduction->emails_sent_at === null)
        <div class="d-flex align-items-end">
            @if ($conflicts->isNotEmpty())
                <button
                    class="btn btn-primary disabled"
                    tile="There were conflicts while uploading the deductions file, please resolve these issues first before notifying our members"
                    disabled
                >
                    <i class="fas fa-envelope fa-fw"></i>
                    Send
                </button>
            @else
                {!!
                   Form::open([
                       'url' => action([DeductionEmailsController::class, 'create'], $deduction->id),
                       'method' => 'POST',
                   ])
                !!}
                <button class="btn btn-primary" >
                    <i class="fas fa-envelope fa-fw"></i>
                    Send
                </button>
                {!! Form::close() !!}
            @endif
        </div>
    @endif
@endsection
