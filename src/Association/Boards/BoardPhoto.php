<?php

declare(strict_types=1);

namespace Francken\Association\Boards;

final class BoardPhoto
{
    public const DIRECTORY = 'images/boards/';

    private $photo;

    public static function fromRequest(
        ?UploadedPhoto $photo,
        BoardYear $board_year,
        string $board_name
    ) : BoardPhoto {
        $board_photo = new BoardPhoto;
        $board_photo->photo = $photo;
        $board_photo->board_year = $board_year;
        $board_photo->board_name = $board_name;
        return $board_photo;
    }
}
