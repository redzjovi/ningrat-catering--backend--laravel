<?php

namespace App\Http\Requests\Api\Auth\Social\Login;

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
            'provider' => ['required'],
            'provider_id' => ['required'],
            'data' => ['required'],

            // user
            'email' => ['required', 'email'],
        ];
    }
}
