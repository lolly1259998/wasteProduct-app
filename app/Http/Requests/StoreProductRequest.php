<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock_quantity' => ['required', 'integer', 'min:0'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'waste_category_id' => ['nullable', 'exists:waste_categories,id'],
            'recycling_process_id' => ['nullable', 'exists:recycling_processes,id'],
            'image_path' => ['nullable', 'string'],
            'specifications' => ['nullable', 'array'],
            'is_available' => ['boolean'],
        ];
    }
}
