<?php

declare(strict_types=1);

namespace Francken\Shared\Media;

use Francken\Shared\Media\Http\Controllers\MediaController;
use Illuminate\Filesystem\FilesystemManager;
use Illuminate\Support\Collection;

final class Directory
{
    /**
     * @var string
     */
    private const DISK = 'uploads';

    private string $directory;

    private string $name;

    public function __construct(string $directory, ?string $name = null)
    {
        $this->directory = $directory;

        $this->name = $name !== null
            ? $name
            : collect(explode('/', $this->directory))->pop();
    }

    public function directory() : string
    {
        return $this->directory;
    }

    public function name() : string
    {
        return $this->name;
    }

    public function url() : string
    {
        return action(
            [MediaController::class, 'index'],
            $this->directory
        );
    }

    public static function childDirectories(
        FilesystemManager $storage,
        string $directory
    ) : Collection {
        $directories = collect($storage->disk(static::DISK)->directories($directory))
            ->map(fn ($directory) : self => new self($directory));

        if ($directory !== '') {
            $directories->prepend(new self(dirname($directory), '..'));
        }

        return $directories;
    }
}
