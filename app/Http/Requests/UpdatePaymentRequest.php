<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePaymentRequest extends CreatePaymentRequest
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

    public function withValidator(Validator $validator)
    {
        if (!$validator->errors()->has('amount')) {
            $validator->after(function (Validator $validator) {
               if (!$this->checkAmount()) {
                   $validator->errors()->add('amount', 'The amount value is incorrect');
               }
            });
        }
    }

    private function checkAmount()
    {
        /** @var \App\Models\Payment $payment */
        $payment = $this->route('payment');

        /** @var \App\Models\Quotient $quotient */
        $quotient = $payment->quotient;

        // Amount can't be grater or smaller than quotient amount.
        // We also should check whether there are some quotient payments
        $left = $quotient->amount - $quotient->payments()->where('id', '!=', $payment->id)->sum('amount');

        return $this->amount >= $left && $this->amount <= $left;
    }
}
