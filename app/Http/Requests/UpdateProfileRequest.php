<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UpdateProfileRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'string|max:255|regex:/^[a-z ,.\'-]+$/i',
            'email' => 'email|max:255|unique:patients,email',
            'password' => [Password::defaults()],
            'phone_number' => 'regex:/(01)[0-9]{9}/|unique:patients,phone_number',
            'birthday' => 'date_format:Y-m-d|before:today',
            'avatar' => 'mimes:jpeg,png,jpg,gif,svg|max:2048',
            'specialty' => 'string|max:255',
            'description' => 'min:3|max:2500',
            'location' => 'min:3|max:255'
        ];
    }
}
