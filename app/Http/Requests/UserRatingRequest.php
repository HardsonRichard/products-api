<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRatingRequest extends FormRequest
{
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
            'user_id' => 'exists:users,id',
            'product_id' => 'exists:products,id',
            'rating' => 'integer|min:1|max:5',
        ];
    }
}