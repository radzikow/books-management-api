<?php

namespace App\Http\Requests\Books;

use Illuminate\Foundation\Http\FormRequest;

class GetBooksRequest extends FormRequest
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
            'title' => 'sometimes|string|min:1|max:200',
            'description' => 'sometimes|string|min:1',
            'page' => 'sometimes|integer',
            'per_page' => 'sometimes|integer|min:1|max:200',
        ];
    }
}
