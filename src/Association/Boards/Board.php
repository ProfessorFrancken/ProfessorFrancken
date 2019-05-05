<?php

declare(strict_types=1);

namespace Francken\Association\Boards;

use DateTimeImmutable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Webmozart\Assert\Assert;

final class Board extends Model
{
    protected $table = 'association_boards';
    protected $fillable = [
        'name',
        'photo',
        'photo_position',

        'installed_at',
        'demisioned_at',
        'decharged_at',
    ];

    public static function install(
        string $name,
        string $photo,
        string $photo_position,
        DateTimeImmutable $install_date,
        Collection $members
    ) : self {
        Assert::oneOf($photo_position, [
            '', 'NorthWest', 'North', 'NorthEast', 'West', 'Center', 'East', 'SouthWest', 'South', 'SouthEast'
        ]);
        $members->each(function (array $member) : void {
            Assert::keyExists($member, 'member_id');
            Assert::keyExists($member, 'title');
            Assert::keyExists($member, 'photo');
            Assert::keyExists($member, 'install_date');
        });

        $board = self::create([
            'name' => $name,
            'photo' => $photo,
            'photo_position' => $photo_position,
            'install_date' => $install_date
        ]);
        $members->each(function ($member) use ($board) : void {
            $board->installMember(
                $member['member_id'],
                $member['title'],
                $member['photo'],
                $member['installed_at']
            );
        });

        event(new BoardwasInstalled($board->id));

        return $board;
    }

    public function installMember(
        ?int $member_id,
        string $title,
        string $photo,
        DateTimeImmutable $install_date
    ) : BoardMember {
        $member = new BoardMember([
            'member_id' => $member_id,
            'title' => $title,
            'photo' => $photo,
            'install_date' => $install_date
        ]);

        $this->members()->create($member);

        return $member;
    }

    public function members()
    {
        return $this->hasMany(BoardMember::class);
    }
}
