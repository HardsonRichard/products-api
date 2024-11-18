<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rule;

class RatingQueryParamsRequest extends FormRequest
{
    protected $columns;

    public function __construct()
    {
        $this->columns = Schema::getColumnListing('user_ratings');
    }
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'per_page' => 'integer|min:15',
            'page' => 'integer|min:1',
            'sort_order' => 'string|in:asc,desc',
            'search' => 'nullable|string',
            'sort_by' => [
                'nullable',
                'string',
                Rule::in($this->columns),
            ],
        ];
    }
}