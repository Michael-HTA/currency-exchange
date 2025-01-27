<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookmarkStoreRequest extends FormRequest
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
            'amount' => 'required|numeric',
            'baseCurrency' => 'required|string|exists:currencies,code',
            'targetedCurrency' => 'required|string|exists:currencies,code',
            'exchangeRate' => 'required|numeric',
            'reverseExchangeRate' => 'required|numeric',
        ];
    }
}
