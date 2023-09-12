<?php

declare(strict_types=1);

return [
    'google-analytics' => env('GOOGLE_ANALYTICS', false),

    'admin_passphrase' => env('ADMIN_PASSPHRASE', 'Bitterballen dibs machine'),

    'photos_hash' => env('PHOTOS_HASH', 'Bitterballen photo machine'),

    'nextcloud_host' => env('NEXTCLOUD_HOST', 'https://nextcloud.francken.nl.localhost'),
];
