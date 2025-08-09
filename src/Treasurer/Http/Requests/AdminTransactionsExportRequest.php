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
            'from' => ['required', 'date_format:Y-m-d H:i:s'],
            'until' => ['required', 'date_format:Y-m-d H:i:s'],
        ];
    }

    public function from() : DateTimeImmutable
    {
        return $this->toDateTimeImmutable($this->string('from')->toString());
    }

    public function until() : DateTimeImmutable
    {
        return $this->toDateTimeImmutable($this->string('until')->toString());
    }

    private function toDateTimeImmutable(string $input) : DateTimeImmutable
    {
        $dateTime = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $input);

        Assert::isInstanceOf($dateTime, DateTimeImmutable::class);

        return $dateTime;
    }
}
