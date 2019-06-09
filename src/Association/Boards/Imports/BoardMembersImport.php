<?php

declare(strict_types=1);

namespace Francken\Association\Boards\Imports;

use Francken\Association\Boards\BoardMember;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Plank\Mediable\MediaUploader;

final class BoardMembersImport implements ToCollection, WithHeadingRow
{
    /**
     * @var MediaUploader
     */
    private $uploader;

    public function __construct(MediaUploader $uploader)
    {
        $this->uploader = $uploader;
    }

    public function collection(Collection $rows) : void
    {
        $rows->each(function ($row) : void {
            $member = BoardMember::forceCreate([
                'id' => $row['id'],
                'board_id' => $row['board_id'],
                'member_id' => $row['member_id'],
                'name' => $row['name'] ?? '',
                'title' => $row['title'],
                'board_member_status' => $row['board_member_status'],
                'installed_at' => $row['installed_at'],
                'demissioned_at' => $row['demissioned_at'],
                'decharged_at' => $row['decharged_at'],
                'created_at' => $row['created_at'],
                'updated_at' => $row['updated_at'],
            ]);
            $this->uploadPhoto($member, $row['photo']);
        });
    }

    private function uploadPhoto(BoardMember $member, ?string $photo) : void
    {
        if ($photo === null || $photo === "") {
            return;
        }

        $board = $member->board;
        $directory = "images/boards/" . str_slug($board->board_year->toString()) . "/";

        $media = $this->uploader->fromSource($photo)
            ->toDirectory($directory)
            ->useFilename(str_slug($board->board_name->toString()))
            ->upload();

        $member->attachMedia($media, 'board_member_photo');
    }
}
