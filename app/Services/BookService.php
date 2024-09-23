<?php

namespace App\Services;

use App\Models\Book;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class BookService
{
    /**
     * Retrieve all books with pagination.
     * 
     * @throws \Exception
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function listAllBooks()
    {
        try {
            return Book::paginate(5);
        } catch (\Exception $e) {
            Log::error('Failed to retrieve books: ' . $e->getMessage());
            throw new \Exception('An error occurred on the server.');
        }
    }

    /**
     * Create a new book with the provided data.
     * 
     * @param array $data
     * @throws \Exception
     * @return Book|\Illuminate\Database\Eloquent\Model
     */
    public function createBook(array $data)
    {
        try {
            return Book::create($data);
        } catch (\Exception $e) {
            Log::error('Books creation failed: ' . $e->getMessage());
            throw new \Exception('An error occurred on the server.');
        }
    }

    /**
     * Retrieve a single book.
     * 
     * @param \App\Models\Book $book
     * @throws \Exception
     * @return Book
     */
    public function showBook(string $id)
    {
        try {
            $book = Book::findOrFail($id);
            return $book;
        } catch (ModelNotFoundException $e) {
            throw new \Exception('Book not found: ' . $e->getMessage());
        } catch (\Exception $e) {
            Log::error('Failed to retrieve book: ' . $e->getMessage());
            throw new \Exception('An error occurred on the server.');
        }
    }

    /**
     * Update an existing book with the provided data.
     * 
     * @param \App\Models\Book $book
     * @param array $data
     * @throws \Exception
     * @return Book
     */
    public function updateBook(string $id, array $data)
    {
        try {
            $book = Book::findOrFail($id);
            $book->update(array_filter($data));

            return $book;
        } catch (ModelNotFoundException $e) {
            throw new \Exception('Book not found: ' . $e->getMessage());
        } catch (\Exception $e) {
            Log::error('Failed to update book: ' . $e->getMessage());
            throw new \Exception('An error occurred on the server.');
        }
    }

    /**
     * Delete a book.
     * 
     * @param \App\Models\Book $book
     * @throws \Exception
     * @return bool
     */
    public function deleteBook(string $id)
    {
        try {
            $book = Book::findOrFail($id);

            return $book->delete();
        } catch (ModelNotFoundException $e) {
            throw new \Exception('Book not found: ' . $e->getMessage());
        } catch (\Exception $e) {
            Log::error('Failed to delete book: ' . $e->getMessage());
            throw new \Exception('An error occurred on the server.');
        }
    }
}
