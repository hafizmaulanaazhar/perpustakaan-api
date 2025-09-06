<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="LoanResource",
 *     type="object",
 *     title="Loan Resource",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="user_id", type="integer", example=1),
 *     @OA\Property(property="book_id", type="integer", example=1),
 *     @OA\Property(property="book_title", type="string", example="Sample Book"),
 *     @OA\Property(property="book_author", type="string", example="John Doe"),
 *     @OA\Property(property="loan_date", type="string", format="date", example="05-12-23"),
 *     @OA\Property(property="due_date", type="string", format="date", example="19-12-23"),
 *     @OA\Property(property="return_date", type="string", format="date", example=null, nullable=true),
 *     @OA\Property(property="status", type="string", example="active"),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="05-12-23 14:30"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="05-12-23 14:30")
 * )
 */
class LoanResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'           => $this->id,
            'user_id'      => $this->user_id,
            'book_id'      => $this->book_id,
            'book_title'   => $this->book->title,
            'book_author'  => $this->book->author,
            'loan_date'    => $this->loan_date ? $this->loan_date->format('d-m-y') : null,
            'due_date'     => $this->due_date ? $this->due_date->format('d-m-y') : null,
            'return_date'  => $this->return_date ? $this->return_date->format('d-m-y') : null,
            'status'       => $this->return_date ? 'returned' : 'active',
            'created_at'   => $this->created_at->format('d-m-y H:i'),
            'updated_at'   => $this->updated_at->format('d-m-y H:i'),
        ];
    }
}
