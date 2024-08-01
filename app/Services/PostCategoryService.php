<?php

namespace App\Services;

use App\Models\PostCategory;

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

}
