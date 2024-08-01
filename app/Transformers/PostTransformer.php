<?php 
// app/Transformers/PostTransformer.php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Post;

class PostTransformer extends TransformerAbstract
{
    /**
     * Transform the given post model.
     *
     * @param  \App\Models\Post  $post
     * @return array
     */
    public function transform(Post $post)
    {
        return [
            'id' => (int) $post->id,
            'title' => $post->title,
            'body' => $post->body,
            'image' => asset('uploads/posts').'/'.$post->image,
            'created_at' => $post->created_at->toDateTimeString(),
            'updated_at' => $post->updated_at->toDateTimeString(),
        ];
    }
}
