<?php

declare(strict_types=1);

namespace Francken\Features\Admin;

use Faker\Factory;
use Francken\Association\Boards\Http\Controllers\AdminBoardsController;
use Francken\Association\News\Eloquent\News;
use Francken\Association\News\Fake\FakeNews;
use Francken\Features\LoggedInAsAdmin;
use Francken\Features\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;

class BoardsFeature extends TestCase
{
    use DatabaseMigrations;
    use LoggedInAsAdmin;
    use DatabaseTransactions;

    private $news;

    // inmemory with fakes
    /** @before */
    public function setupBoards() : void
    {
        // $this->afterApplicationCreated(function () : void {
        //     $faker = Factory::create();
        //     $faker->seed(31415);
        //     $fakeNews = new FakeNews($faker, 10);
        //     $this->news = $fakeNews->all();

        //     foreach ($this->news as $news) {
        //         News::fromNewsItem($news)->save();
        //     }
        // });
    }

    /** @test */
    public function a_list_of_boards_is_shown() : void
    {
        $this->visit(action([AdminBoardsController::class, 'index']));

        $this->assertResponseOk();
    }

    /** @test */
    public function a_board_can_be_installed() : void
    {
        $file = UploadedFile::fake()->image('board.png');
        $this->visit(action([AdminBoardsController::class, 'create']));
        $this->assertResponseOk();
        $this->type('Hè Watt?', 'name')
            ->type('2017-06-06', 'installed_at')
            ->attach($file, 'photo')
            ->press('Install')
            ->see('Hè Watt?');

        return;
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
}
