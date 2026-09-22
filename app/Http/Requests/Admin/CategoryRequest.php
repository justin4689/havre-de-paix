<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:60',
            'name_en' => 'nullable|string|max:60',
            'tagline' => 'nullable|string|max:100',
            'tagline_en' => 'nullable|string|max:100',
            'sort_order' => 'nullable|integer|min:0|max:999',
            'featured_room_id' => 'nullable|integer|exists:rooms,id',
        ];
    }
}
