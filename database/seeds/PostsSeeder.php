<?php

declare(strict_types=1);

use Francken\Domain\Posts\Post;
use Francken\Domain\Posts\PostCategory;
use Francken\Domain\Posts\PostId;
use Francken\Domain\Posts\PostRepository;
use Illuminate\Database\Seeder;

final class PostsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $repo = App::make(PostRepository::class);
        $faker = App::make(Faker\Generator::class);
        $faker->addProvider(new \DavidBadura\FakerMarkdownGenerator\FakerProvider($faker));
        $categories = [
            PostCategory::fromString(PostCategory::BLOGPOST),
            PostCategory::fromString(PostCategory::NEWSPOST)
        ];

        for ($i = 0; $i < 10; $i++) {
            $id = PostId::generate();


            $post = Post::createDraft(
                $id,
                $faker->sentence,
                implode($faker->paragraphs(4), "\n"),
                $faker->randomElement($categories)
            );

            $post->setPublishDate(new Carbon\Carbon);

            $repo->save($post);
        }
    }
}
