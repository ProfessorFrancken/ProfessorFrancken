<?php

declare(strict_types=1);

use Francken\Domain\Committees;
use Francken\Domain\Members\Email;
use Illuminate\Database\Seeder;

final class CommitteesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $repo = App::make(Committees\CommitteeRepository::class);
        $faker = App::make(Faker\Generator::class);
        $faker->addProvider(new \DavidBadura\FakerMarkdownGenerator\FakerProvider($faker));

        for ($i = 0; $i < 10; $i++) {
            $id = Committees\CommitteeId::generate();
            $committee = Committees\Committee::instantiate(
                $id,
                $faker->name,
                $faker->paragraph
            );
            $committee->setCommitteePage(
                $faker->markdown
            );
            $committee->setEmail(new Email('info@professorfrancken.nl'));
            $repo->save($committee);
        }
    }
}
