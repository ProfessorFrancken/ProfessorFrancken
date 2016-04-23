<?php

namespace Francken\Posts;

class PostCategory
{
	private $type;

	const BLOGPOST = 'blog';
    const NEWSPOST = 'news';

    private function __constructor(string $type)
    {
    	$this->type = $type;
    }

    public static function fromString(string $type)
    {
    	if (! in_array($type, [PostCategory::BLOGPOST, PostCategory::NEWSPOST]))
    		throw \InvalidArgumentException("{$type} is not a valied post category");
    	return new PostCategory($type);
    }

    public function __toString()
    {
    	return $type;
    }
}
