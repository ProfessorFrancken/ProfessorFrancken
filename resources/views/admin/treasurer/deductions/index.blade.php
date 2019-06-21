@extends('admin.layout')
@section('page-title', 'Deductions')

@php
use Francken\Treasurer\Http\Controllers\DeductionsController;
@endphp

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <table class="table table-hover table-small">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Date</th>
                            <th class="text-right">Members</th>
                            <th class="text-right">Email sent at</th>
                        </tr>
                    </thead>

                    @each('admin.treasurer.deductions._deduction-row', $deductions, 'deduction')
                </table>

                <div class="card-footer">
                    {{ $deductions->links() }}
                </div>
            </div>
        </div>
        <div class="col-md-4">
            @include('admin.treasurer.deductions._create', ['deduction' => $deduction])
        </div>
    </div>
@endsection
