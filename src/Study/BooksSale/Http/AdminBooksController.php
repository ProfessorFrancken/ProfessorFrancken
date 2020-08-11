<?php

declare(strict_types=1);

namespace Francken\Study\BooksSale\Http;

use Francken\Study\BooksSale\Book;
use Francken\Study\BooksSale\Http\Requests\AdminBookRequest;
use Francken\Study\BooksSale\Http\Requests\AdminBookSearchRequest;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

final class AdminBooksController
{
    public function index(AdminBookSearchRequest $request) : View
    {
        $books = Book::query()
            ->search($request)
            ->when($request->selected('available'), function (Builder $query) : void {
                $query->available();
            })
            ->when($request->selected('paid-off'), function (Builder $query) : void {
                $query->paidOff();
            })
            ->when($request->selected('sold'), function (Builder $query) : void {
                $query->sold();
            })
            ->with(['seller', 'buyer'])
            ->orderBy('id', 'desc')
            ->paginate(30)
            ->appends($request->except('page'));

        return view('admin.study.books.index', [
            'request' => $request,
            'books' => $books,
            'available_books' => Book::available()->count(),
            'sold_books' => Book::sold()->count(),
            'paid_off_books' => Book::paidOff()->count(),
            'all_books' => Book::count(),
            'breadcrumbs' => [
                ['url' => action([self::class, 'index']), 'text' => 'Books'],
            ]
        ]);
    }

    public function show(Book $book) : View
    {
        return view('admin.study.books.show', [
            'book' => $book,
            'breadcrumbs' => [
                ['url' => action([self::class, 'index']), 'text' => 'Books'],
                ['url' => action([self::class, 'show'], ['book' => $book]), 'text' => $book->title],
            ]
        ]);
    }

    public function create() : View
    {
        return view('admin.study.books.create', [
            'book' => new Book(),
            'breadcrumbs' => [
                ['url' => action([self::class, 'index']), 'text' => 'Books'],
                ['url' => action([self::class, 'create']), 'text' => 'Add'],
            ]
        ]);
    }

    public function store(AdminBookRequest $request) : RedirectResponse
    {
        $book = [
            "title" => $request->title(),
            "edition" => $request->edition(),
            'author' => $request->author(),
            'description' => $request->description(),
            'isbn' => $request->isbn(),
            'price' => $request->price(),

            'seller_id' => $request->sellerId(),
            'buyer_id' => $request->buyerId(),

            'taken_in_from_seller_at' => $request->purchaseDate(),
            'taken_in_by_buyer_at' => $request->saleDate(),

            "has_been_sold" => $request->hasBeenSold(),
            "paid_off" => $request->hasBeenPaidOff(),
        ];

        $book = Book::create($book);

        return redirect()->action([self::class, 'show'], ['book' => $book]);
    }

    public function update(AdminBookRequest $request, Book $book) : RedirectResponse
    {
        $book->update([
            "title" => $request->title(),
            "edition" => $request->edition(),
            'author' => $request->author(),
            'description' => $request->description(),
            'isbn' => $request->isbn(),
            'price' => $request->price(),

            'seller_id' => $request->sellerId(),
            'buyer_id' => $request->buyerId(),

            'taken_in_from_seller_at' => $request->purchaseDate(),
            'taken_in_by_buyer_at' => $request->saleDate(),

            "has_been_sold" => $request->hasBeenSold(),
            "paid_off" => $request->hasBeenPaidOff(),
        ]);

        return redirect()->action([self::class, 'show'], ['book' => $book]);
    }

    public function remove(Book $book) : RedirectResponse
    {
        if ($book->buyer !== null) {
            return redirect()->action([self::class, 'show'], ['book' => $book])->with([
                'error' => "You are not allowed to remove a book that has been sold"
            ]);
        }

        $book->delete();

        return redirect()->action([self::class, 'index']);
    }

    public function print(Book $book) : View
    {
        return view('admin.study.books.print', [
            'book' => $book,
            'breadcrumbs' => [
                ['url' => action([self::class, 'index']), 'text' => 'Books'],
                ['url' => action([self::class, 'show'], ['book' => $book]), 'text' => $book->title],
            ]
        ]);
    }
}
