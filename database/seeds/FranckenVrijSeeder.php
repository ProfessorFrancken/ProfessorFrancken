<?php

declare(strict_types=1);

use Francken\Application\FranckenVrij\Edition;
use Francken\Application\FranckenVrij\FranckenVrijRepository;
use Francken\Domain\FranckenVrij\EditionId;
use Illuminate\Database\Seeder;
use Francken\Domain\Url;

final class FranckenVrijSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $editions = App::make(FranckenVrijRepository::class);

        // Save all existing editions
        foreach (range(20, 1, -1) as $volume) {
            foreach (range(1, 3) as $edition) {
                $editions->save(
                    Edition::publish(
                        EditionId::generate(),
                        "Francken Vrij " . $volume . '.' . $edition,
                        $volume,
                        $edition,
                        new Url("http://www.professorfrancken.nl/franckenvrij/webplaatjes/{$volume}.{$edition}.jpg"),
                        new Url("http://www.professorfrancken.nl/franckenvrij/{$volume}.{$edition}.pdf")
                    )
                );
            }
        }
    }
}
