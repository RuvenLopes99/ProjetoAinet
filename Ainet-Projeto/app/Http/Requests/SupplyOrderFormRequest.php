<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SupplyOrderFormRequest extends FormRequest
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
            'produtct_id' => 'required|exists:products,id',
            'registered_by_user_id' => 'required|exists:users,id',
            'status' => 'required|in:pending,approved,rejected',
            'quantity' => 'required|integer|min:1',
        ];
    }
}
