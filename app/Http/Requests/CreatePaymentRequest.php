<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Payment request
 *
 * @property-read float $amount
 * @property-read string $comment
 *
 * @mixin \Request
 */

class CreatePaymentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->ajax();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'amount' => 'required|numeric|min:0|not_in:0',
            'comment'=> 'sometimes|string|regex:/^[\pL\s\-]+$/u'
        ];
    }

    public function withValidator(Validator $validator)
    {
        $validator->after(function (Validator $validator) {
            if (!$validator->errors()->has('amount') && !$this->checkAmount()) {
                $validator->errors()
                    ->add('amount', 'The amount value is incorrect');
            }
        });
    }

    private function checkAmount()
    {
        /** @var \App\Models\Quotient $quotient */
        $quotient = $this->route('quotient');

        // Amount can't be grater or smaller than quotient amount.
        // We also should check whether there are some quotient payments
        $left = $quotient->amount - $quotient->payments()->sum('amount');

        return $this->amount >= $left && $this->amount <= $left;
    }
}
