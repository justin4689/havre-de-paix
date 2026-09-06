<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreReservationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'room_id'          => 'required|exists:rooms,id',
            'check_in'         => 'required|date',
            'check_out'        => 'required|date|after:check_in',
            'guests'           => 'required|integer|min:1',
            'guest_name'       => 'required|string|max:100',
            'guest_email'      => 'required|email',
            'guest_phone'      => 'required|string|max:30',
            'special_requests' => 'nullable|string|max:500',
        ];
    }
}
