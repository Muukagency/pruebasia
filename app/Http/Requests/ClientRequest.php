<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'full_name' => 'required|string|max:255',
            'whatsapp' => 'required|string|max:30',
            'email' => 'nullable|email',
            'notes' => 'nullable|string',
            'source' => 'required|in:web,meta,whatsapp,google_ads,manual',
            'status' => 'required|in:reservado,confirmado,pagado,atendido,cancelado,no_show',
            'advisor_id' => 'nullable|exists:users,id'
        ];
    }
}
