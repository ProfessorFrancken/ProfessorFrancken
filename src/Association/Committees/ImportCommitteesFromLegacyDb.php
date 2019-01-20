<?php

declare(strict_types=1);

namespace Francken\Association\Activities;

use Illuminate\Console\Command;

class ImportCommitteesFromLegacyDb extends Command
{
    /**
     * @var string
     */
    protected $signature = 'import:committees';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Import all committees and their members into our new system";

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

    }
}
