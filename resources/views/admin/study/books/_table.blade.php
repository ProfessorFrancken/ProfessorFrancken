@if (count($books) > 0)
    <table class="table table-hover table-small">
        <thead>
            <tr>
                <th>Title</th>
                <th class="text-left">Price</th>
                <th>Seller</th>
                <th class="text-right">ISBN</th>
                <th class="text-right">Put on sale at</th>
                <th class="text-right"></th>
            </tr>
        </thead>
        @foreach ($books as $book)
            <tr class="align-middle">
                <td>
                    {{ $book->title() }}<br/>
                    <small class="text-muted">
                        {{ $book->author() }}
                    </small>
                </td>
                <td class="text-left align-middle">
                    €{{ number_format($book->price()/100, 2, ",", "") }}
                </td>
                <td class="align-middle">
                    Unkown
                </td>
                <td class="text-right align-middle">
                    {{ $book->isbn() }}
                </td>
                <td class="text-right align-middle">
                    {{ $book->putOnSaleAt() }}
                </td>
                <td class="text-right align-middle">
                    <a class="btn btn-sm btn-link text-muted" href="">
                        <i class="fa fa-times" aria-hidden="true"></i>
                        Remove

                    </a>

                    <a class="btn btn-sm btn-link" href="">
                        <i class="fa fa-print" aria-hidden="true"></i>
                        Form
                    </a>

                    <a class="btn btn-sm btn-outline-success" href="">
                        <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                        Sell

                    </a>
                </td>
            </tr>
        @endforeach
    </table>
@endif
