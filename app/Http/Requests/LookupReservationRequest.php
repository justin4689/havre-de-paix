<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LookupReservationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'ref'   => 'required|string|max:20',
            'email' => 'required|email|max:150',
        ];
    }

    public function attributes(): array
    {
        return [
            'ref'   => 'référence',
            'email' => 'email',
        ];
    }
}
