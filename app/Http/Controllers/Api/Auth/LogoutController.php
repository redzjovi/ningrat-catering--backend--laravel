<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * @group auth
 */
class LogoutController extends Controller
{
    /**
     * POST logout
     * @headerParam Accept application/json
     * @headerParam Authorization Bearer {token}
     * @response 204
     * @response 401
     *  {
     *      "message": "Unauthenticated."
     *  }
     */
    public function store(Request $request)
    {
        auth('api')->logout();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
