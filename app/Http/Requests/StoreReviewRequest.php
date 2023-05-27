<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreReviewRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'alias' => 'nullable|string|max:20|min:2',
            'img_path' => 'nullable|string|max:255',
            'email' => 'nullable|string|email|max:255|unique:users,email',
            'review' => 'required|string|accepted|max:1500',
            'rating' => 'required|numeric|min:0',
        ];
    }
}
