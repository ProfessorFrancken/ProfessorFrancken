@extends('admin.print-layout')
@section('page-title', "T.F.V. 'Professor Francken'")
@section('corner')
    <h3 class="text-muted d-flex align-items-end mb-0 h4">
        <span>
            Book ID:
        </span>
        <small class="ml-3 border-bottom" style="min-width: 15ch">
            {{ $book->id ?? '' }}
        </small>
    </h3>
@endsection

@section('footer')
@endsection

@section('content')
    <div class="container-fluid mt-3 px-4">
        <div class="card px-3">
            <div class="card-body">
                <h2 class="h4 font-weight-bold">
                    Second hand book sale
                </h2>
                <p style="font-size: 0.8rem;" class="my-1">
                    This contract is established in a way that T.F.V. ‘Professor Francken’ functions as an intermediary for the sale of second-hand books. T.F.V. ‘Professor Francken’ does not sell or buy a book at any moment through this contract.
                </p>

                <p style="font-size: 0.8rem;" class="my-1">
                    Undersigned seller and the undersigned board member on behalf of T.F.V. ‘Professor Francken’ agree that:
                </p>
                <ul style="font-size: 0.7rem;">
                    <li class="my-2">
                        The seller hands in the described  book at an undersigned board member when signing this contract;
                    </li>
                    <li class="my-2">
                        The seller gives T.F.V. ‘Professor Francken’ the right to sell the book to anyone who is willing to pay the indicated price for the book;
                    </li>
                    <li class="my-2">
                        T.F.V. ‘Professor Francken’ will pay out the entire sum to the seller at last three months after the sale of the book to the buyer;
                    </li>
                    <li class="my-2">
                        The payment by T.F.V. ‘Professor Francken’ will occur on the IBAN number known at T.F.V. ‘Professor Francken’;
                    </li>
                    <li class="my-2">
                        T.F.V. ‘Professor Francken’ is not responsible for possible loss or damage to the book by any reason after signing the contract by the seller.
                    </li>
                    <li class="my-2">
                        The book remains the property of the seller, unless T.V.F. ‘Professor Francken’ indicates not to be willing to sell the book anymore, after which the book becomes property of T.F.V. ‘Professor Francken’ if the book is not collected by the seller within two months after T.F.V. ‘Professor Francken’ has informed them.
                    </li>
                    <li class="my-2">
                        By signing this form you agree to the privacy statement of T.F.V. ‘Professor Francken’.
                    </li>
                </ul>
                <p style="font-size: 0.8rem;" class="my-1">
                    Undersigned buyer and the undersigned board member on behalf of T.F.V. ‘Professor Francken’ agree that:
                </p>
                <ul style="font-size: 0.7rem;">
                    <li class="my-2">
                        The buyer, after handing over the book by T.F.V. ‘Professor Francken’, owes the amount described on the contract to the seller and the payment occurs through T.F.V. ‘Professor Francken’.
                    </li>
                    <li class="my-2">
                        The payment by the buyer to T.F.V. ‘Professor Francken’ will be leveled with the next depreciation done by T.F.V. ‘Professor Francken’ from the buyer.
                    </li>
                    <li class="my-2">
                        T.F.V. ‘Professor Francken’ gives no guarantee to the buyer in any way.
                    </li>
                    <li class="my-2">
                        By signing this form you agree to the privacy statement of T.F.V. ‘Professor Francken’.
                    </li>
                </ul>

            </div>
        </div>

        <div class="card px-3 my-3">
            <div class="card-body">
                <h4 class="h5 font-weight-bold">Book</h4>
                <div class="row">
                    @include('admin.study.books._print-input', ['name' => 'Name book', 'value' => $book->name])
                    @include('admin.study.books._print-input', ['name' => 'ISBN', 'value' => $book->isbn])
                </div>
                <div class="row mt-5">
                    @include('admin.study.books._print-input', ['name' => 'Author book', 'value' => $book->author])
                    @include('admin.study.books._print-input', ['name' => 'Price by seller', 'value' => '&euro;' . number_format($book->price_by_seller, 2, ',', '.')])
                </div>
            </div>
        </div>

        <div class="card px-3 my-3">
            <div class="card-body">
                <h4 class="h5 font-weight-bold">Seller</h4>
                <div class="row">
                    @include('admin.study.books._print-input', ['name' => 'Name seller', 'value' => optional($book->seller)->fullname])
                    @include('admin.study.books._print-input', ['name' => 'Signature seller', 'value' => ''])
                </div>
                <div class="row my-5">
                    @include('admin.study.books._print-input', ['name' => "Name board member T.F.V. 'Professor Francken' during intake from seller", 'value' => ''])
                    @include('admin.study.books._print-input', ['name' => "Signature board member T.F.V. 'Professor Francken' during intake from seller", 'value' => ''])
                </div>
                <div class="row mt-5">
                    <div class="col-6"></div>
                    @include('admin.study.books._print-input', ['name' => 'Date intake book from seller', 'value' => optional($book->taken_in_from_seller_at)->format('Y-m-d')])
                </div>

            </div>
        </div>
        <div class="card px-3 my-3">
            <div class="card-body">
                <h4 class="h5 font-weight-bold">Buyer</h4>
                <div class="row">
                    @include('admin.study.books._print-input', ['name' => 'Name buyer', 'value' => optional($book->buyer)->fullname])
                    @include('admin.study.books._print-input', ['name' => 'Signature buyer', 'value' => ''])
                </div>
                <div class="row my-5">
                    @include('admin.study.books._print-input', ['name' => "Name board member T.F.V. 'Professor Francken' during intake by buyer", 'value' => ''])
                    @include('admin.study.books._print-input', ['name' => "Signature board member T.F.V. 'Professor Francken' during intake by buyer", 'value' => ''])
                </div>
                <div class="row mt-5">
                    <div class="col-6"></div>
                    @include('admin.study.books._print-input', ['name' => 'Date intake book by buyer', 'value' => optional($book->taken_in_by_buyer_at)->format('Y-m-d')])
                </div>
            </div>
        </div>
    </div>
@endsection
