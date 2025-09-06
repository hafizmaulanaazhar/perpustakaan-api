<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Http\Resources\BookResource;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * @OA\Tag(
 *     name="Books",
 *     description="API Endpoints for Books Management"
 * )
 */
class BookController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/books",
     *     summary="Get list of books",
     *     tags={"Books"},
     *     @OA\Parameter(
     *         name="author",
     *         in="query",
     *         description="Filter by author",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="year",
     *         in="query",
     *         description="Filter by publication year",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         description="Search by title",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/BookResource")
     *             ),
     *             @OA\Property(
     *                 property="links",
     *                 type="object",
     *                 @OA\Property(property="first", type="string"),
     *                 @OA\Property(property="last", type="string"),
     *                 @OA\Property(property="prev", type="string"),
     *                 @OA\Property(property="next", type="string")
     *             ),
     *             @OA\Property(
     *                 property="meta",
     *                 type="object",
     *                 @OA\Property(property="current_page", type="integer"),
     *                 @OA\Property(property="from", type="integer"),
     *                 @OA\Property(property="last_page", type="integer"),
     *                 @OA\Property(property="path", type="string"),
     *                 @OA\Property(property="per_page", type="integer"),
     *                 @OA\Property(property="to", type="integer"),
     *                 @OA\Property(property="total", type="integer")
     *             )
     *         )
     *     )
     * )
     */
    public function index(Request $request)
    {
        $query = Book::query();

        // Filter by author
        if ($request->has('author') && !empty($request->author)) {
            $query->where('author', 'like', '%' . $request->author . '%');
        }

        // Filter by year
        if ($request->has('year') && !empty($request->year)) {
            $query->where('published_year', $request->year);
        }

        // Search by title
        if ($request->has('search') && !empty($request->search)) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $books = $query->orderBy('title')->paginate(10);

        return BookResource::collection($books);
    }

    /**
     * @OA\Post(
     *     path="/api/books",
     *     summary="Create a new book",
     *     tags={"Books"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"title", "author", "published_year", "isbn", "stock"},
     *             @OA\Property(property="title", type="string", example="The Great Gatsby"),
     *             @OA\Property(property="author", type="string", example="F. Scott Fitzgerald"),
     *             @OA\Property(property="published_year", type="integer", example=1925),
     *             @OA\Property(property="isbn", type="string", example="9780743273565"),
     *             @OA\Property(property="stock", type="integer", example=10)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Book created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/BookResource")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function store(StoreBookRequest $request)
    {
        $book = Book::create($request->validated());

        return new BookResource($book);
    }

    /**
     * @OA\Get(
     *     path="/api/books/{id}",
     *     summary="Get book details",
     *     tags={"Books"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Book ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/BookResource")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Book not found"
     *     )
     * )
     */
    public function show(Book $book)
    {
        return new BookResource($book);
    }

    /**
     * @OA\Put(
     *     path="/api/books/{id}",
     *     summary="Update a book",
     *     tags={"Books"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Book ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"title", "author", "published_year", "isbn", "stock"},
     *             @OA\Property(property="title", type="string", example="The Great Gatsby"),
     *             @OA\Property(property="author", type="string", example="F. Scott Fitzgerald"),
     *             @OA\Property(property="published_year", type="integer", example=1925),
     *             @OA\Property(property="isbn", type="string", example="9780743273565"),
     *             @OA\Property(property="stock", type="integer", example=15)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Book updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/BookResource")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Book not found"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function update(UpdateBookRequest $request, Book $book)
    {
        $book->update($request->validated());

        return new BookResource($book);
    }

    /**
     * @OA\Delete(
     *     path="/api/books/{id}",
     *     summary="Delete a book",
     *     tags={"Books"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Book ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Book deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Book not found"
     *     )
     * )
     */
    public function destroy(Book $book)
    {
        // Check if book has active loans
        if ($book->activeLoans()->exists()) {
            return response()->json([
                'message' => 'Cannot delete book with active loans'
            ], Response::HTTP_CONFLICT);
        }

        $book->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * @OA\Get(
     *     path="/api/books/{id}/availability",
     *     summary="Check book availability",
     *     tags={"Books"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Book ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="available", type="boolean", example=true),
     *             @OA\Property(property="available_stock", type="integer", example=5),
     *             @OA\Property(property="total_stock", type="integer", example=10),
     *             @OA\Property(property="active_loans", type="integer", example=5)
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Book not found"
     *     )
     * )
     */
    public function availability(Book $book)
    {
        return response()->json([
            'available' => $book->available_stock > 0,
            'available_stock' => $book->available_stock,
            'total_stock' => $book->stock,
            'active_loans' => $book->activeLoans()->count()
        ]);
    }
}
