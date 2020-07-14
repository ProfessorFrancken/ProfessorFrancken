<?php

declare(strict_types=1);

namespace Francken\Extern\Http\Requests;

use DateTimeImmutable;
use Francken\Extern\PartnerStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Webmozart\Assert\Assert;

class PartnerRequest extends FormRequest
{
    /**
     * @var int
     */
    private const MAX_FILE_SIZE = 10 * 1024;

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules() : array
    {
        return [
            'name' => ['required', 'min:1', ],
            'sector_id' => ['required',  'exists:extern_partner_sectors,id'],
            'status' => ['required', Rule::in(
                array_keys(PartnerStatus::all())
            )],
            'homepage_url' => ['required', 'url'],
            'referral_url' => ['nullable', 'url'],
            'logo' => ['image', 'max:' . self::MAX_FILE_SIZE],
            'last_contract_ends_at' => ['nullable', 'date_format:Y-m-d']
        ];
    }

    public function name() : string
    {
        return $this->input('name', '');
    }

    public function slug() : string
    {
        return Str::slug($this->name());
    }

    public function sectorId() : int
    {
        return (int)$this->input('sector_id', '');
    }

    public function status() : string
    {
        return $this->input('status', '');
    }

    public function homepageUrl() : string
    {
        return $this->input('homepage_url', '');
    }

    public function referralUrl() : ?string
    {
        return $this->input('referral_url');
    }

    public function lastContractEndsAt() : ?DateTimeImmutable
    {
        if ($this->input('last_contract_ends_at') === null) {
            return null;
        }

        $lastContractEndsAt = DateTimeImmutable::createFromFormat(
            'Y-m-d',
            $this->input('last_contract_ends_at')
        );

        Assert::isInstanceOf($lastContractEndsAt, DateTimeImmutable::class);

        return $lastContractEndsAt;
    }
}
