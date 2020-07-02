<?php

declare(strict_types=1);

namespace Francken\Association\News\Http\Requests;

use DateTimeImmutable;
use Illuminate\Foundation\Http\FormRequest;
use Webmozart\Assert\Assert;

class AdminNewsRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => ['required', 'min:1', ],
            'content' => ['required', 'min:1', ],
            'exerpt' => ['required', 'min:1', ],
            'author_name' => ['required', 'min:1', ],
            'author_photo' => ['required', 'min:1', ],
            'published_at' => ['nullable', 'date_format:Y-m-d'],
        ];
    }

    public function title() : ?string
    {
        return $this->input('title');
    }

    public function content() : ?string
    {
        return $this->input('content');
    }

    public function exerpt() : ?string
    {
        return $this->input('exerpt');
    }

    public function authorName() : ?string
    {
        return $this->input('author_name');
    }

    public function authorPhoto() : ?string
    {
        return $this->input('author_photo');
    }

    public function publishedAt() : ?DateTimeImmutable
    {
        if ($this->input('published_at') === null) {
            return null;
        }

        $publishedAt = DateTimeImmutable::createFromFormat(
            'Y-m-d',
            $this->input('published_at')
        );

        Assert::isInstanceOf($publishedAt, DateTimeImmutable::class);

        return $publishedAt;
    }
}
