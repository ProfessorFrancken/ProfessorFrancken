<?php

declare(strict_types=1);

namespace Francken\Association\Boards\Imports;

use Francken\Association\Boards\BoardMember;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Plank\Mediable\MediaUploader;

final class BoardMembersImport implements ToCollection, WithHeadingRow
{
    private MediaUploader $uploader;

    public function __construct(MediaUploader $uploader)
    {
        $this->uploader = $uploader;
    }

    public function collection(Collection $collection) : void
    {
        $collection->each(function ($row) : void {
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
            $this->uploadPhoto($member, $row['photo'] ?? null);
        });
    }

    private function uploadPhoto(BoardMember $member, ?string $photo) : void
    {
        if ($photo === null || $photo === "" || $member->board === null) {
            return;
        }

        $board = $member->board;
        $directory = "images/boards/" . Str::slug($board->board_year->toString()) . "/";

        $media = $this->uploader->fromSource($photo)
            ->toDirectory($directory)
            ->useFilename(Str::slug($board->board_name->toString()))
            ->upload();

        $member->attachMedia($media, 'board_member_photo');
        $member->photo_media_id = (int) $media->id;
        $member->save();
    }
}
