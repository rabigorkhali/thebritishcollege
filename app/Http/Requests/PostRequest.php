<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class PostRequest extends FormRequest
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

        $validate = [
            'title' => 'required|max:255',
            'body' => 'required',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:25048',
        ];

        return $validate;
    }

    public function messages()
    {
        return [];
    }
}
