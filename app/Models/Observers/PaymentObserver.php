<?php

namespace App\Models\Observers;

class PaymentObserver
{

    public function saved(\Payment $payment)
    {
        /** @var float $paidAmount */
        $paidAmount = $payment->quotient
            ->payments()
            ->sum('amount');

        /** @var int $status New status */
        $status = $payment->quotient->status;

        // Only update case
        if ($payment->quotient->isPaid()) {
            if ($paidAmount < $payment->quotient->amount) {
                $status = \Quotient::PARTIALLY_PAID;
            }
        } else {
            if ($paidAmount > 0) {
                if ($paidAmount == $payment->quotient->amount) {
                    $status = \Quotient::PAID;
                } else {
                    $status = \Quotient::PARTIALLY_PAID;
                }
            }
        }

        if ($status !== $payment->quotient->status) {
            $payment->quotient->update([ 'status' => $status ]);
        }
    }

}