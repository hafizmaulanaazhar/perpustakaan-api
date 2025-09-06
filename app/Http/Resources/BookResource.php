<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="BookResource",
 *     type="object",
 *     title="Book Resource",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="title", type="string", example="Sample Book Title"),
 *     @OA\Property(property="author", type="string", example="John Doe"),
 *     @OA\Property(property="published_year", type="integer", example=2023),
 *     @OA\Property(property="isbn", type="string", example="1234567890123"),
 *     @OA\Property(property="stock", type="integer", example=5),
 *     @OA\Property(property="available_stock", type="integer", example=3),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */
class BookResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'author' => $this->author,
            'published_year' => $this->published_year,
            'isbn' => $this->isbn,
            'stock' => $this->stock,
            'available_stock' => $this->available_stock,
            'created_at' => optional($this->created_at)->timezone('Asia/Jakarta')->format('d-m-y H:i'),
            'updated_at' => optional($this->updated_at)->timezone('Asia/Jakarta')->format('d-m-y H:i'),
        ];
    }
}
