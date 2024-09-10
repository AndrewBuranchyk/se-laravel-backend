<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Symfony\Component\HttpFoundation\Response;

class UserUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if ($this->input('role') == 'admin' && auth()->user()->role != 'admin') {
            abort(response()->json([
                'message' => "You don't have access to update the admin user."
            ], Response::HTTP_FORBIDDEN));
        }
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
            'department_id' => ['nullable', 'numeric'],
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($this->user?->id),
            ],
            'password' => ['nullable', 'string', Password::default()],
            'role' => [
                'required',
                'string',
                'in:admin,usersAdmin,viewOnly,user',
            ],
        ];
    }
}
