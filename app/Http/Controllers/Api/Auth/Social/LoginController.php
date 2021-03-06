<?php

namespace App\Http\Controllers\Api\Auth\Social;

use App\Http\Controllers\Controller;
use App\Models\UserSocialite;
use Illuminate\Http\Request;

/**
 * @group auth/social
 */
class LoginController extends Controller
{
    /**
     * POST login
     * @headerParam Accept application/json
     * @headerParam Content-Type application/x-www-form-urlencoded
     * @bodyParam provider string required
     * @bodyParam provider_id string required
     * @bodyParam data string required Array Example: []
     * @bodyParam email string required Email Example: user@mailinator.com
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
     *          "provider": [
     *              "The provider field is required."
     *          ],
     *          "provider_id": [
     *              "The provider id field is required."
     *          ],
     *          "data": [
     *              "The data field is required."
     *          ],
     *          "email": [
     *              "The email field is required.",
     *              "The email must be a valid email address."
     *          ]
     *      }
     *  }
     */
    public function store(\App\Http\Requests\Api\Auth\Social\Login\StoreRequest $request)
    {
        $userSocialite = UserSocialite::createOrUpdateUserSocialiteByProviderAndProviderId(
            $request->input('data'),
            $request->input('provider'),
            $request->input('provider_id'),
            $request->input('email')
        );

        $user = $userSocialite->user;
        $userToken = auth('api')->login($user);

        return response()->json([
            'data' => [
                'access_token' => $userToken,
            ]
        ]);
    }
}
