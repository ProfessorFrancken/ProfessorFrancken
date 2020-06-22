<?php

declare(strict_types=1);

namespace Francken\Study\BooksSale\Http;

use Francken\Study\BooksSale\AvailableBooks\AvailableBooksRepository;
use Francken\Domain\Books\Book;
use Francken\Domain\Books\BookId;
use Francken\Domain\Books\BookRepository;
use Francken\Domain\Members\MemberId;
use Francken\Infrastructure\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BooksController extends Controller
{
    private $books;

    public function __construct(AvailableBooksRepository $books)
    {
        $this->books = $books;
    }

    public function index()
    {
        $books = $this->books->findAll();

        return view('book.index')
            ->with(['books'=> $books])
            ->with('breadcrumbs', [
                ['url' => '/study', 'text' => 'Study'],
                ['url' => '/study/books', 'text' => 'Books'],
            ]);
    }

    public function show($id)
    {
        $book = $this->books->find(new BookId($id));

        return view('book.show')
            ->with(['book' => $book])
            ->with('breadcrumbs', [
                ['url' => '/study', 'text' => 'Study'],
                ['url' => '/study/books', 'text' => 'Books'],
                ['text' => $book->title()],
            ]);
    }

    //-----------------------
    //-----REQUIRE LOGIN-----
    //-----------------------
    public function create()
    {
        return view('book.create');
    }

    public function store(Request $req, BookRepository $repo)
    {
        $isbn = new \Isbn\Isbn();

        ///@todo validation
        if ( ! $isbn->check->identify($req->input('isbn'))) {
            throw new \Exception('Not an ISBN');
        }

        $isbn_10 = $isbn->hyphens->removeHyphens($req->input('isbn'));

        if ($isbn->check->identify($isbn_10) == 13) {
            $isbn_10 = $isbn->translate->to10($isbn_10);
        }

        $book = Book::offer(
            BookId::generate(),
            MemberId::generate(), //get session ID?
            $isbn_10,
            $req->input('price') * 100
        );

        $repo->save($book);

        return redirect('/books');
    }

    public function buy(Request $req, BookRepository $repo, $id)
    {
        $book = $repo->load(new BookId($id));
        $book->sellToMember(MemberId::generate()); ///@todo use session memberId
        $repo->save($book);

        return redirect('/study/books');
    }

    public function update(Request $req, BookRepository $repo, $id) : void
    {
    }

    public function destroy($id) : void
    {
    }
}
