<?php

declare(strict_types=1);

namespace Francken\Association\Photos\Http\Requests;

use DateTimeImmutable;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use InvalidArgumentException;

final class AdminAlbumRequest extends FormRequest
{
    public function rules() : array
    {
        return [
            // TODO add a custom rule for checking that the path exists in nextcloud
            // and check that it is a slug
            'path' => ['required'],

            'title' => ['required', 'min:1'],
            'description' => ['nullable'],
            'visibility' => ['required', Rule::in(['private', 'public', 'members-only'])],
            'published_at' => ['required', 'date_format:Y-m-d'],
        ];
    }

    public function path() : string
    {
        return $this->string('path')->toString();
    }

    public function disk() : string
    {
        return 'nextcloud';
    }

    public function title() : string
    {
        return $this->string('title')->toString();
    }

    public function description() : string
    {
        return $this->string('description')->toString();
    }

    public function visibility() : string
    {
        return $this->string('visibility', 'members-only')->toString();
    }

    public function slug() : string
    {
        return Str::slug($this->title());
    }

    public function publishedAt() : DateTimeImmutable
    {
        $installedAt =  $this->toDateTimeImmutable(
            $this->string('published_at')->toString()
        );

        if ($installedAt === null) {
            throw new InvalidArgumentException();
        }

        return $installedAt;
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
