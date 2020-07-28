<?php

declare(strict_types=1);

namespace Francken\Association\Members\Http\Requests;

use Francken\Association\Members\PaymentDetails;
use Illuminate\Foundation\Http\FormRequest;
use Webmozart\Assert\Assert;

class PaymentDetailsRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules() : array
    {
        return [
            'iban' => ['nullable', 'iban'],
            'deduct_additional_costs' => ['nullable', 'boolean'],
        ];
    }

    public function paymentDetails() : PaymentDetails
    {
        return new PaymentDetails(
            $this->iban(),
            null,
            $this->deductAdditionalCosts()
        );
    }

    private function iban() : string
    {
        $iban = preg_replace('/[^\d\w]+/', '', $this->input('iban'));

        Assert::string($iban);

        return $iban;
    }

    private function deductAdditionalCosts() : bool
    {
        return (bool) $this->input('deduct_additional_costs');
    }
}
