<?php

namespace App\Http\Requests\Employee;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEmployeeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $employee = $this->route('employee');

        return [

            'branch_id' => ['sometimes','exists:branches,id'],

            'employee_position_id' => ['sometimes','exists:employee_positions,id'],

            'user_id' => ['nullable','exists:users,id'],

            'first_name' => ['sometimes','string','max:255'],

            'last_name' => ['sometimes','string','max:255'],

            'email' => [
                'nullable',
                'email',
                'max:255',
                'unique:employees,email,'.optional($employee)->id,
            ],

            'phone' => [
                'sometimes',
                'string',
                'max:20',
                'unique:employees,phone,'.optional($employee)->id,
            ],

            'birth_date' => ['nullable','date'],

            'gender' => ['sometimes','in:male,female'],

            'experience_years' => ['nullable','integer','min:0'],

            'about' => ['nullable','string'],

            'photo' => ['nullable','string'],

            'is_active' => ['boolean'],
        ];
    }
}
