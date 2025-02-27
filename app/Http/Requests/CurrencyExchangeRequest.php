<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CurrencyExchangeRequest extends FormRequest
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
            'baseCurrency' => 'nullable|string|exists:currencies,code',
            'targetedCurrency' => 'nullable|string|exists:currencies,code',
            'amount' => ['nullable', 'numeric', 'min:1', 'regex:/^\d+(\.\d{1,2})?$/'],
        ];
    }
}
