<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\RequestWarningsTrait;

class UpdateCheckRequest extends CreateCheckRequest
{

    use RequestWarningsTrait;


    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->ajax();
    }

    public function rules()
    {

        return array_merge(parent::rules(), ['quotients.*.id' => 'sometimes|numeric|exists:quotients,id']);
    }

    /**
     * @param Validator $validator
     */
    public function withValidator(Validator $validator)
    {
        parent::withValidator($validator);

        $this->filterPaidQuotients($validator);
    }

    /**
     *  Filter quotients which are paid or partially paid
     * 
     * @param Validator $validator
     */
    private function filterPaidQuotients(Validator $validator)
    {
        $this->quotients = collect($this->quotients)
            ->filter(function ($quotient, $key) use ($validator) {
                if (!isset($quotient['id'])) {
                    return true;
                } elseif (!$validator->errors()->has('quotients.' . $key . '.id')) {
                    if (!\Quotient::find($quotient['id'])->hasPayments()) {
                        return true;
                    } else {
                        $this
                            ->warnings()
                            ->add('quotients.' . $key . '.id', 'You can\'t edit quotient with payment');
                        return false;
                    }
                }
                return false;
            })
            ->toArray();
    }


}
