<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreatePaymentRequest;

class PaymentController extends Controller
{

    public function store(CreatePaymentRequest $request, \Quotient $quotient)
    {
        /** @var \App\Models\Payment $payment */
        $payment = $quotient->payments()
            ->create($request->only(['amount', 'comment']));

        return response()->json(
            [ 'id' => $payment->id ],
            201,
            [ 'location' => route('api.payments.show', ['quotient' => $quotient, 'payment' => $payment->id])]
        );
    }

    /**
     *  Simple payment
     *
     * @param CreatePaymentRequest $request
     * @param \Quotient $quotient
     * @return \Illuminate\Http\JsonResponse
     */
    public function simple(CreatePaymentRequest $request, \Quotient $quotient)
    {
        /** @var \Illuminate\Database\Eloquent\Collection $quotients */
        $quotients = \Quotient::latest()
            ->notPaid()
            ->whereRaw('SELE')
            ->get();

        $quotients->reduce(function ($amount, \Quotient $quotient) use ($request) {

            if (is_null($amount)) {
                $amount = $request->amount;
            }

            if ( $amount > 0 ) {
                /** @var float $left Quotient's not paid value */
                $left = $quotient->amount - $quotient->payments()->sum('amount');
                if ( $amount >= $left ) {
                    \Payment::create([
                        'quotient_id' => $quotient->id,
                        'amount' => $left,
                        'comment' => $request->comment
                    ]);
                    $amount -= $left;
                } else {
                    \Payment::create([
                        'quotient_id' => $quotient->id,
                        'amount' => $amount,
                        'comment' => $request->comment
                    ]);
                    $amount = 0;
                }

                return $amount;
            }

            return false;
        });

        return response()
            ->json(
                [ 'id' => $payment->id ],
                200,
                ['location' => route(
                    'api.payments.show', [
                        'quotient' => $quotient->id,
                        'payment'  => $payment->id
                    ])
                ]);
    }

}
