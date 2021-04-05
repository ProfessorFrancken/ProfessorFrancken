<?php

declare(strict_types=1);

namespace Francken\Treasurer;

use Francken\Association\LegacyMember;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

/**
 * Francken\Treasurer\MemberExtra
 *
 * @property int $lid_id
 * @property int|null $prominent prominentindex
 * @property string|null $kleur kleur in hexcode
 * @property string|null $afbeelding
 * @property string|null $bijnaam
 * @property int $button_width
 * @property int $button_height
 * @property-read string|null $color
 * @property-read string $display_name
 * @property-read bool $has_small_button
 * @property-read string|null $nickname
 * @property-read string|null $photo
 * @property-read string|null $photo_url
 * @method static \Illuminate\Database\Eloquent\Builder|MemberExtra newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MemberExtra newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MemberExtra ofMember(int $memberId)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberExtra query()
 */
final class MemberExtra extends Model
{
    public $incrementing = false;
    public $timestamps = false;
    protected $primaryKey = 'lid_id';

    /**
     * @var string
     */
    protected $table = 'leden_extras';

    /**
     * @var string
     */
    protected $connection = 'francken-legacy';

    /**
     * @var string[]
     */
    protected $fillable = [
        'lid_id',
        'prominent',
        'kleur',
        'afbeelding',
        'bijnaam',
        'button_width',
        'button_height',
    ];

    public function getColorAttribute() : ?string
    {
        return $this->kleur;
    }

    public function getPhotoUrlAttribute() : ?string
    {
        if ($this->afbeelding === null) {
            return null;
        }

        if (Str::startsWith($this->afbeelding, 'http')) {
            return $this->afbeelding;
        }

        return "https://old.professorfrancken.nl/database/streep/afbeeldingen/{$this->afbeelding}";
    }


    public function scopeOfMember(Builder $query, int $memberId) : Builder
    {
        return $query->where('lid_id', $memberId);
    }

    public function getNicknameAttribute() : ?string
    {
        return $this->bijnaam;
    }

    public function getDisplayNameAttribute() : string
    {
        return $this->bijnaam ?? $this->member->fullname ?? '';
    }

    public function getHasSmallButtonAttribute() : bool
    {
        return $this->button_width !== null && $this->button_height !== null;
    }

    public function member() : BelongsTo
    {
        return $this->belongsTo(LegacyMember::class, 'lid_id');
    }
}
