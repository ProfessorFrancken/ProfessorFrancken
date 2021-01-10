<?php

declare(strict_types=1);

namespace Francken\Association\FranckenVrij;

use Francken\Shared\Url;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Webmozart\Assert\Assert;

/**
 * Francken\Association\FranckenVrij\Edition
 *
 * @property string $id
 * @property string $title
 * @property int $volume
 * @property int $edition
 * @property string $pdf
 * @property string $cover
 * @method static \Illuminate\Database\Eloquent\Builder latestEdition()
 * @method static \Illuminate\Database\Eloquent\Builder newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder query()
 * @method static \Illuminate\Database\Eloquent\Builder whereCover($value)
 * @method static \Illuminate\Database\Eloquent\Builder whereEdition($value)
 * @method static \Illuminate\Database\Eloquent\Builder whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder wherePdf($value)
 * @method static \Illuminate\Database\Eloquent\Builder whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder whereVolume($value)
 * @mixin \Eloquent
 */
final class Edition extends Model
{
    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var string
     */
    protected $table = 'francken_vrij';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * @var string[]
     */
    protected $fillable = [
        'id',
        'title',
        'volume',
        'edition',
        'cover',
        'pdf'
    ];


    public static function publish(
        EditionId $id,
        string $title,
        int $volume,
        int $edition,
        Url $cover,
        Url $pdf
    ) : self {
        $vrij = new self();

        Assert::greaterThan($volume, 0, "Volume must be positive, [{$volume}] given");
        Assert::greaterThan($edition, 0, "Edition number must be between 1 and 3, [{$edition}]");
        Assert::lessThanEq($edition, 3, "Edition number must be between 1 and 3, [{$edition}]");

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
                fn (Collection $editions, int $volume) : Volume => new Volume($volume, $editions->all())
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
