<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ListNewsRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'page' => ['integer', 'min:1'],
            'limit' => ['integer', 'min:1', 'max:100'],
            'search' => ['string', 'max:255'],
            'category' => ['string', 'max:255'],
        ];
    }
}
