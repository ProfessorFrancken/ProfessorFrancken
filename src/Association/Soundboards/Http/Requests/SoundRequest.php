<?php

declare(strict_types=1);

namespace Francken\Association\Soundboards\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Plank\Mediable\Media;

class SoundRequest extends FormRequest
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
        $aggregateTypes = config('mediable.aggregate_types');
        $audioMimes = collect($aggregateTypes[Media::TYPE_AUDIO]['mime_types'])->implode((','));

        return [
            'name' => ['nullable'],
            'css_background' => ['nullable'],
            'css_foreground' => ['nullable'],
            'image' => ['nullable', 'file', 'image', 'max:' . self::MAX_FILE_SIZE],
            'audio' => ['nullable', 'file', 'mimetypes:' . $audioMimes, 'max:' . self::MAX_FILE_SIZE]
        ];
    }

    public function name() : string
    {
        return $this->input('name', '') ?? '';
    }

    public function cssBackground() : string
    {
        return $this->input('css_background', '') ?? '';
    }

    public function cssForeground() : string
    {
        return $this->input('css_foreground', '') ?? '';
    }

    public function uploadedByMemberId() : int
    {
        return $this->user()->member_id;
    }
}
