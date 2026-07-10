<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApplyPaymentRequest extends FormRequest
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
            'new_amount' => ['required', 'numeric', 'min:0', 'max:999999999.99'],
            'payment_date' => ['required', 'date'],
        ];
    }

    /**
     * Get the custom validation messages.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'new_amount.required' => __('validation.new_amount_required'),
            'new_amount.numeric' => __('validation.new_amount_numeric'),
            'new_amount.min' => __('validation.new_amount_min'),
            'payment_date.required' => __('validation.payment_date_required'),
            'payment_date.date' => __('validation.payment_date_date'),
        ];
    }
}
