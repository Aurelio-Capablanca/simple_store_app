<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductBillRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'product_name' => 'required|string|max:100',
            'product_description' => 'required|string|max:100',
            'product_price' => 'required|float',
            'has_discount' => 'bool',
            'has_stock' => 'bool',
            'is_available' => 'bool',          
            'expiring_date' => 'datetime',
            'id_category' => 'required|integer',
        ];
    }
}
