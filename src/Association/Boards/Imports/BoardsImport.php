<?php

declare(strict_types=1);

namespace Francken\Association\Boards\Imports;

use Francken\Association\Boards\Board;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Plank\Mediable\MediaUploader;

final class BoardsImport implements ToCollection, WithHeadingRow
{
    private MediaUploader $uploader;

    public function __construct(MediaUploader $uploader)
    {
        $this->uploader = $uploader;
    }

    public function collection(Collection $collection) : void
    {
        $collection->each(function ($row) : void {
            $board = Board::forceCreate([
                'id' => $row['id'],
                'name' => $row['name'] ?? '',
                'photo_position' => $row['photo_position'] ?? '',
                'installed_at' => $row['installed_at'],
                'demissioned_at' => $row['demissioned_at'],
                'decharged_at' => $row['decharged_at'],
                'created_at' => $row['created_at'],
                'updated_at' => $row['updated_at'],
            ]);

            $this->uploadPhoto($board, $row['photo'] ?? null);
        });
    }

    private function uploadPhoto(Board $board, ?string $photo) : void
    {
        if ($photo === null || $photo === '') {
            return;
        }

        $directory = "images/boards/" . Str::slug($board->board_year->toString()) . "/";

        $media = $this->uploader->fromSource($photo)
            ->toDirectory($directory)
            ->useFilename(Str::slug($board->board_name->toString()))
            ->upload();

        $board->attachMedia($media, 'board_photo');
        $board->photo_media_id = (int) $media->id;
        $board->save();
    }
}
