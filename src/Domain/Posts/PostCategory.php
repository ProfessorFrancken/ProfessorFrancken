<?php

declare(strict_types=1);

namespace Francken\Domain\Posts;

use InvalidArgumentException;

class PostCategory
{
    public const BLOGPOST = 'blog';
    public const NEWSPOST = 'news';
    private $type;

    private function __construct(string $type)
    {
        $this->type = $type;
    }

    public function __toString() : string
    {
        return $this->type;
    }

    public static function fromString(string $type) : self
    {
        if ( ! in_array($type, [self::BLOGPOST, self::NEWSPOST], true)) {
            throw new InvalidArgumentException("{$type} is not a valied post category");
        }
        return new self($type);
    }
}
