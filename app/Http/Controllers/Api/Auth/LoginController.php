<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * @group auth
 */
class LoginController extends Controller
{
    /**
     * POST login
     * @headerParam Accept application/json
     * @headerParam Content-Type application/x-www-form-urlencoded
     * @bodyParam email string required Email Example: user@mailinator.com
     * @bodyParam password string required
     * @response 200
     *  {
     *      "data": {
     *          "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9uaW5ncmF0LWNhdGVyaW5nLS1iYWNrZW5kLS1sYXJhdmVsLmRvY2tlclwvYXBpXC9hdXRoXC9yZWdpc3RlciIsImlhdCI6MTU2NzMzNTI3MCwiZXhwIjoxNTY3MzM4ODcwLCJuYmYiOjE1NjczMzUyNzAsImp0aSI6IlgwYXJBUzIzVm1LZ1Q0aDAiLCJzdWIiOjkyLCJwcnYiOiI4N2UwYWYxZWY5ZmQxNTgxMmZkZWM5NzE1M2ExNGUwYjA0NzU0NmFhIn0.IaMrDyoml_DH7WRGnzDgeJ_8JkfyEPN0ZBLN982w3p0"
     *      }
     *  }
     * @response 422
     *  {
     *      "message": "The given data was invalid.",
     *      "errors": {
     *          "email": [
     *              "The email field is required.",
     *              "The email must be a valid email address."
     *          ],
     *          "password": [
     *              "The password field is required."
     *          ]
     *      }
     *  }
     */
    public function store(\App\Http\Requests\Api\Auth\Login\StoreRequest $request)
    {
        $credentials = request(['email', 'password']);

        if (! $accessToken = auth('api')->attempt($credentials)) {
            return response()->json(['message' => trans('cms.unauthorized')], Response::HTTP_UNAUTHORIZED);
        }

        return response()->json([
            'data' => [
                'access_token' => $accessToken,
            ]
        ]);
    }
}
