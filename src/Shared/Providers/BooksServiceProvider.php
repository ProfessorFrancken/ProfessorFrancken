<?php

declare(strict_types=1);

namespace Francken\Shared\Providers;

use Broadway\EventSourcing\EventSourcingRepository;
use Francken\Study\BooksSale\AvailableBooks\AvailableBook;
use Francken\Study\BooksSale\AvailableBooks\AvailableBooksRepository;
use Francken\Study\BooksSale\AvailableBooks\BookDetailsRepository;
use Francken\Application\ReadModelRepository;
use Francken\Domain\Books\Book;
use Francken\Domain\Books\BookRepository;
use Francken\Infrastructure\EventSourcing\Factory;
use Francken\Infrastructure\Repositories\IlluminateRepository;
use Francken\Study\BooksSale\AmazonBookDetailsRepository;
use Francken\Study\BooksSale\AvailableBooks\LegacyDBRepository;
use Francken\Study\BooksSale\AvailableBooks\ProjectionRepository;
use Francken\Study\BooksSale\InMemoryBookDetailsRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Database\ConnectionInterface as DatabaseConnection;
use Illuminate\Support\ServiceProvider;

final class BooksServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register() : void
    {
        $this->registerRepository(BookRepository::class, Book::class);

        // Register read model repositories and other associated services
        $this->registerReadModels();
    }

    /**
     * Register the repositorie used to store our event sourced aggregate root
     * Currently all repositories use the same configuration based on the
     * Francken\Infrastructure\EventSourcing\Factory class
     *
     * @param string $repository classname
     * @param string $aggregate  classname
     */
    private function registerRepository(string $repository, string $aggregate) : void
    {
        $this->app->when($repository)
            ->needs(EventSourcingRepository::class)
            ->give(function (Application $app) use ($aggregate) {
                $factory = $app->make(Factory::class);

                return $factory->buildForAggregate($aggregate);
            });
    }

    /**
     * Register bindings to get specific Illuminate repositories for our read models
     */
    private function registerReadModels() : void
    {
        $this->app->when(ProjectionRepository::class)
            ->needs(ReadModelRepository::class)
            ->give(
                function (Application $app) {
                    return new IlluminateRepository(
                        $app->make(DatabaseConnection::class),
                        'available_books',
                        AvailableBook::class,
                        'id'
                    );
                }
            );

        if (config('francken.books.use_legacy')) {
            $this->app->bind(AvailableBooksRepository::class, LegacyDBRepository::class);
        } else {
            $this->app->bind(AvailableBooksRepository::class, ProjectionRepository::class);
        }

        // Responsible for getting the book cover from Amazon
        if ( ! env('APP_OFFLINE', true)) {
            $this->app->bind(BookDetailsRepository::class, AmazonBookDetailsRepository::class);
        } else {
            // If we want our app to stay offline, we will use an inmemory type of BookDetailsRepository
            $books = [
                '0691157243' => ['title' => 'Welcome to the Universe', 'author' => 'Neil De Grasse Tyson'],
                '1603580557' => ['title' => 'Thinking in Systems', 'author' => 'Donella H. Maedows'],
                '0521198119' => ['title' => 'An introduction to mechanics', 'author' => 'Daniel Kleppner and Robert Kolenkow']
            ];

            $this->app->instance(
                BookDetailsRepository::class,
                new InMemoryBookDetailsRepository($books)
            );
        }
    }
}
