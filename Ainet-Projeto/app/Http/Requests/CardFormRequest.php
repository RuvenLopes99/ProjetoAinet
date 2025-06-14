<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CardFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'id' => 'required|integer',
            'card_number' => 'required|numeric|min:100000|max:999999',
            'balance' => 'required|numeric|min:0',
        ];
    }
}
