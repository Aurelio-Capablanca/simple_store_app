<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RetailerRequest extends FormRequest
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
            //
            'retailer_name' => 'required|string|max:25',
            'retailer_company' => 'required|string|max:55',
            'retailer_phone' => 'string|max:8',
            'retailer_email' => ['email', 'required', Rule::unique('retailer')->ignore($this->route('id'), 'id_retailer')],
        ];
    }
}
