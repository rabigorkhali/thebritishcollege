<?php

namespace App\Services;

use App\Models\PostCategory;
use App\Models\PostCategoryPost;

class PostCategoryService extends Service
{
    public function __construct(PostCategory $model)
    {
        parent::__construct($model);
    }

    public function getAllData($data, $selectedColumns = [], $pagination = true)
    {
        $query = $this->query();
        if (count($selectedColumns) > 0) {
            $query->select($selectedColumns);
        }
        if ($data['search'] ?? null) {
            $query->where('name', 'like', '%' . $data['search'] . '%');
        }

        if ($pagination) {
            return $query->orderBy('created_at', 'DESC')->paginate(5);
        } else {
            return $query->orderBy('created_at', 'DESC')->get();
        }

    }
    public function delete($request, $id)
    {
        $item = $this->itemByIdentifier($id);
        if (!$item) {
            $response['alert-danger'] = __('messages.data_not_found');
            return $response;
        }
        $inUse = PostCategoryPost::where('post_category_id', $id)->count();
        if ($inUse) {
            $response['alert-danger'] = __('messages.in_use_message');
            return $response;
        }
        return $item->delete();
    }

}
