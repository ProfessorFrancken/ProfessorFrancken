<?php

declare(strict_types=1);

namespace Francken\Treasurer;

use DateTimeImmutable;
use Exception;
use Illuminate\Console\Command;
use League\Period\Period;
use Maatwebsite\Excel\Importer;
use Plank\Mediable\Media;
use Plank\Mediable\MediaUploader;

final class ImportOldDeductions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'deductions:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate the old deductions table to new email deductions table';

    private Importer $importer;

    private MediaUploader $uploader;

    public function __construct(Importer $importer, MediaUploader $uploader)
    {
        $this->importer = $importer;
        $this->uploader = $uploader;

        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle() : void
    {
        MailDeduction::all()->each(function (MailDeduction $mailDeduction) : void {

            /** @var Deduction */
            $deduction = $mailDeduction->deduction();

            /** @var Period */
            $deductionPeriod = $deduction->period;

            try {
                $file = storage_path('app/deductions/' . $mailDeduction->bestand);

                /** @var Media */
                $deductionFile = $this->uploader->fromSource($file)
                    ->setAllowUnrecognizedTypes(true)
                    ->toDestination('local', 'deductions')
                    ->useHashForFilename()
                    ->upload();

                $deduction = DeductionEmail::upload(
                    $deductionFile,
                    new DateTimeImmutable($mailDeduction->datum->format("Y-m-d")),
                    $deductionPeriod->getStartDate(),
                    $deductionPeriod->getEndDate(),
                    $this->importer
                );

                $deduction->was_verified = true;
                $deduction->emails_sent_at = new DateTimeImmutable($mailDeduction->datum->format("Y-m-d"));
                $deduction->save();
            } catch (Exception $e) {
                dump($e);
            }
        });
    }
}
