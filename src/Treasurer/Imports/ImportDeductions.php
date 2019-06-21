<?php

declare(strict_types=1);

namespace Francken\Treasurer\Imports;

use Francken\Treasurer\DeductionEmail;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

final class ImportDeductions implements ToCollection, WithHeadingRow, WithCustomCsvSettings
{
    private $deduction;
    private $deductions;
    private $errors;

    public function __construct(?DeductionEmail $deduction = null)
    {
        $this->deduction = $deduction;
        $this->deductions = new Collection();
        $this->errors = new Collection();
    }

    public function collection(Collection $rows) : void
    {
        foreach ($rows as $deduction) {
            $this->addDeduction($deduction);
        }
    }

    public function deductions() : Collection
    {
        return $this->deductions;
    }

    public function errors() : Collection
    {
        return $this->errors;
    }

    public function getCsvSettings() : array
    {
        return [
            'input_encoding' => 'ISO-8859-1',
            'delimiter' => ';'
        ];
    }

    private function addDeduction(Collection $deduction) : void
    {
        $possible_member_id = (int) str_after($deduction['machtigingskenmerk'], 'ref.  ');
        $member = \Francken\Association\LegacyMember::findOrFail($possible_member_id);
        $deduction->put('member', $member);

        $checks = [
            "name" => "{$member->initialen} {$member->surname}" === (string)$deduction["naam_betaler"],
            "address" => (string)$member->adres === (string)$deduction["adres_betaler"] ||
            (string)$member->plaats === (string)$deduction["woonplaats_betaler"],
            "iban" => $this->checkIban($member->rekeningnummer, $deduction["iban_rekeningnr"]),
        ];

        $errors = collect();
        foreach ($checks as $what => $check) {
            if ( ! $check) {
                $errors->push($what);
            }
        }

        $deduction->put('errors', $errors);

        $this->errors->put($member->id, $errors);
        $this->deductions->push($deduction);
    }


    private function checkIban(string $member, string $deduction) : bool
    {
        return str_replace(" ", "", $member) === str_replace(" ", "", $deduction);
    }
    // TODO before import remove old DeductionEmailMembers for this deduction, if given
    // in constructor
}
