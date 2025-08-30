<?php

declare(strict_types=1);

namespace Francken\Treasurer\Http\Requests;

use DateTimeImmutable;
use Illuminate\Foundation\Http\FormRequest;
use Webmozart\Assert\Assert;

final class AdminTransactionsExportRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules() : array
    {
        return [
            'from' => ['nullable', 'date_format:Y-m-d H:i:s'],
            'until' => ['nullable', 'date_format:Y-m-d H:i:s'],
        ];
    }

    public function from() : ?DateTimeImmutable
    {
        return $this->toDateTimeImmutable($this->input('from'));
    }

    public function until() : ?DateTimeImmutable
    {
        return $this->toDateTimeImmutable($this->input('until'));
    }

    private function toDateTimeImmutable(string $input) : DateTimeImmutable
    {
        $dateTime = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $input);

        Assert::isInstanceOf($dateTime, DateTimeImmutable::class);

        return $dateTime;
    }
}
