<?php

namespace App\Http\Controllers\Api;

use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *     title="Book Management API",
 *     version="1.0.0",
 *     description="API for managing books and book loans",
 *     @OA\Contact(
 *         email="admin@bookmanagement.com"
 *     )
 * )
 * @OA\Server(
 *     url="http://localhost:8000",
 *     description="Local API Server"
 * )
 * @OA\Server(
 *     url=L5_SWAGGER_CONST_HOST,
 *     description="API Server"
 * )
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT"
 * )
 * @OA\Tag(
 *     name="Authentication",
 *     description="API Endpoints for Authentication"
 * )
 */
class Controller extends BaseController
{
    // Controller base untuk API
}
