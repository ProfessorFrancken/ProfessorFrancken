<?php

declare(strict_types=1);

namespace Francken\Association\Boards;

use DateTimeImmutable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Plank\Mediable\Media;
use Plank\Mediable\Mediable;
use Webmozart\Assert\Assert;

final class Board extends Model
{
    use Mediable;

    private const BOARD_PHOTO_TAG = 'board_photo';

    protected $table = 'association_boards';
    protected $fillable = [
        'name',
        'photo',
        'photo_position',

        'installed_at',
        'demissioned_at',
        'decharged_at',
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

        $photo_url = ($photo !== null) ? $photo->getUrl() : null;

        /** @var Board $board */
        $board = static::create([
            'name' => $name->toString(),
            'photo' => $photo_url,
            'photo_position' => $photo_position,
            'installed_at' => $installed_at
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
        return $this->hasMany(BoardMember::class);
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
            $this->photo = $photo->getUrl();
        }

        $this->save();
    }

    public function scopeWithPhotos($query)
    {
        return $query->withMedia([static::BOARD_PHOTO_TAG]);
    }
}
