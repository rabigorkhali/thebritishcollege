<?php

namespace App\Swagger\Schemas;

/**
 * @OA\Schema(
 *     schema="Post",
 *     type="object",
 *     title="Post",
 *     required={"title", "body"},
 *     @OA\Property(property="id", type="integer", format="int64"),
 *     @OA\Property(property="title", type="string", description="The title of the post", example="Sample Title"),
 *     @OA\Property(property="body", type="string", description="The body content of the post", example="This is the body content of the post."),
 *     @OA\Property(property="image", type="string", format="binary", description="The image associated with the post"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time"),
 * )
 */
class Post
{
}
