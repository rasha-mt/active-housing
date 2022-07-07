<?php

namespace App\Http\Controllers\v1;

use Illuminate\Http\Request;
use Support\Reqres\Reqres;

use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $response = Reqres::getUsersList($request->page);
        if (!$response) {
            return response()->json([
                'data' => $response
            ]);
        }

        return $response;
    }

    public function show($userId)
    {
        $response = Reqres::getUserById($userId);
        if (!$response) {
            return response()->json([
                'data' => $response
            ]);
        }

        return $response;
    }
}
