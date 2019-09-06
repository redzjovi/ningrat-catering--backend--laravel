<?php

namespace App\Http\Requests\Api\Auth\User\ChangePassword;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'old_password' => [
                'required',
                new \App\Rules\AuthAttemptRule('api', [
                    'email' => auth('api')->user()->email,
                    'password' => $this->old_password,
                ]),
            ],
            'new_password' => ['required'],
            'confirm_password' => ['required', 'same:new_password'],
        ];
    }
}
