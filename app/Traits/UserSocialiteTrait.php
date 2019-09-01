<?php

namespace App\Traits;

use \App\User;

trait UserSocialiteTrait
{
    /**
     * @param array $data
     * @param string $provider
     * @param string $providerId
     * @param string $email
     * @return object $userSocialite \App\Models\UserSocialite
     */
    public static function createOrUpdateUserSocialiteByProviderAndProviderId($data, $provider, $providerId, $email)
    {
        $user = User::getOrCreateUserByEmail($email);

        $userSocialite = self::getUserSocialiteWhere($user->id, $provider, $providerId);

        if (! $userSocialite) {
            $userSocialite = self::create([
                'user_id' => $user->id,
                'provider' => $provider,
                'provider_id' => $providerId,
                'data' => json_encode($data),
            ]);
        } else {
            $userSocialite->data = json_encode($data);
            $userSocialite->save();
        }

        return $userSocialite;
    }

    /**
     * @param int $userId
     * @param string $provider
     * @param string $providerId
     * @return object $userSocialite \App\Models\UserSocialite
     */
    public static function getUserSocialiteWhere($userId, $provider, $providerId)
    {
        $userSocialite = self::where('user_id', $userId)
            ->where('provider', $provider)
            ->where('provider_id', $providerId)
            ->first();

        return $userSocialite;
    }
}
