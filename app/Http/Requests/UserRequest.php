<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(Request $request)
    {
        $validate = [];
        if ($request->method() == 'POST') {

            $validate = [
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users',
                'password' => 'required|string|min:8',
                'confirm_password' => 'required|string|min:8|same:password',

            ];
        }
        if ($request->method() == 'PUT') {
            $validate = [
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $request->user,
                'password' => 'nullable|string|min:8',
                'confirm_password' => 'nullable|string|min:8|same:password',            ];
        }
        return $validate;
    }

    public function messages()
    {
        return [];
    }
}
