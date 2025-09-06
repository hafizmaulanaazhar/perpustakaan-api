<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLoanRequest;
use App\Models\Loan;
use App\Jobs\SendLoanNotification;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Loans",
 *     description="API Endpoints for Book Loans"
 * )
 */
class LoanController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/loans",
     *     summary="Create a new book loan",
     *     tags={"Loans"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"user_id", "book_id", "due_date"},
     *             @OA\Property(property="user_id", type="integer", example=1),
     *             @OA\Property(property="book_id", type="integer", example=1),
     *             @OA\Property(property="due_date", type="string", format="date", example="2023-12-31")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Loan created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Book loan created successfully"),
     *             @OA\Property(property="loan", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function store(StoreLoanRequest $request)
    {
        $loan = Loan::create([
            'user_id' => $request->user_id,
            'book_id' => $request->book_id,
            'loan_date' => now(),
            'due_date' => $request->due_date
        ]);

        // Dispatch job to send notification
        SendLoanNotification::dispatch($loan);

        return response()->json([
            'message' => 'Book loan created successfully',
            'loan' => $loan
        ], 201);
    }

    /**
     * @OA\Get(
     *     path="/api/loans/{user_id}",
     *     summary="Get active loans for a user",
     *     tags={"Loans"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="user_id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="integer"),
     *                 @OA\Property(property="user_id", type="integer"),
     *                 @OA\Property(property="book_id", type="integer"),
     *                 @OA\Property(property="loan_date", type="string", format="date"),
     *                 @OA\Property(property="due_date", type="string", format="date"),
     *                 @OA\Property(property="return_date", type="string", format="date", nullable=true),
     *                 @OA\Property(property="book", type="object")
     *             )
     *         )
     *     )
     * )
     */
    public function show($user_id)
    {
        $loans = Loan::with('book')
            ->where('user_id', $user_id)
            ->whereNull('return_date')
            ->get();

        return response()->json($loans);
    }
}
