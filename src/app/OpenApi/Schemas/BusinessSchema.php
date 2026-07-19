<?php

namespace App\OpenApi\Schemas;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'Business',
    properties: [
        new OA\Property(property: 'id', type: 'integer', example: 1),
        new OA\Property(property: 'name', type: 'string', example: 'BeautyHub'),
        new OA\Property(property: 'slug', type: 'string', example: 'beautyhub'),
        new OA\Property(property: 'phone', type: 'string', example: '+998901234567'),
        new OA\Property(property: 'email', type: 'string', example: 'info@beautyhub.uz'),
        new OA\Property(property: 'is_active', type: 'boolean', example: true),
    ]
)]
class BusinessSchema
{
}
