<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\UpdateCheckRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCheckRequest;

class CheckController extends Controller
{
    /**
     *  Check info
     *
     * @param \Check $check
     * @return array
     */
    public function info(\Check $check)
    {
        return $check
            ->load('quotients')
            ->toArray();
    }

    /**
     *  Create check request
     *
     * @param CreateCheckRequest $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function create(CreateCheckRequest $request)
    {
        /** @var \App\Models\Check $check */
        $check = \Check::create(array_merge(
            $request->all(),
            [
                'user_id' => auth()->id(),
                'status'  => \Check::NOT_PAID
            ]
        ));

        foreach ($request->quotients as $quotient) {
            \Quotient::create(array_merge($quotient, [ 'check_id'  =>  $check->id ]));
        }

        return response()
            ->json(
                [ 'id' => $check->id ],
                201,
                [ 'location' => route('api.checks.info', [ 'check' => $check->id ]) ]
            );
    }

    public function update(UpdateCheckRequest $request, \Check $check)
    {
        $check->update($request->all());

        foreach ($request->quotients  as $quotient_id=>$quotient_data) {

            /** @var \App\Models\Quotient $quotient */
            if ($quotient = \Quotient::find($quotient_id)) {
                $quotient->update($quotient_data);
            } else {
                \Quotient::create(array_merge($quotient_data, [ 'check_id'  =>  $check->id ]));
            }
        }

        return response()
            ->json(array_merge(
                $check->load('quotients')->toArray(),
                [ 'warnings' => $request->warnings()->all() ]
            ));

    }
}
