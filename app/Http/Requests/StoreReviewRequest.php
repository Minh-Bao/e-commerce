<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

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
            'alias' => [
                Rule::requiredIf( !Auth::check()),
                'nullable',
                'string',
                'max:10',
                'min:3'               
                ] ,
            'email' => [
                Rule::requiredIf( !Auth::check()),
                'nullable',
                'string',
                'max:30'             
            ], 
            'image_path' => 'nullable|mimes:jpg,jpeg,png,gif|max:10240',
            'review' => 'required|json|max:8000',
            'rating' => 'required|numeric|min:0',
            'user_id' => 'nullable|numeric|exists:users,id',
            'product_id' => 'required|numeric|exists:products,id',
        ];
    }
}
