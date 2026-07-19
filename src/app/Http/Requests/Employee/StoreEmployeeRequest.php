<?php

namespace App\Http\Requests\Employee;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmployeeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            'business_id' => ['required','exists:businesses,id'],

            'branch_id' => ['required','exists:branches,id'],

            'employee_position_id' => ['required','exists:employee_positions,id'],

            'user_id' => ['nullable','exists:users,id'],

            'first_name' => ['required','string','max:255'],

            'last_name' => ['required','string','max:255'],

            'email' => ['nullable','email','max:255','unique:employees,email'],

            'phone' => ['required','string','max:20','unique:employees,phone'],

            'birth_date' => ['nullable','date'],

            'gender' => ['required','in:male,female'],

            'experience_years' => ['nullable','integer','min:0'],

            'about' => ['nullable','string'],

            'photo' => ['nullable','string'],

            'is_active' => ['boolean'],

        ];
    }
}
