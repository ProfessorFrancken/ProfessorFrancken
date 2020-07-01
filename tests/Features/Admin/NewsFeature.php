<?php

declare(strict_types=1);

namespace Francken\Features\Admin;

use Faker\Factory;
use Francken\Association\News\Eloquent\News;
use Francken\Association\News\Fake\FakeNews;
use Francken\Association\News\Http\AdminNewsController;
use Francken\Features\LoggedInAsAdmin;
use Francken\Features\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class NewsFeature extends TestCase
{
    use DatabaseMigrations;
    use LoggedInAsAdmin;
    use DatabaseTransactions;

    private $news;

    // inmemory with fakes
    /** @before */
    public function setupNews() : void
    {
        $this->afterApplicationCreated(function () : void {
            $faker = Factory::create();
            $faker->seed(31415);
            $fakeNews = new FakeNews($faker, 10);
            $this->news = $fakeNews->all();

            foreach ($this->news as $news) {
                News::fromNewsItem($news)->save();
            }
        });
    }

    /** @test */
    public function a_list_of_news_is_shown() : void
    {
        $this->visit(action([AdminNewsController::class, 'index']));

        $this->assertResponseOk();
    }

    /** @test */
    public function a_news_item_can_be_changed() : void
    {
        $newsItem = $this->news[0];
        $news = News::byLink($newsItem->link())->first();
        $this->visit(
            action([AdminNewsController::class, 'show'], ['news' => $news])
        )
             ->see($news->title);

        $this->assertResponseOk();

        $this->type('Mooie gekken', 'title')
            ->type('Franckenleden', 'content')
            ->press('Update')
            ->see('Mooie gekken')
            ->see('Franckenleden');
    }

    /** @test */
    public function uploading_an_author_image() : void
    {
        $newsItem = $this->news[0];
        $news = News::byLink($newsItem->link())->first();
        $this->visit(
            action([AdminNewsController::class, 'show'], ['news' => $news])
        )
             ->see($news->title);

        $this->type('Mark', 'author-name')
             ->type('a_picture.png', 'author-photo')
             ->press('Update')
             ->see('Mark');

        $news->refresh();
        $this->assertEquals($news->author_name, 'Mark');
        $this->assertEquals($news->author_photo, 'a_picture.png');
    }

    /** @test */
    public function chaning_the_publication_date() : void
    {
        $newsItem = $this->news[0];
        $news = News::byLink($newsItem->link())->first();
        $this->visit(
            action([AdminNewsController::class, 'show'], ['news' => $news])
        )
            ->type('2018-01-07', 'publish-at')
            ->press('Publish');

        $news->refresh();

        $this->assertEquals($news->published_at, new \DateTimeImmutable('2018-01-07'));
    }

    /** @test */
    public function creating_a_new_news_post() : void
    {
        $this->visit(action([AdminNewsController::class, 'create']))
            ->type('Bitterballen dibs machines', 'title')
            ->type('Bitterballen are nice', 'content')
            ->type('About bitterballen', 'exerpt')
            ->type('Mark', 'author-name')
            ->type('picture', 'author-photo')
            ->press('Save');

        $news = News::orderBy('id', 'desc')->first();

        $this->assertEquals(
            'Bitterballen dibs machines', $news->title
        );
        $this->assertEquals(
            'Bitterballen are nice', $news->source_contents
        );
        $this->assertEquals(
            'About bitterballen', $news->exerpt
        );
    }


    // it gives a warning when editing news items imported from our wordpress website
}
