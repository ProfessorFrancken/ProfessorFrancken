<?php

declare(strict_types=1);

namespace Francken\Association\Boards;

use DateTimeImmutable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Plank\Mediable\Media;
use Plank\Mediable\Mediable;
use Webmozart\Assert\Assert;

/**
 * Francken\Association\Boards\Board
 *
 * @property int $id
 * @property string|null $name
 * @property string $photo_position
 * @property \Illuminate\Support\Carbon $installed_at
 * @property \Illuminate\Support\Carbon|null $demissioned_at
 * @property \Illuminate\Support\Carbon|null $decharged_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $photo_media_id
 * @property mixed $board_name
 * @property-read mixed $board_year
 * @property-read mixed $photo
 * @property-read \Illuminate\Database\Eloquent\Collection|\Plank\Mediable\Media[] $media
 * @property-read int|null $media_count
 * @property-read \Plank\Mediable\MediableCollection|\Francken\Association\Boards\BoardMember[] $members
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
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Boards\Board withMedia($tags = array(), $matchAll = false)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Boards\Board withMediaMatchAll($tags = array())
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Boards\Board withPhotos()
 * @mixin \Eloquent
 * @method static \Plank\Mediable\MediableCollection|static[] all($columns = ['*'])
 * @method static \Plank\Mediable\MediableCollection|static[] get($columns = ['*'])
 */
final class Board extends Model
{
    use Mediable;

    private const BOARD_PHOTO_TAG = 'board_photo';

    protected $table = 'association_boards';
    protected $fillable = [
        'name',
        'photo_position',

        'installed_at',
        'demissioned_at',
        'decharged_at',

        'photo_media_id',
    ];

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

    public function members()
    {
        // Order the BoardMembers by id so that their position on the boards page is shown correctly
        return $this->hasMany(BoardMember::class)->orderBy('id', 'desc');
    }

    public function getPhotoAttribute() : ?string
    {
        $photo = $this->getMedia(static::BOARD_PHOTO_TAG)->first();

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
        return new BoardName($this->name);
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

    public function scopeWithPhotos($query)
    {
        return $query->withMedia([static::BOARD_PHOTO_TAG]);
    }
}
