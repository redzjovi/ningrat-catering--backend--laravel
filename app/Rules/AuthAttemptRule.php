<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class AuthAttemptRule implements Rule
{
    protected $guard;
    protected $credentials;

    /**
     * Create a new rule instance.
     * @param string $guard
     * @param array $credentials
     * @return void
     */
    public function __construct($guard, $credentials)
    {
        $this->guard = $guard;
        $this->credentials = $credentials;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return auth($this->guard)->attempt($this->credentials);

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Invalid current password.';
    }
}
