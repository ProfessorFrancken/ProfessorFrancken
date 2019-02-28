<?php

declare(strict_types=1);

namespace Francken\Features\Admin;

use Faker\Factory;
use Francken\Association\News\Eloquent\News;
use Francken\Association\News\Fake\FakeNews;
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
        $this->visit('/admin/association/news');

        $this->assertResponseOk();
    }

    /** @test */
    public function a_news_item_can_be_changed() : void
    {
        $news = $this->news[0];
        $id = News::byLink($news->link())->first()->id;
        $this->visit('/admin' . $news->url())
             ->see($news->title());

        $this->assertResponseOk();

        $this->type('Mooie gekken', 'title')
            ->type('Franckenleden', 'content')
            ->press('Update')
            ->see('Mooie gekken')
            ->see('Franckenleden');
        // ->see('"New title" was succesfully updated.');
        $updated = News::find($id)->toNewsItem();

        // Recently there was a bug where the publication date was changed
        $this->assertEquals($news->publicationDate(), $updated->publicationDate());
    }

    /** @test */
    public function uploading_an_author_image() : void
    {
        $news = $this->news[0];
        $id = News::byLink($news->link())->first()->id;
        $this->visit('/admin' . $news->url())
             ->see($news->title());

        $this->type('Mark', 'author-name')
             ->type('a_picture.png', 'author-photo')
             ->press('Update')
             ->see('Mark');

        $updated = News::find($id)->toNewsItem();
        $this->assertEquals($updated->authorName(), 'Mark');
        $this->assertEquals($updated->authorPhoto(), 'a_picture.png');
    }

    /** @test */
    public function chaning_the_publication_date() : void
    {
        $news = $this->news[0];
        $id = News::byLink($news->link())->first()->id;
        $this->visit('/admin' . $news->url())
            ->type('2018-01-07', 'publish-at')
            ->press('Publish');

        $updated = News::find($id)->toNewsItem();

        $this->assertEquals($updated->publicationDate(), new \DateTimeImmutable('2018-01-07'));
    }

    /** @test */
    public function creating_a_new_news_post() : void
    {
        $this->visit('/admin/association/news/create')
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
