<?php

declare(strict_types=1);

namespace Francken\Treasurer;

use Illuminate\Database\Eloquent\Model;

final class MailDeduction extends Model
{
    public $timestamps = false;
    protected $table = 'afschrijvingen_mail';
    protected $connection = 'francken-legacy';
    protected $dates = ['datum'];
    protected $fillable = [
        'id', 'aantal_leden', 'bestand', 'datum'
    ];

    public function deduction() : Deduction
    {
        return Deduction::orderBy('tijd', 'desc')
            ->where('tijd', '<', $this->datum)
            ->firstOrFail();
    }

    public function previousDeduction() : self
    {
        return self::orderBy('datum', 'desc')
            ->where('datum', '<', $this->datum)
            ->firstOrFail();
    }
}
