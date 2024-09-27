<?php

namespace App\Http\Controllers\Api;

use App\Models\Book;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Book\StoreBookRequest;
use App\Http\Requests\Book\UpdateBookRequest;
use App\Http\Resources\BookResource;
use App\Services\ApiResponseService;
use App\Services\BookService;

class BookController extends Controller
{
    protected $bookService;
    public function __construct(BookService $bookService)
    {
        $this->bookService = $bookService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $books = $this->bookService->listAllBooks();
            return ApiResponseService::success(BookResource::collection($books), 'Books retrieved successfully', 200);
        } catch (\Exception $e) {
            return ApiResponseService::error('An error occurred on the server.', 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookRequest $request)
    {
        $validated = $request->validated();

        try {
            $newBook = $this->bookService->createBook($validated);
            return ApiResponseService::success(new BookResource($newBook), 'Book created successfully', 201);
        } catch (\Exception $e) {
            return ApiResponseService::error('An error occurred on the server.', 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $book = $this->bookService->showBook($id);
            return ApiResponseService::success(new BookResource($book), 'Book retrieved successfully', 200);
        } catch (\Exception $e) {
            return ApiResponseService::error('An error occurred on the server.', 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBookRequest $request, string $id)
    {
        $validated = $request->validated();

        try {
            $updatedBook = $this->bookService->updateBook($id, $validated);
            return ApiResponseService::success(new BookResource($updatedBook), 'Book updated successfully', 200);
        } catch (\Exception $e) {
            return ApiResponseService::error('An error occurred on the server.', 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $this->bookService->deleteBook($id);
            return ApiResponseService::success(null, 'Book deleted successfully', 200);
        } catch (\Exception $e) {
            return ApiResponseService::error(null, 'An error occurred on the server.', 500);
        }
    }

    /**
     * Display a listing of books by a category.
     *
     * @param string $categoryId
     * @return \Illuminate\Http\JsonResponse
     */
    public function indexByACategory(string $categoryId)
    {
        try {
            $books = $this->bookService->listBooksByACategory($categoryId);
            return ApiResponseService::success($books, 'This category books:', 200);
        } catch (\Exception $e) {
            return ApiResponseService::error('An error occurred on the server.', 500);
        }
    }

    /**
     * List only active books by a category.
     * 
     * @param mixed $categoryId
     * @return \Illuminate\Http\JsonResponse
     */
    public function indexActiveBooks($categoryId)
    {
        try {
            $books = $this->bookService->listActiveBooksByCategory($categoryId);
            return ApiResponseService::success($books, 'Active books retrieved successfully', 200);
        } catch (\Exception $e) {
            return ApiResponseService::error('An error occurred on the server.', 500);
        }
    }

    /**
     * Retrieve all categories along with their books.
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function indexByAllCategories()
    {
        try {
            $books = $this->bookService->listAllCategoriesWithBooks();
            return ApiResponseService::success($books, 'Categories with books retrieved successfully', 200);
        } catch (\Exception $e) {
            return ApiResponseService::error('An error occurred on the server.', 500);
        }
    }
}
