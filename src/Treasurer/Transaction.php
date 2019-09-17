<?php

declare(strict_types=1);

namespace Francken\Treasurer;

use Illuminate\Database\Eloquent\Model;

final class Transaction extends Model
{
    public $timestamps = true;
    protected $table = 'transacties';
    protected $connection = 'francken-legacy';
    protected $dates = ['tijd'];
    protected $fillable = [
        "id",
        "lid_id",
        "product_id",
        "aantal",
        "prijs",
        "totaalprijs",
        "tijd",
    ];
}
