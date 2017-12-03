<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCheckRequest;

class CheckController extends Controller
{
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

        return response(
            '',
            201,
            [ 'location' => route('api.check.info', [ 'check' => $check->id ]) ]
        );
    }
}
