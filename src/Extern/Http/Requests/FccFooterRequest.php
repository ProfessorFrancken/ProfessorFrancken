<?php

declare(strict_types=1);

namespace Francken\Extern\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;
use Webmozart\Assert\Assert;

class FccFooterRequest extends FormRequest
{
    /**
     * @var int
     */
    public const MAX_FILE_SIZE = 10 * 1024;

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules() : array
    {
        return [
            'is_enabled' => ['nullable', 'boolean'],
            'logo' => ['image', 'max:' . self::MAX_FILE_SIZE],
        ];
    }

    public function isActive() : bool
    {
        return (bool)$this->input('is_enabled', false);
    }

    public function logo() : ?UploadedFile
    {
        $file = $this->file('logo');

        if ($file === null) {
            return null;
        }

        Assert::isInstanceOf($file, UploadedFile::class);

        return $file;
    }
}
