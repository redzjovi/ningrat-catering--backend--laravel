<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Mail\User\ForgotPasswordMail;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

/**
 * @group auth
 */
class ForgotPasswordController extends Controller
{
    /**
     * POST forgot-password
     * @headerParam Accept application/json
     * @headerParam Content-Type application/x-www-form-urlencoded
     * @bodyParam email string required Email Example: user@mailinator.com
     * @response 200
     *  {
     *      "message": "A new password has been sent to your email."
     *  }
     * @response 422
     *  {
     *      "message": "The given data was invalid.",
     *      "errors": {
     *          "email": [
     *              "The email field is required.",
     *              "The email must be a valid email address.",
     *              "The selected email is invalid."
     *          ]
     *      }
     *  }
     */
    public function store(\App\Http\Requests\Api\Auth\ForgotPassword\StoreRequest $request)
    {
        // 1. Update user, password
        $password = Str::random(8);
        $user = User::getUserOrFailWhereEmail($request->input('email'));
        User::updateUserSetPasswordWhereUser($password, $user);

        // 2. Send email
        \Mail::to($user->email)->send(
            new ForgotPasswordMail($user, $password)
        );

        $data['message'] = 'A new password has been sent to your email.';
        if (config('app.debug')) {
            $data['data']['password'] = $password;
        }

        return response()->json($data);
    }
}
