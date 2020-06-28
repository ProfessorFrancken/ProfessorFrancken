<?php

declare(strict_types=1);

namespace Francken\Study\BooksSale\Http;

use DateTimeImmutable;
use DB;
use Francken\Study\BooksSale\Book;
use Francken\Study\BooksSale\Http\Requests\AdminBookSearchRequest;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

final class AdminBooksController
{
    public function index(AdminBookSearchRequest $request)
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
            'members' => $this->members(),
            'breadcrumbs' => [
                ['url' => action([self::class, 'index']), 'text' => 'Books'],
            ]
        ]);
    }

    public function show(Book $book)
    {
        return view('admin.study.books.show', [
            'book' => $book,
            'members' => $this->members(),
            'breadcrumbs' => [
                ['url' => action([self::class, 'index']), 'text' => 'Books'],
                ['url' => action([self::class, 'show'], ['book' => $book]), 'text' => $book->title],
            ]
        ]);
    }

    public function create()
    {
        return view('admin.study.books.create', [
            'book' => new Book(),
            'members' => $this->members(),
            'breadcrumbs' => [
                ['url' => action([self::class, 'index']), 'text' => 'Books'],
                ['url' => action([self::class, 'create']), 'text' => 'Add'],
            ]
        ]);
    }

    public function store(Request $request)
    {
        $now = new DateTimeImmutable();

        $inkoopdatum = ($request->filled('purchase_date'))
            ? (new DateTimeImmutable($request->get('purchase_date')))->format('Y-m-d H:i:s')
            : $now->format('Y-m-d H:i:s');

        $verkoopdatum = ($request->filled('sale_date'))
            ? (new DateTimeImmutable($request->get('sale_date')))->format('Y-m-d H:i:s')
            : null;

        $book = [
            "naam" => $request->input('title'),
            "editie" => $request->input('edition'),
            'auteur' => $request->input('author'),
            'beschrijving' => $request->input('description'),
            'isbn' => $request->input('isbn'),
            'prijs' => $request->input('price'),

            'verkoperid' => $request->input('seller_id'),
            'koperid' => $request->input('buyer_id'),

            'inkoopdatum' => $inkoopdatum,
            'verkoopdatum' => $verkoopdatum,

            "verkocht" => $request->has('sold'),
            "afgerekend" => $request->has('paid_off'),
        ];

        $book = Book::create($book);

        return redirect()->action([self::class, 'index']);
    }

    public function update(Request $request, Book $book)
    {
        $now = new DateTimeImmutable();

        $inkoopdatum = ($request->filled('purchase_date'))
            ? (new DateTimeImmutable($request->get('purchase_date')))->format('Y-m-d H:i:s')
            : $now->format('Y-m-d H:i:s');

        $verkoopdatum = ($request->filled('sale_date'))
            ? (new DateTimeImmutable($request->get('sale_date')))->format('Y-m-d H:i:s')
            : null;

        $book->update([
            "naam" => $request->input('title'),
            "editie" => $request->input('edition'),
            'auteur' => $request->input('author'),
            'beschrijving' => $request->input('description'),
            'isbn' => $request->input('isbn'),
            'prijs' => $request->input('price'),

            'verkoperid' => $request->input('seller_id'),
            'koperid' => $request->input('buyer_id'),

            'inkoopdatum' => $inkoopdatum,
            'verkoopdatum' => $verkoopdatum,

            "verkocht" => $request->has('sold'),
            "afgerekend" => $request->has('paid_off'),
        ]);

        return redirect()->action([self::class, 'show'], ['book' => $book]);
    }

    public function remove(Book $book)
    {
        if ($book->buyer !== null) {
            return redirect()->action([self::class, 'show'], ['book' => $book])->with([
                'error' => "You are not allowed to remove a book that has been sold"
            ]);
        }

        $book->delete();

        return redirect()->action([self::class, 'index']);
    }

    public function print(Book $book)
    {
        return view('admin.study.books.print', [
            'book' => $book,
            'members' => $this->members(),
            'breadcrumbs' => [
                ['url' => action([self::class, 'index']), 'text' => 'Books'],
                ['url' => action([self::class, 'show'], ['book' => $book]), 'text' => $book->title],
            ]
        ]);
    }
    private function members()
    {
        return DB::connection('francken-legacy')
            ->table('leden')
            ->where('is_lid', true)
            ->select(['id',  'voornaam', 'tussenvoegsel', 'achternaam'])
            ->orderBy('id', 'desc')
            ->get();
    }
}
