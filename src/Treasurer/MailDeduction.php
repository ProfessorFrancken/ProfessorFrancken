<?php

declare(strict_types=1);

namespace Francken\Treasurer;

use Illuminate\Database\Eloquent\Model;

/**
 * Francken\Treasurer\MailDeduction
 *
 * @property int $id
 * @property int|null $aantalleden
 * @property string|null $bestand
 * @property \Illuminate\Support\Carbon|null $datum
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Treasurer\MailDeduction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Treasurer\MailDeduction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Treasurer\MailDeduction query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Treasurer\MailDeduction whereAantalleden($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Treasurer\MailDeduction whereBestand($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Treasurer\MailDeduction whereDatum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Treasurer\MailDeduction whereId($value)
 * @mixin \Eloquent
 */
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
