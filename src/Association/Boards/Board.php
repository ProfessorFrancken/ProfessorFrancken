<?php

declare(strict_types=1);

namespace Francken\Association\Boards;

use Carbon\Carbon;
use DateTimeImmutable;
use Francken\Association\Committees\Committee;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Plank\Mediable\Media;
use Plank\Mediable\Mediable;
use Webmozart\Assert\Assert;

final class Board extends Model
{
    use Mediable;
    use Notifiable;

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
    protected $casts = [
        'installed_at' => 'datetime',
        'demissioned_at' => 'datetime',
        'decharged_at' => 'datetime',
    ];

    /**
     * Install a new Board
     */
    public static function install(
        BoardName $name,
        ?Media $photo,
        string $photoPosition,
        DateTimeImmutable $installedAt,
        Collection $members
    ) : self {
        Assert::oneOf($photoPosition, [
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
            'photo_position' => $photoPosition,
            'installed_at' => $installedAt,
            'board_year_slug' => BoardYear::fromInstallDate($installedAt)->toSlug(),
            'photo_media_id' => $photo->id ?? null,
        ]);

        if ($photo !== null) {
            $board->attachMedia($photo, static::BOARD_PHOTO_TAG);
        }

        $members->each(function ($member) use ($board, $installedAt) : void {
            BoardMember::install(
                $board,
                $member['member_id'],
                $member['title'],
                $installedAt,
                $member['photo']
            );
        });

        event(new BoardWasInstalled($board->id));

        return $board;
    }

    public function members() : HasMany
    {
        // Order the BoardMembers by id so that their position on the boards page is shown correctly
        return $this->hasMany(BoardMember::class)
                    ->orderByDesc('id');
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

    public function updateBoardAttributes(
        BoardName $name,
        string $photoPosition,
        DateTimeImmutable $installedAt,
        ?DateTimeImmutable $demissionedAt,
        ?DateTimeImmutable $dechargedAt,
        ?Media $photo
    ) : void {
        $this->name = $name->toString();
        $this->photo_position = $photoPosition;
        $this->installed_at = Carbon::createFromImmutable($installedAt);
        $this->demissioned_at = $demissionedAt;
        $this->decharged_at = $dechargedAt;

        if ($photo !== null) {
            $this->syncMedia($photo, static::BOARD_PHOTO_TAG);
            $this->photo_media_id = (int) $photo->id;
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

    /**
     * This getter is used indirectly by the RoutesNotifications trait
     */
    public function getEmailAttribute() : string
    {
        return 'board@professorfrancken.nl';
    }
}
