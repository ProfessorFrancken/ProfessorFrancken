<?php

namespace Tests\Francken\Posts;

use Broadway\EventSourcing\Testing\AggregateRootScenarioTestCase;

use Carbon\Carbon;

use Francken\Posts\PostId;
use Francken\Posts\Post;
use Francken\Posts\PostCategory;
use Francken\Posts\Events\PostWritten;
use Francken\Posts\Events\PostTitleChanged;
use Francken\Posts\Events\PostContentChanged;
use Francken\Posts\Events\PostCategorized;
use Francken\Posts\Events\PostPublishedAt;
use Francken\Posts\Events\PostUnpublished;
use Francken\Posts\Events\DraftDeleted;

use DateTimeImmutable;

class PostsTest extends AggregateRootScenarioTestCase
{
    protected function getAggregateRootClass()
    {
        return Post::class;
    }

    /** @test */
    public function a_post_can_be_written()
    {
        $id = PostId::generate();
        $type = PostCategory::fromString(PostCategory::BLOGPOST);

        $this->scenario
            ->when(function () use ($id, $type) {
                return Post::createDraft($id, 
                    "Post Title",
                    "Post Content",
                    $type);
            })
            ->then([new PostWritten($id,
                    "Post Title",
                    "Post Content",
                    $type)]);
    }

    /** @test */
    public function a_title_can_be_changed()
    {
        $id = PostId::generate();

        $this->givenANewPost($id)
            ->when(function ($post) {
                return $post->editTitle("New Title");
            })
            ->then([new PostTitleChanged($id, "New Title")]);
    }

    /** test */
    public function content_can_be_edited()
    {
        $id = PostId::generate();

        $this->givenANewPost($id)
            ->when(function ($post) {
                return $post->editContent("New Content");
            })
            ->then([new PostContentChanged($id, "New Content")]);
    }

    /** @test */
    public function once_a_draft_is_created_a_publish_date_can_be_set()
    {
        $id = PostId::generate();
        
        $this->givenANewPost($id)
            ->when(function ($post) {
                return $post->setPublishDate(Carbon::createFromDate(2012, 1, 1));
            })
            ->then([new PostPublishedAt($id, Carbon::createFromDate(2012, 1, 1))]);
    }

    /** @test */
    public function a_published_post_can_be_unpublished()
    { // reset back to draft.
        $id = PostId::generate();
        
        $this->givenANewPost($id)
            ->when(function ($post) {
                $post->setPublishDate(Carbon::createFromDate(2012, 1, 1));
                $post->unpublish();
            })
            ->then([new PostPublishedAt($id, Carbon::createFromDate(2012, 1, 1)),
                new PostUnpublished($id)]);
    }

    /** @test */
    public function a_draft_can_be_deleted()
    {
        $id = PostId::generate();
        
        $this->givenANewPost($id)
            ->when(function ($post) {
                $post->delete();
            })
            ->then([new DraftDeleted($id)]);
    }

    private function givenANewPost(PostId $id)
    {
        return $this->scenario
            ->withAggregateId($id)
            ->given([new PostWritten($id,
                    "Title",
                    "Content",
                    PostCategory::fromString(PostCategory::NEWSPOST))]);

    }
}
