<?php

namespace Francken\Infrastructure\Http\Controllers;

use Illuminate\Http\Request;
use Francken\Domain\Books\Book;
use Francken\Domain\Books\BookRepository;
use Francken\Domain\Books\BookId;
use Francken\Domain\Members\MemberId;
use Francken\Application\ReadModelRepository;

class BookController extends Controller
{
    private $books;

    public function __construct(ReadModelRepository $books)
    {
        $this->books = $books;
    }

    public function index()
    {
        $books = $this->books->findAll();

        return view(
            'book.index',
            ['books'=> $books]
        );
    }

    public function show($id)
    {
        $book = $this->books->find($id);
        return view(
            'book.show',
            ['book' => $book]
        );
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
        if (!$isbn->check->identify($req->input('isbn'))) {
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
        $book = $repo->load($id);
        $book->sellToMember(MemberId::generate()); ///@todo use session memberId
        $repo->save($book);

        return redirect('/books');
    }

    public function update(Request $req, BookRepository $repo, $id)
    {
    }

    public function destroy($id)
    {
    }
}
