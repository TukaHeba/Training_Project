<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ApiResponseService;
use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Services\CategoryService;

class CategoryController extends Controller
{
    protected $categoryService;
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $categories = $this->categoryService->listAllCategories();
            return ApiResponseService::success(CategoryResource::collection($categories), 'Categories retrieved successfully', 200);
        } catch (\Exception $e) {
            return ApiResponseService::error('An error occurred on the server.', 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        $validated = $request->validated();

        try {
            $newCategory = $this->categoryService->createCategory($validated);
            return ApiResponseService::success(new CategoryResource($newCategory), 'Category created successfully', 201);
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
            $category = $this->categoryService->showCategory($id);
            return ApiResponseService::success(new CategoryResource($category), 'Category retrieved successfully', 200);
        } catch (\Exception $e) {
            return ApiResponseService::error('An error occurred on the server.', 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, string $id)
    {
        $validated = $request->validated();

        try {
            $updatedCategory = $this->categoryService->updateCategory($id, $validated);
            return ApiResponseService::success(new CategoryResource(resource: $updatedCategory), 'Category updated successfully', 200);
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
            $this->categoryService->deleteCategory($id);
            return ApiResponseService::success(null, 'Category deleted successfully', 200);
        } catch (\Exception $e) {
            return ApiResponseService::error(null, 'An error occurred on the server.', 500);
        }
    }
}
