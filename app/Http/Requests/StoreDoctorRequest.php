<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;


class StoreDoctorRequest extends FormRequest
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
            'name' => 'required|string|min:3|max:255|regex:/^[a-z ,.\'-]+$/i',
            'email' => 'required|email|max:255|unique:doctors,email',
            'password' => ['required', Password::defaults()],
            'phone_number' => 'required|regex:/(01)[0-9]{9}/|unique:doctors,phone_number',
            'gender' => 'required|in:male,female',
            'specialty' => 'required|string|max:255',
            'description' => 'required|min:3|max:2500',
            'location' => 'required|min:3|max:255',
            'avatar' => 'required|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ];
    }
}
