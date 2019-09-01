<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\User;
use Illuminate\Http\Request;

/**
 * @group auth
 */
class RegisterController extends Controller
{
    /**
     * POST register
     * @headerParam Accept application/json
     * @headerParam Content-Type application/x-www-form-urlencoded
     * @bodyParam name string required
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
     *          "name": [
     *              "The name field is required."
     *          ],
     *          "email": [
     *              "The email field is required.",
     *              "The email must be a valid email address.",
     *              "The email has already been taken."
     *          ],
     *          "password": [
     *              "The password field is required."
     *          ]
     *      }
     *  }
     */
    public function store(\App\Http\Requests\Api\Auth\Register\StoreRequest $request)
    {
        $user = User::createUserByNameAndEmailAndPassword(
            $request->input('name'),
            $request->input('email'),
            $request->input('password')
        );

        $userToken = auth('api')->login($user);

        return response()->json([
            'data' => [
                'access_token' => $userToken,
            ]
        ]);
    }
}
