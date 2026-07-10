<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // يمكنك تعديل هذا السطر بناءً على صلاحيات المستخدم
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // نوصي بإضافة قاعدة max للتحقق من أن الرقم ضمن نطاق معقول
        // 999999999.99 هو رقم كبير جداً ومناسب
        return [
            'student_id' => ['required', 'exists:users,id'],
            'total_amount' => ['required', 'numeric', 'min:0.01', 'max:999999999.99'],
            'paid_amount' => ['nullable', 'numeric', 'min:0', 'max:999999999.99'],
            'payment_date' => ['required', 'date'],
            'due_date' => ['required', 'date', 'after_or_equal:payment_date'],
            'notes' => ['nullable', 'string', 'max:500'],
        ];
    }
}
