<?php

namespace App\Http\Requests\User;

use App\Models\User;
use App\Rules\FilterRule;
use App\Rules\PaginationRule;
use App\Rules\SortRule;
use Illuminate\Foundation\Http\FormRequest;

class IndexRequest extends FormRequest
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
            'sort' => ['nullable', 'string', new SortRule((new User)->getFillable())],
            'page' => ['nullable', 'array', new PaginationRule()],
            'page.*' => ['nullable', 'numeric'],
            'filter' => ['nullable', 'array', new FilterRule((new User)->getFillable())],
        ];
    }
}