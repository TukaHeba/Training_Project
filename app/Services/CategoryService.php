<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CategoryService
{
    /**
     * Retrieve all categories with pagination.
     * 
     * @throws \Exception
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function listAllCategories()
    {
        try {
            return Category::paginate(5);
        } catch (\Exception $e) {
            Log::error('Failed to retrieve categories: ' . $e->getMessage());
            throw new \Exception('An error occurred on the server.');
        }
    }

    /**
     * Create a new category with the provided data.
     * 
     * @param array $data
     * @throws \Exception
     * @return Category|\Illuminate\Database\Eloquent\Model
     */
    public function createCategory(array $data)
    {
        try {
            return Category::create($data);
        } catch (\Exception $e) {
            Log::error('Categories creation failed: ' . $e->getMessage());
            throw new \Exception('An error occurred on the server.');
        }
    }

    /**
     * Retrieve a single category.
     * 
     * @param \App\Models\Category $category
     * @throws \Exception
     * @return Category
     */
    public function showCategory(string $id)
    {
        try {
            $category = Category::findOrFail($id);
            return $category;
        } catch (ModelNotFoundException $e) {
            throw new \Exception('Category not found: ' . $e->getMessage());
        } catch (\Exception $e) {
            Log::error('Failed to retrieve category: ' . $e->getMessage());
            throw new \Exception('An error occurred on the server.');
        }
    }

    /**
     * Update an existing category with the provided data.
     * 
     * @param \App\Models\Category $category
     * @param array $data
     * @throws \Exception
     * @return Category
     */
    public function updateCategory(string $id, array $data)
    {
        try {
            $category = Category::findOrFail($id);
            $category->update(array_filter($data));

            return $category;
        } catch (ModelNotFoundException $e) {
            throw new \Exception('Category not found: ' . $e->getMessage());
        } catch (\Exception $e) {
            Log::error('Failed to update category: ' . $e->getMessage());
            throw new \Exception('An error occurred on the server.');
        }
    }

    /**
     * Delete a category.
     * 
     * @param \App\Models\Category $category
     * @throws \Exception
     * @return bool
     */
    public function deleteCategory(string $id)
    {
        try {
            $category = Category::findOrFail($id);

            return $category->delete();
        } catch (ModelNotFoundException $e) {
            throw new \Exception('Category not found: ' . $e->getMessage());
        } catch (\Exception $e) {
            Log::error('Failed to delete category: ' . $e->getMessage());
            throw new \Exception('An error occurred on the server.');
        }
    }
}
