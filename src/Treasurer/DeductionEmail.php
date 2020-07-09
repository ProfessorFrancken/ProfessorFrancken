<?php

declare(strict_types=1);

namespace Francken\Treasurer;

use DateTimeImmutable;
use Francken\Treasurer\Imports\ImportDeductions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Importer;
use Plank\Mediable\Media;
use Plank\Mediable\Mediable;

/**
 * We keep track of each deduction that has occured.
 *
 * For each deduction there will be one or more members
 *
 * @property int $id
 * @property int $amount_of_members
 * @property \Illuminate\Support\Carbon $deduction_from
 * @property \Illuminate\Support\Carbon $deduction_to
 * @property \Illuminate\Support\Carbon $deducted_at
 * @property \Illuminate\Support\Carbon|null $emails_sent_at
 * @property bool $was_verified
 * @property int $file_media_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Media $deductionFile
 * @property-read \Illuminate\Database\Eloquent\Collection|DeductionEmailToMember[] $deductionToMembers
 * @property-read int|null $deduction_to_members_count
 * @property-read mixed $total_amount
 * @property-read \Illuminate\Database\Eloquent\Collection|Media[] $media
 * @property-read int|null $media_count
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Treasurer\DeductionEmail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Treasurer\DeductionEmail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Treasurer\DeductionEmail query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Treasurer\DeductionEmail whereAmountOfMembers($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Treasurer\DeductionEmail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Treasurer\DeductionEmail whereDeductedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Treasurer\DeductionEmail whereDeductionFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Treasurer\DeductionEmail whereDeductionTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Treasurer\DeductionEmail whereEmailsSentAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Treasurer\DeductionEmail whereFileMediaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Treasurer\DeductionEmail whereHasMedia($tags, $matchAll = false)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Treasurer\DeductionEmail whereHasMediaMatchAll($tags)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Treasurer\DeductionEmail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Treasurer\DeductionEmail whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Treasurer\DeductionEmail whereWasVerified($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Treasurer\DeductionEmail withMedia($tags = [], $matchAll = false)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Treasurer\DeductionEmail withMediaMatchAll($tags = [])
 * @mixin \Eloquent
 * @method static \Plank\Mediable\MediableCollection|static[] all($columns = ['*'])
 * @method static \Plank\Mediable\MediableCollection|static[] get($columns = ['*'])
 */
final class DeductionEmail extends Model
{
    use Mediable;

    /**
     * @var string
     */
    protected $table = 'treasurer_deduction_emails';

    /**
     * @var string[]
     */
    protected $fillable = [
        'deducted_at',
        'deduction_from',
        'deduction_to',
        'amount_of_members',
        'file_media_id',
        'was_verified',
    ];

    /**
     * @var string[]
     */
    protected $dates = [
        'deducted_at',
        'deduction_from',
        'deduction_to',
        'emails_sent_at'
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'was_verified' => 'boolean',
    ];

    public static function upload(
        Media $deduction,
        DateTimeImmutable $deductedAt,
        DateTimeImmutable $deductionFrom,
        DateTimeImmutable $deductionTo,
        Importer $importer
    ) : self {
        $import = new ImportDeductions();
        $importer->import(
            $import,
            $deduction->getDiskPath(),
            $deduction->disk
        );

        // We don't have to verify the deduction if  conflicts were found
        $wasVerified = $import->errors()
            ->reject(function (Collection $errors) : bool {
                return $errors->isEmpty();
            })
            ->isEmpty();

        /** @var DeductionEmail */
        $deductionEmail = static::create([
            'deducted_at' => $deductedAt,
            'deduction_from' => $deductionFrom,
            'deduction_to' => $deductionTo,
            'amount_of_members' => $import->deductions()->count(),
            'file_media_id' => $deduction->id,
            'was_verified' => $wasVerified,
        ]);

        $deductionEmail->deductionToMembers()->createMany(
            $import->deductions()->map(function (Collection $deduction) : array {
                return [
                    'member_id' => $deduction['member']->id,
                    'description' => $deduction['omschrijving_2'],
                    'amount_in_cents' => $deduction['bedrag'],
                    'contained_errors' => $deduction['errors']->isNotEmpty(),
                ];
            })->toArray()
        );

        return $deductionEmail;
    }

    public function deductionFile() : BelongsTo
    {
        return $this->belongsTo(Media::class, 'file_media_id');
    }

    public function deductionToMembers() : HasMany
    {
        return $this->hasMany(DeductionEmailToMember::class);
    }

    public function getTotalAmountAttribute() : float
    {
        return $this->deductionToMembers->map(function (DeductionEmailToMember $member) : int {
            return $member->amount_in_cents;
        })->sum() / 100;
    }
}
