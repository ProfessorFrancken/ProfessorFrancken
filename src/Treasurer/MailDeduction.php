<?php

declare(strict_types=1);

namespace Francken\Treasurer;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * Francken\Treasurer\MailDeduction
 *
 * @property int $id
 * @property int|null $aantalleden
 * @property string|null $bestand
 * @property Carbon|null $datum
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
    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var string
     */
    protected $table = 'afschrijvingen_mail';

    /**
     * @var string
     */
    protected $connection = 'francken-legacy';

    /**
     * @var string[]
     */
    protected $dates = ['datum'];

    /**
     * @var string[]
     */
    protected $fillable = [
        'id', 'aantal_leden', 'bestand', 'datum'
    ];

    public function deduction() : Deduction
    {
        /** @var Deduction */
        $deduction = Deduction::orderBy('tijd', 'desc')
            ->where('tijd', '<', $this->datum)
            ->firstOrFail();

        return $deduction;
    }

    public function previousDeduction() : Deduction
    {
        /** @var Deduction */
        $deduction = self::orderBy('datum', 'desc')
            ->where('datum', '<', $this->datum)
            ->firstOrFail();

        return $deduction;
    }
}
