<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePublicFeedbackRequest extends FormRequest
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
            'statement_1_rating' => ['required', 'integer', 'min:1', 'max:5'],
            'statement_2_rating' => ['required', 'integer', 'min:1', 'max:5'],
            'statement_3_rating' => ['required', 'integer', 'min:1', 'max:5'],
            'likes_text' => ['nullable', 'string'],
            'dislikes_text' => ['nullable', 'string'],
            'overall_rating' => ['required', 'integer', 'min:1', 'max:5'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'statement_1_rating.required' => 'Service quality rating is required.',
            'statement_1_rating.integer' => 'Service quality rating must be a number.',
            'statement_1_rating.min' => 'Service quality rating must be between 1 and 5.',
            'statement_1_rating.max' => 'Service quality rating must be between 1 and 5.',
            'statement_2_rating.required' => 'Communication rating is required.',
            'statement_2_rating.integer' => 'Communication rating must be a number.',
            'statement_2_rating.min' => 'Communication rating must be between 1 and 5.',
            'statement_2_rating.max' => 'Communication rating must be between 1 and 5.',
            'statement_3_rating.required' => 'Delivery time rating is required.',
            'statement_3_rating.integer' => 'Delivery time rating must be a number.',
            'statement_3_rating.min' => 'Delivery time rating must be between 1 and 5.',
            'statement_3_rating.max' => 'Delivery time rating must be between 1 and 5.',
            'overall_rating.required' => 'Overall rating is required.',
            'overall_rating.integer' => 'Overall rating must be a number.',
            'overall_rating.min' => 'Overall rating must be between 1 and 5.',
            'overall_rating.max' => 'Overall rating must be between 1 and 5.',
        ];
    }
}
