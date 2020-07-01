<?php

declare(strict_types=1);

namespace Francken\Asssociation\Committees\Http\Requests;

use DateTimeImmutable;
use Illuminate\Foundation\Http\FormRequest;
use Webmozart\Assert\Assert;

final class AdminCommitteeMemberRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'member_id' => ['required', 'integer', 'exists:francken-legacy.leden,id'],
            'function' => ['nullable', 'min:1'],
            'installed_at' => ['required', 'date_format:Y-m-d'],
            'decharged_at' => ['nullalbe', 'date_format:Y-m-d'],
        ];
    }

    public function memberId() : int
    {
        return (int) $this->input('member_id');
    }

    public function function() : ?string
    {
        return $this->input('function');
    }

    public function installedAt() : DateTimeImmutable
    {
        $installedAt = DateTimeImmutable::createFromFormat(
            'Y-m-d',
            $this->input('installed_at')
        );

        Assert::isInstanceOf($installedAt, DateTimeImmutable::class);

        return $installedAt;
    }

    public function dechargedAt() : ?DateTimeImmutable
    {
        if ($this->input('decharged_at') === null) {
            return null;
        }

        $dechargedAt = DateTimeImmutable::createFromFormat(
            'Y-m-d',
            $this->input('sale_date')
        );

        Assert::isInstanceOf($dechargedAt, DateTimeImmutable::class);

        return $dechargedAt;
    }
}
