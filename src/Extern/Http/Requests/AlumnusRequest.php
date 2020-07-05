<?php

declare(strict_types=1);

namespace Francken\Extern\Http\Requests;

use DateTimeImmutable;
use Illuminate\Foundation\Http\FormRequest;
use Webmozart\Assert\Assert;

class AlumnusRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'member_id' => ['required', 'integer', 'exists:francken-legacy.leden,id'],
            'position' => ['nullable', 'regex:/[a-zA-Z0-9\s]+/', 'min:1'],
            'started_position_at' => ['nullable', 'date_format:Y-m-d', 'required_with:started_position_at'],
            'stopped_position_at' => ['nullable', 'date_format:Y-m-d', 'after:started_position_at'],
            'notes' => ['nullable', 'regex:/[a-zA-Z0-9\s]+/', 'min:1'],
        ];
    }

    public function memberId() : int
    {
        return (int)$this->input('member_id', '');
    }

    public function position() : string
    {
        return $this->input('position', '');
    }

    public function startedPositionAt() : ?DateTimeImmutable
    {
        if ($this->input('started_position_at') === null) {
            return null;
        }

        $datetime = DateTimeImmutable::createFromFormat(
            'Y-m-d',
            $this->input('started_position_at')
        );

        Assert::isInstanceOf($datetime, DateTimeImmutable::class);

        return $datetime;
    }

    public function stoppedPositionAt() : ?DateTimeImmutable
    {
        if ($this->input('stopped_position_at') === null) {
            return null;
        }

        $datetime = DateTimeImmutable::createFromFormat(
            'Y-m-d',
            $this->input('stopped_position_at')
        );

        Assert::isInstanceOf($datetime, DateTimeImmutable::class);

        return $datetime;
    }

    public function notes() : ?string
    {
        return $this->input('notes', '');
    }
}
