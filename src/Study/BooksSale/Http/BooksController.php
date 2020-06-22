<?php

declare(strict_types=1);

namespace Francken\Study\BooksSale\Http;

use Francken\Infrastructure\Http\Controllers\Controller;
use Francken\Study\BooksSale\LegacyBook;

class BooksController extends Controller
{
    public function index()
    {
        $books = LegacyBook::query()
            ->available()
            ->orderBy('naam', 'asc')
            ->orderBy('editie', 'desc')
            ->paginate(20);

        return view('book.index')
            ->with(['books'=> $books])
            ->with('breadcrumbs', [
                ['url' => '/study', 'text' => 'Study'],
                ['url' => '/study/books', 'text' => 'Books'],
            ]);
    }

    public function show(LegacyBook $book)
    {
        return view('book.show')
            ->with(['book' => $book])
            ->with('breadcrumbs', [
                ['url' => '/study', 'text' => 'Study'],
                ['url' => '/study/books', 'text' => 'Books'],
                ['text' => $book->title()],
            ]);
    }
}
