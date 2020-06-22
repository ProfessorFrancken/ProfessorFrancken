<?php

declare(strict_types=1);

use Francken\Domain\Books;
use Francken\Domain\Members\MemberId;
use Illuminate\Database\Seeder;

final class BooksSeeder extends Seeder
{
    private $isbns = ['0691157243', '1603580557', '0521198119'];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $repo = App::make(BooksSale\BookRepository::class);
        $faker = App::make(Faker\Generator::class);

        foreach ($this->isbns as $isbn) {
            $sellersId = MemberId::generate();
            $bookId = BooksSale\BookId::generate();
            $book = BooksSale\Book::offer(
                $bookId,
                $sellersId,
                $isbn,
                1500
            );
            $repo->save($book);
        }
    }
}
