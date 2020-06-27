<?php

declare(strict_types=1);

namespace Francken\Study\BooksSale\Http;

use DateTimeImmutable;
use DB;
use Francken\Study\BooksSale\Book;
use Francken\Study\BooksSale\BookBuyer;
use Francken\Study\BooksSale\BookSeller;
use Francken\Study\BooksSale\Http\Requests\AdminBookSearchRequest;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

final class AdminBooksController
{
    public function index(AdminBookSearchRequest $request)
    {
        $books = Book::query()
            ->when($request->title(), function (Builder $query, string $title) : void {
                $query->where('naam', 'LIKE', '%' . $title . '%');
            })
            ->when(!$request->showSoldBooks(), function (Builder $query, bool $dontShowSoldBooks): void {
                if ($dontShowSoldBooks) {
                    $query->where(function ($query) {
                        return $query->where('verkoopdatum', null)
                            ->orWhere('koperid', null)
                            ->orWhere('verkocht', false);
                    });
                }
            })
            ->when($request->sellerId(), function (Builder $query, int $sellerId) {
                $query->where('verkoperid', $sellerId);
            })
            ->when($request->buyerId(), function (Builder $query, int $buyerId) {
                $query->where('koperId', $buyerId);
            })
            ->with(['seller', 'buyer'])
            ->orderBy('id', 'desc')
            ->paginate(30)
            ->appends($request->except('page'));
        
        $seller = BookSeller::find($request->sellerId());
        $buyer = BookBuyer::find($request->buyerId());

        return view('admin.study.books.index', [
            'request' => $request,
            'seller' => optional($seller)->full_name,
            'buyer' => optional($buyer)->full_name,
            'books' => $books,                
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
                ['url' => action([self::class, 'show'], $book->id), 'text' => $book->title],
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

        return redirect()->action([self::class, 'show'], $book->id);
    }

    public function remove(Request $request, Book $book)
    {
        if ($book->buyer === null) {
            $book->delete();
        }

        return redirect()->action([self::class, 'index']);
    }

    public function print(Book $book)
    {
        return view('admin.study.books.print', [
            'book' => $book,
            'members' => $this->members(),
            'breadcrumbs' => [
                ['url' => action([self::class, 'index']), 'text' => 'Books'],
                ['url' => action([self::class, 'show'], $book->id), 'text' => $book->title],
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
