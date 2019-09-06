<?php

namespace App\Http\Controllers\Api\Auth\User;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

/**
 * @group auth/user
 */
class ChangePasswordController extends Controller
{
    /**
     * POST change-password
     * @headerParam Accept application/json
     * @headerParam Content-Type application/x-www-form-urlencoded
     * @bodyParam old_password string required
     * @bodyParam new_password string required
     * @bodyParam confirm_password string required
     * @response 200
     *  {
     *      "message": "You're successfully change your password."
     *  }
     * @response 401
     *  {
     *      "message": "Unauthenticated."
     *  }
     * @response 422
     *  {
     *      "message": "The given data was invalid.",
     *      "errors": {
     *           "old password": [
     *              "The old password field is required.",
     *              "Invalid current password."
     *          ],
     *           "new password": [
     *              "The old password field is required.",
     *          ],
     *           "confirm_password": [
     *              "The old password field is required.",
     *              "The confirm password and new password must match."
     *          ],
     *      }
     *  }
     */
    public function store(\App\Http\Requests\Api\Auth\User\ChangePassword\StoreRequest $request)
    {
        $password = $request->input('new_password');
        $user = auth('api')->user();
        User::updateUserSetPasswordWhereUser($password, $user);

        $data['message'] = 'You\'re successfully change your password.';

        return response()->json($data);
    }
}
