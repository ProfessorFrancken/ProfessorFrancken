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

    
    public function load(PostId $postId) : Post
    {
        return $this->repo->load((string)$postId);
    }

    
    public function save(Post $post) : void
    {
        $this->repo->save($post);
    }
}
