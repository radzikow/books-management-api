<?php

namespace App\Http\Requests\Books;

use Illuminate\Foundation\Http\FormRequest;

class StoreOpinionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'rating' => 'required|numeric|min:1|max:10',
            'content' => 'required|string|min:2|max:500',
            'author' => 'required|string|min:2|max:100',
            'email' => 'string|email',
            'book_id' => 'required|numeric|min:1',
        ];
    }
}
