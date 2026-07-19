<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BusinessResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,

            'name' => $this->name,
            'slug' => $this->slug,

            'phone' => $this->phone,
            'email' => $this->email,

            'description' => $this->description,

            'logo' => $this->logo,
            'cover' => $this->cover,

            'is_active' => $this->is_active,
            'has_multiple_branches' => $this->has_multiple_branches,

            'business_type' => $this->whenLoaded('businessType'),
            'owner' => $this->whenLoaded('owner'),

            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
