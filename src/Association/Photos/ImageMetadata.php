<?php

declare(strict_types=1);

namespace Francken\Association\Photos;

use DateTimeImmutable;

class ImageMetadata
{
    public function __construct(
        public readonly DateTimeImmutable | null $creationDate,
        public readonly int $width,
        public readonly int $height
    ) {
    }
}
