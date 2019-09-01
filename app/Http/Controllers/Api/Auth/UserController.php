<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;

/**
 * @group auth
 */
class UserController extends Controller
{
    /**
     * GET user
     * @headerParam Accept application/json
     * @headerParam Authorization Bearer {token}
     * @response 200
     *  {
     *      "data": {
     *          "id": 2,
     *          "name": "user@mailinator.com",
     *          "email": "user@mailinator.com",
     *          "email_verified_at": null,
     *          "created_at": "2019-08-31 05:43:49",
     *          "updated_at": "2019-08-31 05:43:49"
     *      }
     *  }
     * @response 401
     *  {
     *      "message": "Unauthenticated."
     *  }
     */
    public function index()
    {
        $user = auth()->user();

        return new UserResource($user);
    }
}
