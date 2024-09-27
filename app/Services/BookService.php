<?php

namespace App\Services;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class BookService
{
    /**
     * Retrieve all books with pagination and eager load the category relationship.
     * 
     * @throws \Exception
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function listAllBooks()
    {
        try {
            return Book::with('category')->paginate(5);
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
            $book = Book::findOrFail($id)->load('category');

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

    /**
     * Retrieve books by a category.
     * 
     * @param string $categoryId
     * @throws \Exception
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function listBooksByACategory(string $categoryId)
    {
        try {
            $category = Category::findOrFail($categoryId);
            $books = $category->books()
                ->select('id', 'title', 'author', 'is_active')->get();

            return $books;
            // return $category->books;
        } catch (ModelNotFoundException $e) {
            throw new \Exception('Category not found: ' . $e->getMessage());
        } catch (\Exception $e) {
            Log::error('Failed to retrieve books by category: ' . $e->getMessage());
            throw new \Exception('An error occurred on the server.');
        }
    }

    /**
     * List active books by category using scopeActive
     * 
     * @param mixed $categoryId
     * @throws \Exception
     * @return mixed
     */
    public function listActiveBooksByCategory($categoryId)
    {
        try {
            $category = Category::findOrFail($categoryId);
            $books =  $category->books()->active()
                ->select('id', 'title', 'author', 'is_active')->get();

            return $books;
        } catch (ModelNotFoundException $e) {
            throw new \Exception('Category not found.');
        } catch (\Exception $e) {
            Log::error('Failed to retrieve active books: ' . $e->getMessage());
            throw new \Exception('An error occurred on the server.');
        }
    }

    /**
     *  Retrieve all categories with their books.
     * 
     * @throws \Exception
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function listAllCategoriesWithBooks()
    {
        try {
            $categories = Category::select('id', 'name')
            ->with('books:id,title,author,is_active,category_id') 
            ->get();

            return $categories;
        } catch (\Exception $e) {
            Log::error('Failed to retrieve categories with books: ' . $e->getMessage());
            throw new \Exception('An error occurred on the server.');
        }
    }
}
