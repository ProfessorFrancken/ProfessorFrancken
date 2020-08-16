<?php

declare(strict_types=1);

namespace Francken\Treasurer\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class AdminProductRequest extends FormRequest
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
            'name' => ['required', 'min:1'],
            'price' => ['required', 'integer'],
            'category' => ['required', 'in:Beer,Food,Soda'],
            'available' => ['nullable', 'boolean'],
            'position' => ['required', 'integer', 'min:1'],
            'photo' => ['image', 'max:' . self::MAX_FILE_SIZE],
        ];
    }

    public function name() : string
    {
        return $this->input('name');
    }

    public function category() : string
    {
        return $this->input('category');
    }

    public function dutchCategory() : string
    {
        $englishToDutch = [
                'Beer' => 'Bier',
                'Food' => 'Eten',
                'Soda' => 'Fris',
            ];
        return $englishToDutch[$this->category()] ?? 'Onbekend';
    }

    public function price() : int
    {
        return (int)$this->input('price');
    }

    public function position() : int
    {
        return (int)$this->input('position');
    }

    public function available() : bool
    {
        return (bool)$this->input('available');
    }
}
