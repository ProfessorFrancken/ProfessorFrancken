<?php

declare(strict_types=1);

namespace Francken\Association\News\Http\Requests;

use DateTimeImmutable;
use Illuminate\Foundation\Http\FormRequest;
use League\Period\Period;
use Webmozart\Assert\Assert;

class SearchNewsRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'subject' => ['nullable', 'min:1', ],
            'author' => ['nullable', 'min:1', ],
            'published_before' => ['nullable', 'date_format:Y-m-d'],
            'published_after' => ['nullable', 'date_format:Y-m-d'],
        ];
    }

    public function subject() : ?string
    {
        return $this->input('subject');
    }

    public function author() : ?string
    {
        return $this->input('author');
    }

    public function publishedBefore() : ?DateTimeImmutable
    {
        if ($this->input('published_before') === null) {
            return null;
        }

        $publishedBefore = DateTimeImmutable::createFromFormat(
            'Y-m-d',
            $this->input('published_before')
        );

        Assert::isInstanceOf($publishedBefore, DateTimeImmutable::class);

        return $publishedBefore;
    }

    public function publishedAfter() : ?DateTimeImmutable
    {
        if ($this->input('published_after') === null) {
            return null;
        }

        $publishedAfter = DateTimeImmutable::createFromFormat(
            'Y-m-d',
            $this->input('published_after')
        );

        Assert::isInstanceOf($publishedAfter, DateTimeImmutable::class);

        return $publishedAfter;
    }

    public function period() : Period
    {
        $publishedBefore = $this->publishedBefore() ?? new DateTimeImmutable('-2 years');
        $publishedAfter = $this->publishedBefore() ?? new DateTimeImmutable('+2 years');

        return new Period($publishedBefore, $publishedAfter);
    }
}
