<?php

namespace App\Services;

use App\Models\Business;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BusinessService
{
    public function create(array $data): Business
    {
        $data['owner_id'] = Auth::id();

        $data['slug'] = Str::slug($data['name']);

        return Business::create($data);
    }

    public function update(Business $business, array $data): Business
    {
        if (isset($data['name'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        $business->update($data);

        return $business->refresh();
    }

    public function delete(Business $business): void
    {
        $business->delete();
    }
}
