<?php 
// app/Transformers/PostCategoryTransformer.php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\PostCategory;

class PostCategoryTransformer extends TransformerAbstract
{
    /**
     * Transform the given post category model.
     *
     * @param  \App\Models\PostCategory  $postCategory
     * @return array
     */
    public function transform(PostCategory $postCategory)
    {
        return [
            'id' => (int) $postCategory->id,
            'name' => $postCategory->name,
            'created_at' => $postCategory->created_at->toDateTimeString(),
            'updated_at' => $postCategory->updated_at->toDateTimeString(),
        ];
    }
}
