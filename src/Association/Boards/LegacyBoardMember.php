<?php

declare(strict_types=1);

namespace Francken\Association\Boards;

use App;
use Francken\Association\LegacyMember;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

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
