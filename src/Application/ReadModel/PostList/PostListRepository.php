<?php

declare(strict_types=1);

namespace Francken\Application\ReadModel\PostList;

use Francken\Application\ReadModelRepository;
use Francken\Domain\Posts\PostId;

final class PostListRepository
{
    private $repo;

    public function __construct(ReadModelRepository $repo)
    {
        $this->repo = $repo;
    }

    public function save(PostList $post)
    {
        $this->repo->save($post);
    }

    public function find(PostId $id) : PostList
    {
        return $this->repo->find((string)$id);
    }
}
