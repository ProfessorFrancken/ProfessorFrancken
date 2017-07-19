<?php

declare(strict_types=1);

namespace Francken\Application\Career;

class Sector
{
    // Engineering and Industry and utilities are too vague
    // Optics, sound
    const SECTORS = [
        "Energy and sustainability" => "tree",
        "Engineering" => "wrench",
        "Industry and utilities" => "industry",
        "Manufacturing" => "industry",
        "High tech electronics" => "microchip",
        "Financial services" => "line-chart",
        "Education" => "graduation-cap",
        "IT and programming" => "terminal",
        "Consulting and advisory" => "suitcase",
        "Gas, oil and petrochemical" => "tint", // combine with energy and sustainability?
        "Healthcare" => "medkit", // ambulance
        "Defense and security" => "shield", // plane, ship, space-shuttle
    ];

    private $sector;

    public function __construct(string $sector)
    {
        if (! array_key_exists($sector, self::SECTORS)) {
            throw new \InvalidArgumentException(sprintf('[%s] is not a valid job type', $sector));
        }

        $this->sector = $sector;
    }

    public static function fromString(string $sector) : ?self
    {
        try {
            return new self($sector);
        } catch (\InvalidArgumentException $e) {
            return null;
        }
    }

    public function fontawesomeIcon() : string
    {
        return '';
    }

    public function __toString() : string
    {
        return $this->sector;
    }
}
