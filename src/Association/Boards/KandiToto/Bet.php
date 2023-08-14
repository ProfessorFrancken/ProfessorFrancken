<?php

declare(strict_types=1);

namespace Francken\Association\Boards\KandiToto;

use Francken\Association\Boards\BoardMember;
use Francken\Association\Boards\BoardYear;
use Francken\Association\LegacyMember;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Webmozart\Assert\Assert;

final class Bet extends Model
{
    protected $fillable = [
        'member_id',
        'board_year',
        'president',
        'secretary',
        'treasurer',
        'intern',
        'extern',
        'wildcard'
    ];

    /**
     * @var string
     */
    protected $table = 'board_kandi_toto_bets';

    public static function submit(BoardMember $member, BoardYear $year, array $positions) : self
    {
        Assert::keyExists($positions, 'president');
        Assert::keyExists($positions, 'secretary');
        Assert::keyExists($positions, 'treasurer');
        Assert::keyExists($positions, 'intern');
        Assert::keyExists($positions, 'extern');
        Assert::keyExists($positions, 'wildcard');

        /** @var Bet */
        return self::create([
            'member_id' => $member->member_id,
            'board_year' => $year->start()->format('Y'),
            'president' => $positions['president'],
            'secretary' => $positions['secretary'],
            'treasurer' => $positions['treasurer'],
            'intern' => $positions['intern'],
            'extern' => $positions['extern'],
            'wildcard' => $positions['wildcard'],
        ]);
    }

    public function scopeBoardYear(Builder $query, BoardYear $year) : Builder
    {
        return $query->where('board_year', $year->start()->format('Y'));
    }

    public function boardMember() : BelongsTo
    {
        return $this->belongsTo(LegacyMember::class, 'member_id');
    }
}
