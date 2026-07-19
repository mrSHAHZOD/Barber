<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,

            'business_id' => $this->business_id,
            'branch_id' => $this->branch_id,
            'employee_position_id' => $this->employee_position_id,
            'user_id' => $this->user_id,

            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'full_name' => $this->first_name.' '.$this->last_name,

            'email' => $this->email,
            'phone' => $this->phone,

            'birth_date' => $this->birth_date,

            'gender' => $this->gender,

            'experience_years' => $this->experience_years,

            'about' => $this->about,

            'photo' => $this->photo,

            'rating' => $this->rating,

            'is_active' => $this->is_active,

            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
