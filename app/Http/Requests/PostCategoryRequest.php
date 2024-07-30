<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class PostCategoryRequest extends FormRequest
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
                'name' => 'required|unique:post_categories|string|max:255',
            ];
        }
        if ($request->method() == 'PUT') {
            $validate = [
                'name' => 'required|unique:post_categories,name,' . $request->id,
            ];
        }
        return $validate;
    }

    public function messages()
    {
        return [];
    }
}
