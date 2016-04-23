<?php

namespace Tests\Francken\Posts;

use Broadway\EventSourcing\Testing\AggregateRootScenarioTestCase;

use Francken\Posts\PostId;
use Francken\Posts\Post;
use Francken\Posts\PostCategory;
use Francken\Posts\Events\PostWritten;
use Francken\Posts\Events\PostTitleChanged;
use Francken\Posts\Events\PostContentChanged;
use Francken\Posts\Events\PostCategorized;
use Francken\Posts\Events\PostPublished;
use Francken\Posts\Events\PostUnpublished;

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
    public function once_a_draft_is_created_it_can_be_published()
    {
        $id = PostId::generate();

        $this->givenANewPost($id)
            ->when(function ($post) {
                return $post->publish();
            })
            ->then([new PostPublished($id)]);
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
