<?php

declare(strict_types=1);

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Francken\Association\Borrelcie\BorrelcieAccount;
use Francken\Association\LegacyMember;

$factory->define(BorrelcieAccount::class, function () {
    return [
        'member_id' => factory(LegacyMember::class),
    ];
});
