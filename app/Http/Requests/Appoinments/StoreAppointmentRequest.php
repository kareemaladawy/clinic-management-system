<?php

namespace App\Http\Requests\Appoinments;

use Illuminate\Foundation\Http\FormRequest;

class StoreAppointmentRequest extends FormRequest
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
            'slot_id' => 'required|exists:slots,id',
            'specialty' => 'required|string|max:255',
            'completed' => 'boolean'
        ];
    }
}
