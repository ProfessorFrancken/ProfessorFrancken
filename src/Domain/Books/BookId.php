<?php

namespace Francken\Domain\Books;

use Francken\Domain\Identifier;

/**
 * Note that unlike other Ids this class does overrides the constructor
 * so that we can also use ids that are not UUIDs.
 * This is because the old database which we use to retrieve books from,
 * currently uses ints for the ids.
 */
final class BookId extends Identifier
{
    /**
     * @param string $committeeId
     */
    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public static function fromLegacyId(int $id)
    {
        return new self((string) $id);
    }
}
