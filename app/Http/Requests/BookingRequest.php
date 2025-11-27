<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'full_name' => 'required|string|max:255',
            'service_id' => 'required|exists:services,id',
            'scheduled_date' => 'required|date',
            'scheduled_time' => 'required',
            'whatsapp' => 'required|string|max:30',
        ];
    }
}
