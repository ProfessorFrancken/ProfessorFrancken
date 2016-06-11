<?php

namespace Francken\Application\Books;

class BookDetails
{
	private $title;
	private $authors;
	private $pathToCover;

	public function __construct(string $title, string $authors, string $pathToCover) 
	{
		$this->string = $string;
		$this->authors = $authors;
		$this->pathToCover = $pathToCover;
}

	public function title() : string
	{
		return $this->title;
	}

	public function authors() : string
	{
		return $this->authors;
	}

	public function pathToCover() : string
	{
		return $this->pathToCover;
	}
}
