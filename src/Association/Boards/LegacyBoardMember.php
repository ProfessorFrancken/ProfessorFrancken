<?php

declare(strict_types=1);

namespace Francken\Association\Boards;

use App;
use Francken\Association\LegacyMember;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Francken\Association\Boards\LegacyBoardMember
 *
 * @property int $id
 * @property int $lid_id
 * @property int $commissie_id
 * @property int $jaar
 * @property string $functie
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property-read mixed $full_name
 * @property-read \Francken\Association\LegacyMember $member
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Boards\LegacyBoardMember newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Boards\LegacyBoardMember newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Boards\LegacyBoardMember query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Boards\LegacyBoardMember whereCommissieId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Boards\LegacyBoardMember whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Boards\LegacyBoardMember whereFunctie($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Boards\LegacyBoardMember whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Boards\LegacyBoardMember whereJaar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Boards\LegacyBoardMember whereLidId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Boards\LegacyBoardMember whereUpdatedAt($value)
 * @mixin \Eloquent
 */
final class LegacyBoardMember extends Model
{
    public const LEGACY_BOARD_COMMITTEE_ID = 14;
    protected $table = 'commissie_lid';
    protected $connection = 'francken-legacy';

    public function getFullNameAttribute()
    {
        return $this->member->full_name;
    }

    public function member()
    {
        return $this->belongsTo(LegacyMember::class, 'lid_id');
    }

    public static function createFromBoardMember(BoardMember $member) : void
    {
        if ($member->member_id === null) {
            return;
        }

        self::create([
            'lid_id' => 1760,
            'commissie_id' => self::LEGACY_BOARD_COMMITTEE_ID,
            'jaar' => $member->installed_at->format('Y'),
            'functie' => $member->title,
        ]);
    }

    protected static function boot() : void
    {
        parent::boot();

        $dispatcher = App::make(Dispatcher::class);
        $dispatcher->listen(
            BoardWasInstalled::class,
            function (BoardWasInstalled $event) : void {
                $board = Board::find($event->boardId());
                $board->members->each(function (BoardMember $member) : void {
                    self::createFromBoardMember($member);
                });
            });

        static::addGlobalScope('board', function (Builder $builder) : void {
            $builder->where('commissie_id', '=', self::LEGACY_BOARD_COMMITTEE_ID);
        });
    }
}
