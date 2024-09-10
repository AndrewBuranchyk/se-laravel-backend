<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;
use Symfony\Component\HttpFoundation\Response;

class UserStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if ($this->input('role') == 'admin' && auth()->user()->role != 'admin') {
            abort(response()->json([
                'message' => "You don't have access to store the admin user."
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
            'department_id' => ['required', 'numeric'],
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users',
            ],
            'password' => ['required', 'string', Password::default()],
            'role' => [
                'required',
                'string',
                'in:admin,usersAdmin,viewOnly,user',
            ],
        ];
    }
}
