<?php

declare(strict_types=1);

namespace Francken\Association\FranckenVrij;

use Broadway\ReadModel\Identifiable as ReadModelInterface;
use Broadway\Serializer\Serializable as SerializableInterface;
use Francken\Shared\Serializable;
use Francken\Shared\Url;
use InvalidArgumentException;

final class Edition implements ReadModelInterface, SerializableInterface
{
    use Serializable;

    private $title;
    private $volume;
    private $edition;

    private $cover;
    private $pdf;
    private $id;

    private function __construct()
    {
    }

    public static function publish(
        EditionId $id,
        string $title,
        int $volume,
        int $edition,
        Url $cover,
        Url $pdf
    ) : self {
        $vrij = new self();

        if ($volume <= 0) {
            throw new InvalidargumentException("Volume must be positive, [{$volume}] given");
        }

        if (($edition <= 0) || ($edition > 3)) {
            throw new InvalidargumentException("Edition number must be between 1 and 3, [{$edition}]");
        }

        $vrij->title = $title;
        $vrij->volume = $volume;
        $vrij->edition = $edition;
        $vrij->cover = (string)$cover;
        $vrij->pdf = (string)$pdf;
        $vrij->id = (string)$id;

        return $vrij;
    }

    public function getId() : string
    {
        return $this->id;
    }

    public function title() : string
    {
        return $this->title;
    }

    public function volume() : int
    {
        return (int)$this->volume;
    }

    public function edition() : int
    {
        return (int)$this->edition;
    }

    public function pdf() : Url
    {
        return new Url($this->pdf);
    }

    public function cover() : Url
    {
        return new Url($this->cover);
    }
}
