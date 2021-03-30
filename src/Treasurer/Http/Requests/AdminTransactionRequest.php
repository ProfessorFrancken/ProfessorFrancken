<?php

declare(strict_types=1);

namespace Francken\Treasurer\Http\Requests;

use DateTimeImmutable;
use Illuminate\Foundation\Http\FormRequest;
use Webmozart\Assert\Assert;

final class AdminTransactionRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules() : array
    {
        $priceIsRequired = $this->route('transaction') !== null;
        return [
            'member_id' => ['integer', 'exists:francken-legacy.leden,id'],
            'product_id' => ['integer', 'exists:francken-legacy.producten,id'],
            'time' => ['date_format:Y-m-d H:i:s'],
            'price' => [$priceIsRequired ? 'required' : 'nullable', 'numeric'],
            'amount' => ['required', 'integer'],
        ];
    }

    public function memberId() : int
    {
        return (int)$this->input('member_id', '');
    }

    public function productId() : int
    {
        return (int)$this->input('product_id', '');
    }

    public function amount() : int
    {
        return (int)$this->input('amount');
    }

    public function price() : int
    {
        return (int)$this->input('price');
    }

    public function totalPrice() : int
    {
        if ($this->amount() !== 1) {
            return (int)$this->input('totaalprijs');
        }
        return $this->price();
    }

    public function time() : DateTimeImmutable
    {
        return $this->toDateTimeImmutable($this->input('time'));
    }

    private function toDateTimeImmutable(string $input) : DateTimeImmutable
    {
        $dateTime = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $input);

        Assert::isInstanceOf($dateTime, DateTimeImmutable::class);

        return $dateTime;
    }
}
