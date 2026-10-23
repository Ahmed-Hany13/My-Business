<?php

namespace App\Http\Requests;

use App\Models\Client;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Override;

class UpdateClientRequest extends FormRequest
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
            "name" => [
                'required',
                'string',
                'max:255',
                'min:3',
                Rule::unique('clients', 'name')->ignore($this->route('client'))
            ],
            "phone" => ['nullable', 'string'],
            "balance" => ['nullable', 'numeric'],
            "debt" => ['nullable', 'numeric'],
            "monthly_payment" => ['nullable', 'numeric'],
            "start_date" => ['required', 'date'],
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'حقل اسم العميل مطلوب.',
            'name.min' => 'يجب ألا يقل اسم العميل عن 3 أحرف.',
            'name.max' => 'يجب ألا يتجاوز اسم العميل 255 حرفاً.',
            'name.unique' => 'اسم العميل هذا مسجل مسبقاً.',
            'balance.numeric' => 'يجب أن يكون الرصيد قيمة عددية.',
            'debt.numeric' => 'يجب أن تكون المديونية قيمة عددية.',
            'start_date.required' => 'حقل تاريخ البدء مطلوب.',
            'start_date.date' => 'يرجى إدخال تاريخ بدء صالح.',
        ];
    }
}
