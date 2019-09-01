<?php

namespace App\Traits;

trait UserTrait
{
    /**
     * @param string $email
     * @return object $user \App\User
     */
    public static function createUserByEmail($email)
    {
        $user = self::create([
            'name' => $email,
            'email' => $email,
            'password' => \Hash::make(str_random(8)),
        ]);

        return $user;
    }

    /**
     * @param string $name
     * @param string $email
     * @param string $password
     * @return object $user \App\User
     */
    public static function createUserByNameAndEmailAndPassword($name, $email, $password)
    {
        $user = self::create([
            'name' => $name,
            'email' => $email,
            'password' => \Hash::make($password),
        ]);

        return $user;
    }

    /**
     * @param string $email
     * @return object $user \App\User
     */
    public static function getOrCreateUserByEmail($email)
    {
        $user = self::where('email', $email)->first();

        if (! $user) {
            $user = self::createUserByEmail($email);
        }

        return $user;
    }
}
