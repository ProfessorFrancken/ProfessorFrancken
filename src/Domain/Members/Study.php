<?php

declare(strict_types=1);

namespace Francken\Domain\Members;

use Broadway\Serializer\Serializable as SerializableInterface;
use DateTimeImmutable;
use Francken\Domain\Serializable;

final class Study implements SerializableInterface
{
    use Serializable;

    private $study;
    private $startDate;
    private $graduationDate;

    public function __construct(
        string $study,
        DateTimeImmutable $startDate,
        DateTimeImmutable $graduationDate = null
    ) {
        $this->study = $study;
        $this->startDate = $startDate;
        $this->graduationDate = $graduationDate;
    }

    public function study() : string
    {
        return $this->study;
    }

    public function startDate() : DateTimeImmutable
    {
        return $this->startDate;
    }

    /**
     * @return DateTimeImmutable|null
     */
    public function graduationDate()
    {
        return $this->graduationDate;
    }

    protected static function deserializationCallbacks()
    {
        return [
            'startDate' => function ($value) {
                if ($value instanceof \DateTimeImmutable) {
                    return $value;
                }
                return \DateTimeImmutable::createFromFormat('Y-m-d H:i:s.u', $value['date']);
            },
            'graduationDate' => function ($value) {
                if ($value instanceof \DateTimeImmutable) {
                    return $value;
                }
                return $value !== null ? \DateTimeImmutable::createFromFormat('Y-m-d H:i:s.u', $value['date']) : null;
            },
        ];
    }
}
