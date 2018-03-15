<?php

declare(strict_types=1);

namespace Francken\Study\BooksSale\Http;

use DB;
use DateTimeImmutable;
use Francken\Domain\Books\BookId;
use Francken\Domain\Url;
use Francken\Infrastructure\Http\Controllers\Controller;
use Francken\Application\Books\AvailableBooksRepository;
use Illuminate\Http\Request;

final class AdminBooksController
{
    private $books;

    public function __construct(AvailableBooksRepository $books)
    {
        $this->books = $books;
    }

    public function index()
    {
        $members = DB::connection('francken-legacy')
                 ->table('leden')
                 ->where('is_lid', true)
                 ->select(['id',  'voornaam', 'tussenvoegsel', 'achternaam'])
                 ->orderBy('id', 'desc')
                 ->get();

        $books = $this->books($members);

        return view('admin.study.books.index', [
            'books' => $books,
            'book' => null,
            'members' => $members
        ]);
    }

    public function store(Request $request)
    {
        $now = new DateTimeImmutable;

        $book = [
            "naam" => $request->input('title'),
            "editie" => $request->input('edition'),
            'isbn' => $request->input('isbn'),
            'auteur' => $request->input('author'),

            'verkoperid' => $request->input('seller-id'),
            'prijs' => $request->input('price'),
            'inkoopdatum' => $now->format('Y-m-d H:i:s')
        ];

        DB::connection('francken-legacy')
            ->table('boeken')
            ->insert($book);

        return redirect('/admin/study/books');
    }

    private function books($members)
    {
        return DB::connection('francken-legacy')
            ->table("boeken")
            ->where('verkoopdatum', null)
            ->orWhere('verkocht', false)
            ->orWhere('afgerekend', false)
            ->orderBy('inkoopdatum', 'asc')
            ->get()
            ->map($this->mapToBook($members))
            ->toArray();
    }

    private function mapToBook($members) {
        return function ($boek) use ($members) {
            return new class(
                BookId::fromLegacyId($boek->id),
                $boek->naam,
                $boek->auteur,
                $boek->isbn,
                'http://images.amazon.com/images/P/' . $boek->isbn . '.jpg',
                100 * $boek->prijs,
                new DateTimeImmutable($boek->inkoopdatum ?? '01-01-1111'),
                $boek->verkoopdatum ? new DateTimeImmutable($boek->verkoopdatum) : null,
                false
            ) {
                private $id;
                private $title;
                private $author;
                private $price;
                private $isbn_10;
                private $path_to_cover;
                private $sale_pending;
                private $receivedAt;

                public function __construct(
                    BookId $id,
                    string $title,
                    string $author,
                    string $isbn_10,
                    string $path_to_cover,
                    int $price,
                    DateTimeImmutable $receivedAt,
                    ?DateTimeImmutable $soldAt,
                    bool $sale_pending
                ) {
                    $this->id = (string)$id;
                    $this->title = $title;
                    $this->author = $author;
                    $this->price = $price;
                    $this->isbn_10 = $isbn_10;
                    $this->path_to_cover = $path_to_cover;
                    $this->sale_pending= $sale_pending;

                    $this->receivedAt = $receivedAt;
                }

                public function getId()
                {
                    return $this->id;
                }

                public function bookId()
                {
                    return new BookId($this->id);
                }

                public function title() : string
                {
                    return $this->title;
                }

                public function author() : string
                {
                    return $this->author;
                }

                public function price() : int
                {
                    return (int)$this->price;
                }

                public function isbn() : string
                {
                    return $this->isbn_10;
                }

                public function pathToCover() : string
                {
                    return $this->path_to_cover;
                }

                public function salePending() : bool
                {
                    return $this->sale_pending;
                }

                public function putOnSaleAt() : string
                {
                    return $this->receivedAt->format('Y-m-d');
                }
            };
        };
    }
}
