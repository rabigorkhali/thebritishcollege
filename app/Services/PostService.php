<?php

namespace App\Services;

use App\Models\Post;
use App\Models\PostCategory;
use DB;

class PostService extends Service
{
    protected $model, $postCategory,$imageUploadPath;

    public function __construct(Post $model, PostCategory $postCategory)
    {
        parent::__construct($model);
        $this->postCategory = $postCategory;
        $this->imageUploadPath='uploads/posts';

    }
    public function createPageData($request)
    {
        return [
            'postCategories' => $this->postCategory->get()
        ];
    }

    public function store($request)
    {
        try {
            $requestData = $request->except('_token', 'image', 'categories');
            $categories = $request->get('categories');
            DB::beginTransaction();
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imagePath = 'uploads/posts/' . time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/posts'), $imagePath);
                $requestData['image'] = $imagePath;
            }
            $createResponse= $this->model->create($requestData);
            $createResponse->categories()->sync($categories);
            
            DB::commit();
            return $createResponse;
        } catch (\Throwable $th) {
            DB::rollback();
            return false;
        }
    }

}
