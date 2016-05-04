<?php

namespace Francken\Infrastructure\Http\Controllers;

use Illuminate\Http\Request;

use Francken\Domain\Books\Book;
use Francken\Application\ReadModel\AvailableBooks;

class BookController extends Controller
{
    public function index()
    {
        // $books = AvailableBooks::all();
        return view('book.index');
    }

    public function show($id)
    {
        // $books = AvailableBooks::findOrFail($id);
        return view('book.show');
    }

    //-----------------------
    //-----REQUIRE LOGIN-----
    //-----------------------
    public function create()
    {
        return view('book.create');
    }

    public function store($id, Request $req, BookRepository $repo)
    {
        $book = Book::offer(
            $id,
            MemberId::generate(), //get session ID?
            $req->input('isbn'),
            $req->input('price'));
    }

    public function edit($id, Request $req, BookRepository $repo)
    {

    }

    public function destroy($id)
    {

    }
}
