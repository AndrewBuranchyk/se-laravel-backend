<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CardStoreRequest extends FormRequest
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
     * @return array
     */
    public function rules(): array
    {
        return [
            'department_id' => ['required', 'numeric'],
            'gr' => ['required', 'numeric'],
            'el' => ['required', 'numeric'],
            'ms' => ['required', 'numeric'],
            'rp' => ['required', 'numeric'],
            'data' => ['required', 'string'],

        ];
    }
}
