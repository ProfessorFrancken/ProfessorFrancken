<?php

declare(strict_types=1);

namespace Francken\Association\FranckenVrij;

use InvalidArgumentException;

final class Volume
{
    private $volume;
    private $editions;

    public function __construct(int $volume, array $editions)
    {
        $this->volume = $volume;
        $this->setEditions(...$editions);
    }

    public function volume() : int
    {
        return $this->volume;
    }

    public function editions() : array
    {
        return $this->editions;
    }

    private function setEditions(Edition ...$editions) : void
    {
        foreach ($editions as $edition) {
            if ($edition->volume() !== $this->volume) {
                throw new InvalidArgumentException(
                    sprintf(
                        "Tried to add edition of volume [%d] to volume [%d]",
                        $edition->volume(),
                        $this->volume
                    )
                );
            }
        }

        $this->editions = $editions;
    }
}
