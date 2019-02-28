<?php

declare(strict_types=1);

namespace Francken\Study\BooksSale\Http;

use DateTimeImmutable;
use DB;
use Francken\Study\BooksSale\Book;
use Illuminate\Http\Request;

final class AdminBooksController
{
    public function index(Request $request)
    {
        $books = Book::with(['seller', 'buyer'])->orderBy('id', 'desc');

        if ($request->has('title')) {
            $books->where('naam', 'LIKE', '%' . $request->get('title') . '%');
        }
        if ($request->has('seller_id') && $request->get('seller') !== null) {
            $books->where('verkoperid', $request->get('seller_id'));
        }
        if ($request->has('buyer_id') && $request->get('buyer') !== null) {
            $books->where('koperid', $request->get('buyer_id'));
        }
        if ( ! $request->has('show_sold_books')) {
            $books->where(function ($query) {
                return $query->where('verkoopdatum', null)
                    ->orWhere('koperid', null)
                    ->orWhere('verkocht', false);
            });
        }

        return view('admin.study.books.index', [
            'books' => $books->paginate(30),
            'members' => $this->members()
        ]);
    }

    public function show(Book $book)
    {
        return view('admin.study.books.show', [
            'book' => $book,
            'members' => $this->members()
        ]);
    }

    public function create()
    {
        return view('admin.study.books.create', [
            'book' => new Book(),
            'members' => $this->members()
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
