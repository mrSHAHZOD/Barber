<?php

namespace App\Http\Requests\Business;

use Illuminate\Foundation\Http\FormRequest;

class StoreBusinessRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            'business_type_id' => ['required','exists:business_types,id'],

            'name' => ['required','string','max:255'],

            'phone' => ['nullable','string','max:20'],

            'email' => ['nullable','email'],

            'description' => ['nullable','string'],

            'logo' => ['nullable','image'],

            'cover' => ['nullable','image'],

            'has_multiple_branches' => ['boolean'],
        ];
    }
}
