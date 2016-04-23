<?php

namespace Francken\Post;

class PostCategory
{
	private $type;

	const BLOGPOST = 'blog';
    const NEWSPOST = 'news';

    private __constructor(string $type)
    {
    	$this->type = $type;
    }

    public static fromString(string $type)
    {
    	if (! in_array($type, [BLOGPOST, NEWSPOST]))
    		throw \InvalidArgumentException("{$type} is not a valied post category");
    	$this->type = $type;
    }

    public __toString()
    {
    	return $type;
    }
}
