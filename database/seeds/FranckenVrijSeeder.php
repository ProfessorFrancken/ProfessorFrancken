<?php

declare(strict_types=1);

use Francken\Association\FranckenVrij\EditionId;
use Francken\Association\FranckenVrij\FranckenVrijEdition;
use Francken\Shared\Url;
use Illuminate\Database\Seeder;

final class FranckenVrijSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Save all existing editions
        foreach (range(21, 1, -1) as $volume) {
            foreach (range(1, 3) as $edition) {
                FranckenVrijEdition::publish(
                    EditionId::generate(),
                    "Francken Vrij " . $volume . '.' . $edition,
                    $volume,
                    $edition,
                    new Url("https://professorfrancken.nl/franckenvrij/webplaatjes/{$volume}.{$edition}.jpg"),
                    new Url("https://professorfrancken.nl/franckenvrij/{$volume}.{$edition}.pdf")
                );
            }
        }
    }
}
