<?php

namespace App\Http\Requests\Branch;

use Illuminate\Foundation\Http\FormRequest;

class StoreBranchRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'business_id' => ['required','exists:businesses,id'],
            'name' => ['required','string','max:255'],
            'phone' => ['nullable','string','max:20'],
            'email' => ['nullable','email','max:255'],
            'address' => ['required','string'],
            'latitude' => ['nullable','numeric'],
            'longitude' => ['nullable','numeric'],
            'is_active' => ['boolean'],
        ];
    }
}
