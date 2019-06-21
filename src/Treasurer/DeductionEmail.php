<?php

declare(strict_types=1);

namespace Francken\Treasurer;

use DateTimeImmutable;
use Francken\Treasurer\Imports\ImportDeductions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Importer;
use Plank\Mediable\Media;
use Plank\Mediable\Mediable;

/**
 * We keep track of each deduction that has occured.
 * For each deduction there will be one or more members
 */
final class DeductionEmail extends Model
{
    use Mediable;

    protected $table = 'treasurer_deduction_emails';
    protected $fillable = [
        'deducted_at',
        'deduction_from',
        'deduction_to',
        'amount_of_members',
        'file_media_id',
        'was_verified',
    ];
    protected $dates = [
        'deducted_at',
        'deduction_from',
        'deduction_to',
        'emails_sent_at'
    ];

    public static function upload(
        Media $deduction,
        DateTimeImmutable $deducted_at,
        DateTimeImmutable $deduction_from,
        DateTimeImmutable $deduction_to,
        Importer $importer
    ) : self {
        $import = new ImportDeductions();
        $importer->import(
            $import,
            $deduction->getDiskPath(),
            $deduction->disk
        );

        // We don't have to verify the deduction if  conflicts were found
        $was_verified = $import->errors()
            ->reject(function (Collection $errors) {
                return $errors->isEmpty();
            })
            ->isEmpty();

        /** @var DeductionEmail */
        $deduction_email = static::create([
            'deducted_at' => $deducted_at,
            'deduction_from' => $deduction_from,
            'deduction_to' => $deduction_to,
            'amount_of_members' => $import->deductions()->count(),
            'file_media_id' => $deduction->id,
            'was_verified' => $was_verified,
        ]);

        $deduction_email->deductionToMembers()->createMany(
            $import->deductions()->map(function (Collection $deduction) {
                return [
                    'member_id' => $deduction['member']->id,
                    'description' => $deduction['omschrijving_2'],
                    'amount_in_cents' => str_replace(',', '', $deduction['bedrag']),
                    'contained_errors' => $deduction['errors']->isNotEmpty(),
                ];
            })->toArray()
        );

        return $deduction_email;
    }

    public function deductionFile()
    {
        return $this->belongsTo(Media::class, 'file_media_id');
    }

    public function deductionToMembers()
    {
        return $this->hasMany(DeductionEmailToMember::class);
    }
}
