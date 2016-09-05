<?php

namespace Francken\Application\Books;

class BookDetails
{
	private $title;
	private $author;
	private $pathToCover;

	public function __construct(string $title, string $author, string $pathToCover)
	{
		$this->title = $title;
		$this->author = $author;
		$this->pathToCover = $pathToCover;
}

	public function title() : string
	{
		return $this->title;
	}

	public function author() : string
	{
		return $this->author;
	}

	public function pathToCover() : string
	{
		return $this->pathToCover;
	}
}
