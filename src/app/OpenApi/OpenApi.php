<?php

namespace App\OpenApi;

use OpenApi\Attributes as OA;

#[OA\Info(
    version: '1.0.0',
    title: 'BeautyHub API',
    description: 'BeautyHub Backend API Documentation'
)]
#[OA\Server(
    url: 'http://localhost:8080',
    description: 'Local Server'
)]
class OpenApi
{
}
