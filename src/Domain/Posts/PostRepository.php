<?php

declare(strict_types=1);

namespace Francken\Domain\Posts;

use Broadway\EventSourcing\EventSourcingRepository;

final class PostRepository
{
    /**
     * @var EventSourcingRepository
     */
    private $repo;

    /**
     * PostRepository constructor.
     * @param $repo
     */
    public function __construct(EventSourcingRepository $repo)
    {
        $this->repo = $repo;
    }

    /**
     * @param PostId $postId
     * @return Post
     */
    public function load(PostId $postId) : Post
    {
        return $this->repo->load((string)$postId);
    }

    /**
     * @param Post $post
     */
    public function save(Post $post)
    {
        $this->repo->save($post);
    }
}
