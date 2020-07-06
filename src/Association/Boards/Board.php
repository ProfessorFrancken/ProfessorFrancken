<?php

declare(strict_types=1);

namespace Francken\Association\Boards;

use DateTimeImmutable;
use Francken\Association\Committees\Committee;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Plank\Mediable\Media;
use Plank\Mediable\Mediable;
use Plank\Mediable\MediableCollection;
use Webmozart\Assert\Assert;

/**
 * Francken\Association\Boards\Board
 *
 * @property int $id
 * @property string|null $name
 * @property string $photo_position
 * @property Carbon $installed_at
 * @property Carbon|null $demissioned_at
 * @property Carbon|null $decharged_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int|null $photo_media_id
 * @property mixed $board_name
 * @property-read mixed $board_year
 * @property-read mixed $photo
 * @property-read \Illuminate\Database\Eloquent\Collection|Media[] $media
 * @property-read int|null $media_count
 * @property-read MediableCollection|BoardMember[] $members
 * @property-read int|null $members_count
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Boards\Board newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Boards\Board newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Boards\Board query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Boards\Board whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Boards\Board whereDechargedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Boards\Board whereDemissionedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Boards\Board whereHasMedia($tags, $matchAll = false)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Boards\Board whereHasMediaMatchAll($tags)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Boards\Board whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Boards\Board whereInstalledAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Boards\Board whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Boards\Board wherePhotoMediaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Boards\Board wherePhotoPosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Boards\Board whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Boards\Board withMedia($tags = [], $matchAll = false)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Boards\Board withMediaMatchAll($tags = [])
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Boards\Board withPhotos()
 * @mixin \Eloquent
 * @method static \Plank\Mediable\MediableCollection|static[] all($columns = ['*'])
 * @method static \Plank\Mediable\MediableCollection|static[] get($columns = ['*'])
 */
final class Board extends Model
{
    use Mediable;

    /**
     * @var string
     */
    private const BOARD_PHOTO_TAG = 'board_photo';

    /**
     * @var string
     */
    protected $table = 'association_boards';
    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'photo_position',

        'installed_at',
        'demissioned_at',
        'decharged_at',

        'board_year_slug',

        'photo_media_id',
    ];

    /**
     * @var string[]
     */
    protected $dates = [
        'installed_at',
        'demissioned_at',
        'decharged_at',
    ];

    /**
     * Install a new Board
     */
    public static function install(
        BoardName $name,
        ?Media $photo,
        string $photo_position,
        DateTimeImmutable $installed_at,
        Collection $members
    ) : self {
        Assert::oneOf($photo_position, [
            '', 'NorthWest', 'North', 'NorthEast', 'West', 'Center', 'East', 'SouthWest', 'South', 'SouthEast'
        ]);
        $members->each(function (array $member) : void {
            Assert::keyExists($member, 'member_id');
            Assert::keyExists($member, 'title');
            Assert::keyExists($member, 'photo');
        });

        /** @var Board $board */
        $board = static::create([
            'name' => $name->toString(),
            'photo_position' => $photo_position,
            'installed_at' => $installed_at,
            'board_year_slug' => BoardYear::fromInstallDate($installed_at)->toSlug(),
            'photo_media_id' => $photo->id ?? null,
        ]);
        $board->attachMedia($photo, static::BOARD_PHOTO_TAG);

        $members->each(function ($member) use ($board, $installed_at) : void {
            BoardMember::install(
                $board,
                $member['member_id'],
                $member['title'],
                $installed_at,
                $member['photo']
            );
        });

        event(new BoardWasInstalled($board->id));

        return $board;
    }

    public function members() : HasMany
    {
        // Order the BoardMembers by id so that their position on the boards page is shown correctly
        return $this->hasMany(BoardMember::class)->orderBy('id', 'desc');
    }

    public function photoMedia() : BelongsTo
    {
        return $this->belongsTo(Media::class, 'photo_media_id');
    }

    public function getPhotoAttribute() : ?string
    {
        $photo = $this->photoMedia;

        if ($photo !== null) {
            return $photo->getUrl();
        }

        return null;
    }

    public function getBoardYearAttribute() : BoardYear
    {
        return BoardYear::fromInstallDate(
            DateTimeImmutable::createFromMutable(
                $this->installed_at
            )
        );
    }

    public function getBoardNameAttribute() : BoardName
    {
        return BoardName::fromNameOrYear($this->name, $this->board_year);
    }

    public function setBoardNameAttribute(BoardName $board_name) : void
    {
        $this->name = $board_name->toString();
    }

    public function updateBoardAttributes(
        BoardName $name,
        string $photo_position,
        DateTimeImmutable $installed_at,
        ?DateTimeImmutable $demissioned_at,
        ?DateTimeImmutable $decharged_at,
        ?Media $photo
    ) : void {
        $this->board_name = $name;
        $this->photo_position = $photo_position;
        $this->installed_at = $installed_at;
        $this->demissioned_at = $demissioned_at;
        $this->decharged_at = $decharged_at;

        if ($photo !== null) {
            $this->syncMedia($photo, static::BOARD_PHOTO_TAG);
            $this->photo_media_id = $photo->id;
        }

        $this->save();
    }

    public function scopeWithPhotos(Builder $query) : Builder
    {
        return $query->withMedia([static::BOARD_PHOTO_TAG]);
    }

    public function scopeCurrent(Builder $query) : Builder
    {
        return $query->whereNotNull('installed_at')
            ->orderBy('installed_at', 'desc');
    }

    public function committees() : HasMany
    {
        return $this->hasMany(Committee::class);
    }
}
