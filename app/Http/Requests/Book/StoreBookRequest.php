<?php

namespace App\Http\Requests\Book;

use App\Services\ApiResponseService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreBookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare and format input data before validation.
     * 
     * - Trims and capitalizes 'title' and 'author', or sets them to null if not provided.
     * - Converts 'published_at' to 'Y-m-d' format, or sets to null if invalid or missing.
     * - Defaults 'is_active' to true if null or empty or invalid boolean value, otherwise converts it to boolean.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'title' => $this->title ? ucwords(trim($this->title)) : null,
            'author' => $this->author ? ucwords(trim($this->author)) : null,
            'published_at' => $this->published_at ? date('Y-m-d', strtotime($this->published_at)) : null,

            'is_active' => ($this->is_active === null || $this->is_active === ''
                || !is_bool(filter_var($this->is_active, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE)))
                ? true
                : filter_var($this->is_active, FILTER_VALIDATE_BOOLEAN),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:200|min:5|unique:books,title',
            'author' => 'required|string|max:150|min:3',
            'is_active' => 'boolean',
            'published_at' => 'required|date|date_format:Y-m-d|before_or_equal:today|after_or_equal:1454-01-01',
            'category_id' => 'required|integer|exists:categories,id',
        ];
    }

    /**
     * Custom attribute names for validation errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'title' => 'book title',
            'author' => 'author name',
            'published_at' => 'published date',
            'is_active' => 'book availability',
            'category_id' => 'category',
        ];
    }

    /**
     * Custom error messages for validation.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'required' => 'The :attribute is required.',
            'unique' => 'This :attribute has already been taken.',
            'min' => 'The :attribute must be at least :min characters.',
            'max' => 'The :attribute cannot exceed :max characters.',
            'exists' => 'The selected :attribute does not exist.',
            'date_format' => 'The :attribute must be in the format YYYY-MM-DD.',
            'boolean' => 'The :attribute field must be true(1) or false(0).',
            'date' => 'The :attribute must be a valid date.',
            'before_or_equal' => 'The :attribute cannot be a future date.',
            'after_or_equal' => 'The :attribute must be after January 1, 1454, the year the first book was published.',
        ];        
    }

    /**
     * Handle validation errors and throw an exception.
     *
     * @param \Illuminate\Contracts\Validation\Validator $validator
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     */
    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors()->all();
        throw new HttpResponseException(
            ApiResponseService::error($errors, 'An error occurred on the server', 422)
        );
    }
}
