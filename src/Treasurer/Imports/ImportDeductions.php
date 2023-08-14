<?php

declare(strict_types=1);

namespace Francken\Treasurer\Imports;

use Francken\Association\LegacyMember;
use Francken\Treasurer\DeductionEmail;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Log;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

final class ImportDeductions implements ToCollection, WithHeadingRow, WithCustomCsvSettings
{
    private ?DeductionEmail $deduction = null;

    private Collection $deductions;

    private Collection $errors;

    public function __construct(?DeductionEmail $deduction = null)
    {
        $this->deduction = $deduction;
        $this->deductions = new Collection();
        $this->errors = new Collection();
    }

    public function collection(Collection $collection) : void
    {
        Validator::make($collection->toArray(), $this->rules())->validate();

        foreach ($collection as $deduction) {
            // Some old deduction files contain invalid data, so we will skip them
            if ($deduction['machtigingskenmerk'] === null) {
                continue;
            }

            $this->addDeduction($deduction);
        }

        // Sometimes the same member can occur twice or more in one deduction.
        // This may happen when a member had a deduction for both food & drinks and activities
        // In this case we will merge the deducitons into 1 deduction
        $this->deductions = $this->deductions->groupBy(fn ($deduction) : int => $deduction['member']->id)->map(function ($deductions, $memberId) {
            if ($deductions->count() > 1) {
                $description = $deductions->map(fn (Collection $deduction) : string => $deduction['omschrijving_2'])->implode(', ');

                $amount = $deductions->map(fn (Collection $deduction) : int => (int)(100 * $deduction['bedrag']))->sum();

                $errors = $deductions->map(fn (Collection $deduction) : Collection => $deduction['errors'])->reduce(fn (Collection $all, Collection $errors) : Collection => $all->merge($errors), new Collection());

                $deductions[0]['bedrag'] = $amount;
                $deductions[0]['errors'] = $errors;
                $deductions[0]['omschrijving_2'] = $description;
            } else {
                $deductions[0]['bedrag'] = (int)(100 * $deductions[0]['bedrag']);
            }

            return $deductions[0];
        });
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
            'delimiter' => ','
        ];
    }

    private function rules() : array
    {
        return [
            '*.machtigingskenmerk' => 'required',
            '*.omschrijving_2' => 'required',
            '*.bedrag' => 'required|numeric',
            '*.naam_betaler' => 'nullable|string',
            '*.adres_betaler' => 'nullable|string',
            '*.woonplaats_betaler' => 'nullable|string',
            '*.iban_rekeningnr' => 'nullable|string',
        ];
    }

    private function addDeduction(Collection $deduction) : void
    {
        $member = $this->getLegacyMember($deduction);
        if ($member === null) {
            return;
        }

        $deduction->put('member', $member);

        $deductionName = (string)($deduction["naam_betaler"] ?? '');
        $deductionAddress = (string)($deduction["adres_betaler"] ?? '');
        $deductionCity = (string)($deduction["woonplaats_betaler"] ?? '');
        $deductionIban = $deduction["iban_rekeningnr"];

        $checks = [
            "name" => "{$member->initialen} {$member->surname}" === $deductionName,
            "address" => (string)$member->adres === $deductionAddress || (string)$member->plaats === $deductionCity,
            "iban" => $this->checkIban($member->rekeningnummer, $deductionIban),
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

    private function getLegacyMember(Collection $deduction) : ?LegacyMember
    {
        if (preg_match('/\d+/', $deduction['machtigingskenmerk'], $matches)) {
            $possibleMemberId=(int)$matches[0];
        } else {
            $possibleMemberId=(int) Str::after($deduction['machtigingskenmerk'], 'ref.  ');
        }

        try {
            /** @var LegacyMember|null */
            return LegacyMember::findOrFail($possibleMemberId);
        } catch (ModelNotFoundException $e) {
            Log::error("Could not retrieve deduction information", $deduction->toArray());
            return null;
        }
    }


    private function checkIban(?string $member = '', ?string $deduction = '') : bool
    {
        if (is_null($member) || is_null($deduction)) {
            return false;
        }

        return str_replace(" ", "", $member) === str_replace(" ", "", $deduction);
    }
}
