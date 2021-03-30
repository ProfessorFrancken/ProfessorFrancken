@extends('admin.layout')
@section('page-title', 'Transactions')

@section('content')
    <div class="card">
        <div class="card-body">
            <h4 class="font-weight-bold">
                Search
            </h4>
            <form action="{{ action([\Francken\Treasurer\Http\Controllers\AdminTransactionsController::class, 'index']) }}"
                  method="GET"
                  class="form"
            >
                <div class="d-flex mb-3">
                    <x-forms-autocomplete-member
                        name="member"
                        name-id="member_id"
                        label="Member"
                        :value="optional($request->member())->fullname"
                        :value-id="$request->memberId()"
                    />

                    <div class="mx-2">
                        <x-forms.select name="product_id" label="Product" :options="$products" :value="$request->productId()" />
                    </div>
                    <div class="mx-2">
                        <x-forms.date name="from" label="From" :value="$request->from" />
                    </div>
                    <div class="mx-2">
                        <x-forms.date name="until" label="Until" :value="$request->until"  />
                    </div>

                    <x-forms.form-group name="search" formGroupClass="d-flex align-items-end">
                        <button type="submit" class="mx-2 btn btn-sm btn-primary">
                            <i class="fas fa-search"></i>
                            Apply filters
                        </button>

                        <a href="{{ action([\Francken\Treasurer\Http\Controllers\AdminTransactionsController::class, 'index'])  }}"
                           class="btn btn-sm btn-text text-primary"
                        >
                            <i class="fas fa-times"></i>
                            Clear filters
                        </a>
                    </x-forms.form-group>
                </div>
            </form>
        </div>

        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Member</th>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Time</th>
                    <th class="text-right">Edit</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transactions as $transaction)
                    <tr>
                        <td>
                            {{ $transaction->purchasedBy->fullname }}
                        </td>
                        <td>
                            {{ $transaction->product->name }}
                        </td>
                        <td>
                            €{{ number_format($transaction->totaalprijs, 2, ",", "") }}
                        </td>
                        <td>
                            {{ $transaction->tijd }}
                        </td>
                        <td class="text-right">
                            <a href="{{ action([\Francken\Treasurer\Http\Controllers\AdminTransactionsController::class, 'edit'], ['transaction' => $transaction])  }}" class="text-muted">
                                <i class="far fa-edit"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="2">
                        Total transactions: {{ $total }}
                    </th>
                    <th colspan="2">
                        €{{ number_format($totalRevenue, 2, ",", "") }}
                    </th>
                </tr>
            </tfoot>
        </table>

        <div class="card-footer">
            {!! $transactions->links() !!}
        </div>
    </div>
@endsection

@section('actions')
    <div class="d-flex align-items-end">
        <a href="{{ action([\Francken\Treasurer\Http\Controllers\AdminTransactionsController::class, 'create']) }}"
           class="btn btn-primary"
        >
            <i class="fas fa-plus"></i>
            Add a transaction
        </a>
    </div>
@endsection
