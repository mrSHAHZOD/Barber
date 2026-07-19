<?php

namespace App\OpenApi\Schemas;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'User',
    required: ['id', 'name', 'phone'],
    properties: [
        new OA\Property(property: 'id', type: 'integer', example: 1),
        new OA\Property(property: 'name', type: 'string', example: 'Ali Valiyev'),
        new OA\Property(property: 'phone', type: 'string', example: '+998901234567'),
        new OA\Property(property: 'email', type: 'string', format: 'email', nullable: true, example: null),
    ],
    type: 'object'
)]
class UserSchema
{
}
