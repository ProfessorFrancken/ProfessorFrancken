<?php

namespace Francken\Domain\Books;


//isbn-10 without hyphens
class ISBN
{
	private $isbn;

	private function __construct(string $isbn)
	{
		$this->isbn = $isbn;
	}

	public static function fromString(string $isbn) : ISBN
	{
		if (!isValid($isbn))
			throw new Exception("Invalid ISBN provided");
		return new ISBN($str);	
	}

	public function __toString()
	{
		return $this->isbn;
	}

	private function isValid(string $isbn) : bool
	{
		if(length($isbn) !== 10)
			return false;
		$sum = 0;
		for($i = 0; $i < 10; $i++)
		{
			$sum += ((int) $isbn[i]) * (9 - i);
		}
		if ($sum % 11 === 0)
			return true;
		return false;
	}
}
