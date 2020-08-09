<?php

declare(strict_types=1);

namespace Francken\Association\Activities\Http\Requests;

use Francken\Association\Activities\Activity;
use Francken\Association\Activities\SignUp;
use Illuminate\Foundation\Http\FormRequest;
use Webmozart\Assert\Assert;

class SignUpRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules() : array
    {
        return [
            'plus_ones' => ['nullable', 'integer', 'max:' . $this->maxPlusOnes()],
            'dietary_wishes' => ['nullable', 'min:1'],
            'has_drivers_license' => ['nullable', 'boolean'],
        ];
    }

    public function plusOnes() : int
    {
        return (int) $this->input('plus_ones');
    }

    public function dietaryWishes() : string
    {
        return $this->input('dietary_wishes') ?? '';
    }

    public function hasDriversLicense() : bool
    {
        return (bool)$this->input('has_drivers_license', false);
    }

    private function maxPlusOnes() : int
    {
        $activity = $this->route('activity');
        Assert::isInstanceOf($activity, Activity::class);

        $maxPlusOnes = (int)$activity->signUpSettings->max_sign_ups - $activity->total_sign_ups - 1;

        // make sure the current sign up is not counted in the max
        $signUp = $this->route('sign_up');
        if ($signUp instanceof SignUp) {
            return $maxPlusOnes + 1 + (int)$signUp->plus_ones;
        }

        return $maxPlusOnes;
    }
}
