<?php

namespace App\Http\Requests\Feedbacks;

use Illuminate\Foundation\Http\FormRequest;

class StoreFeedbackRequest extends FormRequest
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
            'doctor_id' => 'required|exists:doctors,id',
            'body' => 'required|string|min:3|max:1000',
        ];
    }
}
