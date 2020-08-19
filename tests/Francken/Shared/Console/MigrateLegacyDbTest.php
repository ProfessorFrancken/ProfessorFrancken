<?php

declare(strict_types=1);

namespace Francken\Tests\Shared\Console;

use Francken\Features\TestCase;
use Schema;

class MigrateLegacyDbTest extends TestCase
{
    /** @test */
    public function it_handles_legacy_migrations() : void
    {
        \Artisan::call('migrate:legacy-db');

        $this->assertTrue(
            Schema::connection('francken-legacy')->hasTable('leden')
        );
    }
}
