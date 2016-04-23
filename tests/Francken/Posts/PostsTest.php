<?php

namespace Tests\Francken\Posts;

use Broadway\EventSourcing\Testing\AggregateRootScenarioTestCase;



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
                Post::createDraft($id, 
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
    public function once_a_draft_is_created_it_can_be_published()
    {
        $id = PostId::generate();

        $this->givenAPlannedActivity($id)
            ->when(function ($activity) {
                return $activity->publish();
            })
            ->then([new ActivityPublished($id)]);
    }

    private function givenANewPost(PostId $id)
    {
        return $this->scenario
            ->withAggregateId($id)
            ->given([new Post::createDraft($id, 
                    "Post Title",
                    "Post Content",
                    $type)]);
                )]);
    }
}
