<?php

namespace App\Http\Requests\Business;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateBusinessRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [

            'business_type_id'=>['sometimes','exists:business_types,id'],

            'name'=>['sometimes','string','max:255'],

            'phone'=>['nullable','string','max:20'],

            'email'=>['nullable','email'],

            'description'=>['nullable','string'],

            'logo'=>['nullable','image'],

            'cover'=>['nullable','image'],

            'has_multiple_branches'=>['boolean'],
        ];
    }
}
