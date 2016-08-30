<?php

declare(strict_types=1);

namespace Francken\Domain\Posts;

use InvalidArgumentException;

class PostCategory
{
    private $type;

    const BLOGPOST = 'blog';
    const NEWSPOST = 'news';

    private function __construct(string $type)
    {
        $this->type = $type;
    }

    public static function fromString(string $type) : PostCategory
    {
        if (! in_array($type, [PostCategory::BLOGPOST, PostCategory::NEWSPOST]))
        {
            throw new InvalidArgumentException("{$type} is not a valied post category");
        }
        return new PostCategory($type);
    }

    public function __toString() : string
    {
        return $this->type;
    }
}
