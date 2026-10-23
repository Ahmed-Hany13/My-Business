<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClientRequest extends FormRequest
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
            "name" => ['required', 'string', 'max:255', 'min:3', 'unique:clients,name'],
            "product" => ['nullable', 'string', 'max:255'],
            "monthly_payment" => ['nullable', 'numeric'],
            "balance" => ['nullable', 'numeric'],
            "debt" => ['nullable', 'numeric'],
            "notes" => ['nullable', 'string'],
            "start_date" => ['required', 'date'],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'name' => 'اسم العميل',
            'monthly_payment' => 'الدفع الشهري',
            'balance' => 'الرصيد',
            'debt' => 'المديونية',
            'start_date' => 'تاريخ البدء',
            'product' => 'المنتج',
            'notes' => 'الملاحظات',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'حقل اسم العميل مطلوب.',
            'name.min' => 'يجب ألا يقل اسم العميل عن 3 أحرف.',
            'name.max' => 'يجب ألا يتجاوز اسم العميل 255 حرفاً.',
            'name.unique' => 'اسم العميل هذا مسجل مسبقاً.',
            'monthly_payment.numeric' => 'يجب أن يكون الدفع الشهري قيمة عددية.',
            'monthly_payment.min' => 'يجب أن يكون الدفع الشهري قيمة إيجابية.',
            'balance.numeric' => 'يجب أن يكون الرصيد قيمة عددية.',
            'debt.numeric' => 'يجب أن تكون المديونية قيمة عددية.',
            'start_date.required' => 'حقل تاريخ البدء مطلوب.',
            'start_date.date' => 'يرجى إدخال تاريخ بدء صالح.',
        ];
    }
}

