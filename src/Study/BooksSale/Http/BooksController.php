<?php

declare(strict_types=1);

namespace Francken\Study\BooksSale\Http;

use Illuminate\View\View;
use Francken\Shared\Http\Controllers\Controller;
use Francken\Study\BooksSale\Book;

class BooksController extends Controller
{
    public function index(): View
    {
        $books = Book::query()
            ->available()
            ->orderBy('title', 'asc')
            ->orderBy('edition', 'desc')
            ->paginate(20);

        return view('book.index')
            ->with(['books'=> $books])
            ->with('breadcrumbs', [
                ['url' => '/study', 'text' => 'Study'],
                ['url' => '/study/books', 'text' => 'Books'],
            ]);
    }

    public function show(Book $book): View
    {
        return view('book.show')
            ->with(['book' => $book])
            ->with('breadcrumbs', [
                ['url' => '/study', 'text' => 'Study'],
                ['url' => '/study/books', 'text' => 'Books'],
                ['text' => $book->title],
            ]);
    }
}
