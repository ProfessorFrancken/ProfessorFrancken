<?php

declare(strict_types=1);

namespace Francken\Association\Boards\Http\Requests;

use DateTimeImmutable;
use Francken\Association\Boards\BoardName;
use Francken\Association\Boards\BoardYear;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Collection;
use InvalidArgumentException;

class BoardRequest extends FormRequest
{
    private ?BoardYear $board_year = null;

    private ?BoardName $board_name = null;

    public function installedAt() : DateTimeImmutable
    {
        $installedAt =  $this->toDateTimeImmutable(
            $this->input('installed_at')
        );

        if ($installedAt === null) {
            throw new InvalidArgumentException();
        }

        return $installedAt;
    }

    public function demissionedAt() : ?DateTimeImmutable
    {
        return $this->toDateTimeImmutable($this->input('demissioned_at'));
    }

    public function dechargedAt() : ?DateTimeImmutable
    {
        return $this->toDateTimeImmutable($this->input('decharged_at'));
    }

    public function members() : Collection
    {
        return collect($this->members)
            ->reject(fn (array $member) : bool => $member['member_id'] === null)
            ->map(function (array $member) : array {
                if (isset($member['installed_at'])) {
                    $member['installed_at'] = $this->toDateTimeImmutable($member['installed_at']);
                }

                if (isset($member['demissioned_at'])) {
                    $member['demissioned_at'] = $this->toDateTimeImmutable($member['demissioned_at']);
                }

                if (isset($member['decharged_at'])) {
                    $member['decharged_at'] = $this->toDateTimeImmutable($member['decharged_at']);
                }

                return $member;
            });
    }

    public function boardYear() : BoardYear
    {
        if ($this->board_year === null) {
            $this->board_year = BoardYear::fromInstallDate($this->installedAt());
        }

        return $this->board_year;
    }

    public function boardName() : BoardName
    {
        if ($this->board_name === null) {
            $this->board_name = BoardName::fromNameOrYear($this->name, $this->boardYear());
        }

        return $this->board_name;
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return true
     */
    public function authorize() : bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules() : array
    {
        $maxFileSize = 10 * 1024;
        return [
            'name' => ['required', 'regex:/[a-zA-Z0-9\s]+/', ],
            'installed_at' => ['required', 'date_format:Y-m-d'],
            'demissioned_at' => ['nullable', 'date_format:Y-m-d', 'after:installed_at', 'before_or_equal:decharged_at'],
            'decharged_at' => ['nullable', 'date_format:Y-m-d', 'after:installed_at', 'after_or_equal:demissioned_at'],
            'photo_position' => ['required', 'integer'],
            'photo' => ['image', 'max:' . $maxFileSize],

            // We only want to validate member input if the member_id is present
            'members.*.member_id' => ['sometimes', 'nullable', 'integer'],
            'members.*.title' => ['required_with:members.*.member_id'],
            'members.*.photo' => ['image', 'max:' . $maxFileSize],

            'members.*.installed_at' => ['sometimes', 'nullable', 'date_format:Y-m-d'],
            'members.*.demissioned_at' => ['sometimes', 'nullable', 'date_format:Y-m-d', 'after:members.*.installed_at', 'before_or_equal:members.*.decharged_at'],
            'members.*.decharged_at' => ['sometimes', 'nullable', 'date_format:Y-m-d', 'after:members.*.installed_at', 'after_or_equal:members.*.demissioned_at'],
            //
        ];
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
}
