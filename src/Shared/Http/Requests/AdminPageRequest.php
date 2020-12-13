<?php

declare(strict_types=1);

namespace Francken\Shared\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class AdminPageRequest extends FormRequest
{
    public function rules() : array
    {
        return [
            'title' => ['required', 'min:1'],
            'slug' => ['required', 'min:1'],
            'description' => ['nullable'],
            'source_content' => ['nullable', 'min:1'],
        ];
    }

    public function content() : string
    {
        return $this->input('source_content', '') ?? '';
    }

    public function title() : string
    {
        return $this->input('title');
    }

    public function description() : string
    {
        return $this->input('description') ?? '';
    }

    public function slug() : string
    {
        return collect(explode('/', $this->slug))
            ->map(fn (string $s) => Str::slug($s))
            ->join('/');
    }

    public function isPublished() : bool
    {
        return (bool)$this->input('is_published', false);
    }
}
