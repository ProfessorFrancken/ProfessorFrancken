<?php

declare(strict_types=1);

namespace Francken\Association\Symposium\Http\Requests;

use DateTimeImmutable;
use Illuminate\Foundation\Http\FormRequest;
use Webmozart\Assert\Assert;

class SymposiumRequest extends FormRequest
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
            'location' => ['string'],
            'website_url' => ['required', 'url'],
            'logo' => ['nullable', 'image', 'file', 'max:' . self::MAX_FILE_SIZE],
            'start_date' => ['date_format:Y-m-d H:i'],
            'end_date' => ['date_format:Y-m-d H:i'],
            'promote_on_agenda' => ['nullable', 'boolean'],
            'open_for_registration' => ['nullable', 'boolean'],
        ];
    }

    public function name() : string
    {
        return $this->input('name', '');
    }

    public function location() : string
    {
        return $this->input('location', '');
    }

    public function websiteUrl() : string
    {
        return $this->input('website_url', '');
    }

    public function startDate() : DateTimeImmutable
    {
        $startDate = $this->input('start_date');
        Assert::notNull($startDate);

        $startDateDate = DateTimeImmutable::createFromFormat(
            'Y-m-d H:i',
            $startDate
        );

        Assert::isInstanceOf($startDateDate, DateTimeImmutable::class);

        return $startDateDate;
    }

    public function endDate() : DateTimeImmutable
    {
        $endDate = $this->input('end_date');
        Assert::notNull($endDate);

        $endDateDate = DateTimeImmutable::createFromFormat(
            'Y-m-d H:i',
            $endDate
        );

        Assert::isInstanceOf($endDateDate, DateTimeImmutable::class);

        return $endDateDate;
    }

    public function promoteOnAgenda() : bool
    {
        return (bool)$this->input('promote_on_agenda', false);
    }

    public function openForRegistration() : bool
    {
        return (bool)$this->input('open_for_registration', false);
    }
}
