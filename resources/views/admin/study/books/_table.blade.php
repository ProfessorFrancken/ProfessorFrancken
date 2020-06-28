@if (count($books) > 0)
    <table class="table table-hover table-small table-striped mb-0">
        <thead>
            <tr>
                <th>Title</th>
                <th>ISBN</th>
                <th>Sold by</th>
                <th>Bought by</th>
                <th class="text-left">Price</th>
            </tr>
        </thead>
        @foreach ($books as $book)
            <tr class="align-middle">
                <td>
                    <a
                        href="{{ action([\Francken\Study\BooksSale\Http\AdminBooksController::class, 'show'], $book->id) }}"
                        class=""
                    >
                        {{ $book->title }} <br/>
                    <small class="text-muted">
                        {{ $book->author }}
                    </small>
                    </a>
                </td>
                <td class="align-middle">
                    {{ $book->isbn }}<br/>
                    <small class="text-muted">
                        Edition: {{ $book->edition }}
                    </small>
                </td>
                <td class="align-middle">
                    @if ($book->seller)
                        {{ $book->seller->fullName }}<br/>
                        <small>
                            {{ optional($book->purchase_date)->format('Y-m-d') }}
                        </small>
                    @endif
                </td>
                <td class="align-middle">
                    @if ($book->buyer)
                        {{ $book->buyer->fullName }}<br />
                        <small>
                            {{ optional($book->sale_date)->format('Y-m-d') }}
                        </small>
                    @endif
                </td>
                <td class="text-left align-middle">
                    €{{ number_format($book->price, 2, ",", "") }}
                </td>
            </tr>
        @endforeach
    </table>
    @if($books->hasMorePages())
        <div class="card-footer">
            {!! $books->links() !!}
        </div>
    @endif
@endif
