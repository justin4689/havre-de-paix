<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class RoomRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'              => 'required|string|max:100',
            'description_short' => 'required|string|max:255',
            'description_long'  => 'nullable|string',
            'capacity_adults'   => 'required|integer|min:1|max:10',
            'capacity_children' => 'nullable|integer|min:0|max:10',
            'size_m2'           => 'nullable|integer',
            'bed_type'          => 'required|in:single,double,twin,king',
            'floor'             => 'required|integer|min:0|max:10',
            'view'              => 'required|in:sea,lagoon,garden,pool',
            'amenities'         => 'nullable|array',
            'amenities.*'       => 'string|max:100',
            'new_images'        => 'nullable|array',
            'new_images.*'      => 'image|max:2048',
            'price_per_night'   => 'required|integer|min:1000',
            'min_nights'        => 'nullable|integer|min:1',
            'status'            => 'required|in:active,inactive,maintenance',
        ];
    }
}
