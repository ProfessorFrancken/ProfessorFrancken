<?php

declare(strict_types=1);

namespace Francken\Extern;

use Illuminate\Database\Eloquent\Model;

final class Sector extends Model
{
    /**
     * @var string
     */
    protected $table = 'extern_partner_sectors';
}
