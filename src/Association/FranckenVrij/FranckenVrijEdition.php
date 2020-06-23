<?php

declare(strict_types=1);

namespace Francken\Association\FranckenVrij;

use Francken\Shared\Url;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use InvalidArgumentException;

final class FranckenVrijEdition extends Model
{
    public $timestamps = false;
    public $incrementing = false;
    protected $table = 'francken_vrij';
    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'string';
    protected $fillable = ['title', 'volume', ' edition', 'cover', 'pdf'];


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
        $vrij->save();

        return $vrij;
    }

    public static function volumes() : Collection
    {
        return self::query()
            ->orderBy('volume', 'DESC')
            ->get()
            ->groupBy('volume')
            ->map(
                function (Collection $editions, int $volume) : Volume {
                    return new Volume($volume, $editions->all());
                }
            );
    }

    public function getId() : string
    {
        return $this->attributes['id'];
    }

    public function title() : string
    {
        return $this->attributes['title'];
    }

    public function volume() : int
    {
        return (int)$this->attributes['volume'];
    }

    public function edition() : int
    {
        return (int)$this->attributes['edition'];
    }

    public function pdf() : Url
    {
        return new Url($this->attributes['pdf']);
    }

    public function cover() : Url
    {
        return new Url($this->attributes['cover']);
    }

    public function scopeLatestEdition(Builder $query) : Builder
    {
        return $query->orderBy('volume', 'DESC')->orderBy('edition', 'DESC');
    }
}
