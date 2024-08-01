<?php

namespace App\Services;

use App\Models\Post;
use App\Models\PostCategory;
use DB;
use File;

class PostService extends Service
{
    protected $model, $postCategory, $imageUploadPath;

    public function __construct(Post $model, PostCategory $postCategory)
    {
        parent::__construct($model);
        $this->postCategory = $postCategory;
        $this->imageUploadPath = 'uploads/posts';

    }

    public function getAllData($data, $selectedColumns = [], $pagination = true)
    {
        $query = $this->query();
        if (count($selectedColumns) > 0) {
            $query->select($selectedColumns);
        }
        if ($data['search'] ?? null) {
            $query->where(function ($query) use ($data) {
                $query->orwhere('title', 'like', '%' . $data['search'] . '%')
                    ->orwhere('body', 'like', '%' . $data['search'] . '%');
            });
        }
        if ($data['categories'] ?? null) {
            $query->whereHas('categories', function ($query) use ($data) {
                $query->wherein('post_category_id', $data['categories']);
            });
        }
        if ($pagination) {
            return $query->orderBy('created_at', 'DESC')->paginate(5);
        } else {
            return $query->orderBy('created_at', 'DESC')->get();
        }

    }

    public function indexPageData($request)
    {
        return [
            'items' => $this->getAllData($request),
            'postCategories' => $this->postCategory->get()
        ];
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
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $imagePath = 'uploads/posts/' . $imageName;
                $image->move(public_path('uploads/posts'), $imagePath);
                $requestData['image'] = $imageName;
            }
            $createResponse = $this->model->create($requestData);
            $createResponse->categories()->sync($categories);

            DB::commit();
            return $createResponse;
        } catch (\Throwable $th) {
            DB::rollback();
            return false;
        }
    }

    public function editPageData($request, $id)
    {
        return [
            'item' => $this->itemByIdentifier($id),
            'postCategories' => $this->postCategory->get()
        ];
    }

    public function update($request, $id)
    {
        $thisData = $this->itemByIdentifier($id);
        try {
            $requestData = $request->except('_token', 'image', 'categories');
            $categories = $request->get('categories');
            DB::beginTransaction();
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $imagePath = 'uploads/posts/' . $imageName;
                $image->move(public_path('uploads/posts'), $imagePath);
                $requestData['image'] = $imageName;
                $oldImage = $thisData->image;
                $oldImagePath = public_path('uploads/posts/' . $oldImage);
                if (File::exists($oldImagePath) && $oldImage) {
                    File::delete($oldImagePath);
                }
            }
            $thisData->fill($requestData)->save();
            $thisData->categories()->sync($categories);
            $updatedData = $this->itemByIdentifier($id);
            DB::commit();
            return $updatedData;
        } catch (\Throwable $th) {
            DB::rollback();
            return false;
        }

    }

    //delete a record

    public function delete($request, $id)
    {
        $thisData = $this->itemByIdentifier($id);
        if (!$thisData) {
            $response['alert-danger'] = __('messages.data_not_found');
            return $response;
        }
        $oldImage = $thisData->image;
        $oldImagePath = public_path('uploads/posts/' . $oldImage);
        if (File::exists($oldImagePath) && $oldImage) {
            File::delete($oldImagePath);
        }
        return $thisData->delete();
    }

}
