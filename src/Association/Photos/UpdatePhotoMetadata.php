<?php

declare(strict_types=1);

namespace Francken\Association\Photos;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

final class UpdatePhotoMetadata extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'photos:update-metadata';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Updates all photos that don't a taken at date, width or height with values from the file's exif metadata";

    private GetImageMetadata $getImageMetadata;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(GetImageMetadata $getImageMetadata)
    {
        // We will need to have a database connection
        // and flikr api

        parent::__construct();

        $this->getImageMetadata = $getImageMetadata;
    }

    /**
     * Execute the console command.
     */
    public function handle() : void
    {
        $storagePath  = config('filesystems.disks.nextcloud.root');

        Photo::query()
                ->where('taken_at', '=', null)
                ->orWhere('width', '=', null)
                ->orWhere('height', '=', null)
                ->chunk(100, function ($photos) use ($storagePath) : void {
                    $photos->each(function (Photo $photo) use ($storagePath) : void {
                        dump($photo->toArray());
                        try {
                            $metadata = $this->getImageMetadata->metadata($storagePath . '/images' . $photo->path);
                            $photo->width = $metadata->width;
                            $photo->height = $metadata->height;


                            if ($metadata->creationDate !== null) {
                                $photo->taken_at = Carbon::createFromImmutable($metadata->creationDate);
                            }
                            $photo->save();
                        } catch (\Throwable $e) {
                            // ignore
                        }
                    });
                });
    }
}
