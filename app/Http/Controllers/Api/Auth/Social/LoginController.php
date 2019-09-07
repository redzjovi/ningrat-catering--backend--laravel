<?php

namespace App\Http\Controllers\Api\Auth\Social;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserSocialiteResource;
use App\Models\UserSocialite;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
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
