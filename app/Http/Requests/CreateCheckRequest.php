<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

/**
 * CreateCheckRequest
 *
 * @property string $title
 * @property string $description
 * @property float  $amount
 * @property array  $quotients
 *
 */

class CreateCheckRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check() && $this->ajax();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'title'         =>  'required|max:255',
            'description'   =>  'max:1000',
            'amount'        =>  'required|numeric|min:0',

            'quotients'     =>  'array|min:1'
        ];

        foreach ($this->quotients as $key=>$value) {
            $rules['quotients.' . $key . 'user_id'] = 'required|exists:users,id';
            $rules['quotients.' . $key . 'amount']  = 'required|numeric|min:0';
        }

        return $rules;
    }

    /**
     *  Additional validations
     *
     * @param Validator $validator
     */
    public function withValidator(Validator $validator)
    {
        $validator->after(function (Validator $validator) {
            if ($this->amountsAreNotEqual()) {
                $validator->errors()->add('amount', 'Check amount and value of users amount are not equal');
            }
        });
    }

    /**
     *  Check that quotients amounts and check amount are equal
     *
     * @return boolean
     */
    protected function amountsAreNotEqual()
    {
        return abs($this->amount - collect($this->quotients)->sum('amount')) > 0.5;
    }
}
