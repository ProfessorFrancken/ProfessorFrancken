<?php

declare(strict_types=1);

namespace Francken\Treasurer\Http\Requests;

use DateTimeImmutable;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;
use InvalidArgumentException;

class DeductionRequest extends FormRequest
{
    public function deductedAt() : DateTimeImmutable
    {
        return $this->toDateTimeImmutable($this->input('deducted_at'));
    }
    public function deductionFrom() : DateTimeImmutable
    {
        return $this->toDateTimeImmutable($this->input('deduction_from'));
    }
    public function deductionTo() : DateTimeImmutable
    {
        return $this->toDateTimeImmutable($this->input('deduction_to'));
    }

    public function deduction() : UploadedFile
    {
        return $this->file('deduction');
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'deducted_at' => ['required', 'date_format:Y-m-d', 'after:deduction_to'],
            'deduction_from' => ['required', 'date_format:Y-m-d', 'before:deduction_to', 'before:deducted_at'],
            'deduction_to' => ['required', 'date_format:Y-m-d', 'after:deduction_from', 'before:deducted_at'],
            'deduction' => ['required', 'file'],
        ];
    }

    private function toDateTimeImmutable(string $input) : DateTimeImmutable
    {
        $date_time = DateTimeImmutable::createFromFormat('Y-m-d', $input);

        if ($date_time === null) {
            throw new InvalidArgumentException();
        }

        return $date_time;
    }
}
