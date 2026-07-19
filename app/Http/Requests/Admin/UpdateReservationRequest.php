<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateReservationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'status'    => 'sometimes|in:confirmed,cancelled,modified',
            'check_in'  => 'sometimes|date',
            'check_out' => 'sometimes|date|after:check_in',
        ];
    }
}
