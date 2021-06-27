<?php

declare(strict_types=1);

namespace Francken\Treasurer\Http\Requests;

use DateTimeImmutable;
use Francken\Association\LegacyMember;
use Illuminate\Foundation\Http\FormRequest;

class AdminSearchTransactionsRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules() : array
    {
        return [
            'member_id' => ['nullable', 'integer', 'exists:francken-legacy.leden,id'],
            'product_id' => ['nullable', 'integer', 'exists:francken-legacy.producten,id'],

            'from' => ['nullable', 'date_format:Y-m-d'],
            'until' => ['nullable', 'date_format:Y-m-d'],
        ];
    }

    public function memberId() : ?int
    {
        if ($this->input('member_id') === null) {
            return null;
        }

        $memberId = (int)$this->input('member_id', '');

        return $memberId === 0 ? null : $memberId;
    }

    public function member() : ?LegacyMember
    {
        return $this->memberId() !== null
            ? LegacyMember::find($this->memberId())
            : null;
    }

    public function productId() : ?int
    {
        if ($this->input('product_id') === null) {
            return null;
        }

        return (int)$this->input('product_id', '');
    }

    public function from() : ?DateTimeImmutable
    {
        return $this->toDateTimeImmutable($this->input('from'));
    }

    public function until() : ?DateTimeImmutable
    {
        return $this->toDateTimeImmutable($this->input('until'));
    }

    private function toDateTimeImmutable(?string $input) : ?DateTimeImmutable
    {
        if ($input === null) {
            return null;
        }

        $dateTime = DateTimeImmutable::createFromFormat('Y-m-d', $input);

        if ($dateTime === false) {
            return null;
        }

        return $dateTime;
    }

    public function searchQueryKeys(string $select) : array
    {
        return [
            'select' => $select
        ];
    }
}
