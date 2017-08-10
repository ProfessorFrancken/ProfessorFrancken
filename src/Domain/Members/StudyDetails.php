<?php

declare(strict_types=1);

namespace Francken\Domain\Members;

use DateTimeImmutable;
use Broadway\Serializer\SerializableInterface;
use Francken\Domain\Serializable;

final class StudyDetails implements SerializableInterface
{
    use Serializable;

    private $studentNumber;
    private $studies;

    public function __construct(
        string $studentNumber,
        Study ...$studies
    ) {
        $this->studentNumber = $studentNumber;
        $this->studies = $studies;
    }

    public function studentNumber() : string
    {
        return $this->studentNumber;
    }

    public function studies() : array
    {
        return $this->studies;
    }

    protected static function deserializationCallbacks()
    {
        return ['studies' => [Study::class, 'deserialize']];
    }
}
