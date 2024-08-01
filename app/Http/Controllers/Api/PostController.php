<?php

namespace App\Http\Controllers\Api;

use App\Constants\HttpStatusCodes;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\PostRequest;
use App\Services\PostService;
use App\Transformers\PostTransformer;
use Illuminate\Http\Request;
use App\Models\Post;
use Throwable;
use DB;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;

/**
 * @OA\Info(
 *     version="1.0.0",
 *     title="API Documentation",
 *     description="API Documentation using Swagger",
 *     @OA\Contact(
 *         email="developer@example.com"
 *     )
 * )
 */
class PostController extends Controller
{

    protected $service, $fractal;

    public function __construct(PostService $service)
    {
        $this->service = $service;
        $this->fractal = new Manager();

    }

    /**
     * @OA\Get(
     *     path="/api/posts",
     *     operationId="getPostsList",
     *     tags={"Posts"},
     *     summary="Get list of posts",
     *     description="Returns a list of posts",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Post")
     *         ),
     *     ),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(response=403, description="Forbidden"),
     *     @OA\Response(response=404, description="Not Found"),
     *     security={{"sanctum": {}}},
     * )
     */
    public function index()
    {
        $posts = Post::paginate(5);
        $resource = new Collection($posts->items(), new PostTransformer());
        $data = $this->fractal->createData($resource)->toArray();
        return response()->json([
            'status' => HttpStatusCodes::OK,
            'data' => $data,
            'meta' => [
                'current_page' => $posts->currentPage(),
                'last_page' => $posts->lastPage(),
                'per_page' => $posts->perPage(),
                'total' => $posts->total(),
            ]
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/posts",
     *     summary="Create a new post",
     *     tags={"Posts"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 type="object",
     *                 required={"title", "body"},
     *                 @OA\Property(property="title", type="string", example="Sample Title"),
     *                 @OA\Property(property="body", type="string", example="Sample body text"),
     *                 @OA\Property(
     *                     property="image",
     *                     type="string",
     *                     format="binary",
     *                     description="Upload an image"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Post created successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="title", type="string", example="Sample Title"),
     *             @OA\Property(property="body", type="string", example="Sample body text"),
     *             @OA\Property(property="image", type="string", example="sample.jpg")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="errors", type="object")
     *         )
     *     )
     * )
     */

    public function store(PostRequest $request)
    {
        try {
            $data = [];
            $data['status'] = HttpStatusCodes::OK;
            DB::beginTransaction();
            $category = $this->service->store($request);
            $data['data']['category'] = $category;
            $data['message'] = __('messages.create_message');
            DB::commit();
            return response()->json($data, HttpStatusCodes::OK);
        } catch (Throwable $e) {
            DB::rollback();
            $data['status'] = HttpStatusCodes::INTERNAL_SERVER_ERROR;
            $data['message'] = __('messages.server_error');
            return response()->json($data, HttpStatusCodes::INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/posts/{id}",
     *     summary="Update an existing post",
     *     tags={"Posts"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the post to update",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 type="object",
     *                 @OA\Property(property="title", type="string", example="Updated Post Title"),
     *                 @OA\Property(property="body", type="string", example="Updated Post Body"),
     *                 @OA\Property(property="image", type="string", format="binary")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Post updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=12),
     *             @OA\Property(property="title", type="string", example="Updated Post Title"),
     *             @OA\Property(property="body", type="string", example="Updated Post Body"),
     *             @OA\Property(property="image", type="string", example="images/post_image.png"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request",
     *         @OA\JsonContent(
     *             @OA\Property(property="errors", type="object",
     *                 @OA\Property(property="title", type="array", @OA\Items(type="string")),
     *                 @OA\Property(property="body", type="array", @OA\Items(type="string"))
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Post not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Post not found.")
     *         )
     *     ),
     *     security={{"bearerAuth": {}}},
     * )
     */

    public function update(PostRequest $request, $id)
    {

        try {
            $data = [];
            $data['status'] = HttpStatusCodes::OK;
            DB::beginTransaction();
            $category = $this->service->update($request, $id);
            $data['data']['category'] = $category;
            $data['message'] = __('messages.update_message');
            DB::commit();
            return response()->json($data, HttpStatusCodes::OK);
        } catch (Throwable $e) {
            DB::rollback();
            $data['status'] = HttpStatusCodes::INTERNAL_SERVER_ERROR;
            $data['message'] = __('messages.server_error');
            return response()->json($data, HttpStatusCodes::INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/posts/{id}",
     *     summary="Delete a post",
     *     tags={"Posts"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the post to delete",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Post deleted successfully",
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Unauthenticated")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Post not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Post not found.")
     *         )
     *     )
     * )
     */

    public function destroy(Request $request, $id)
    {

        try {
            $data = [];
            $data['status'] = HttpStatusCodes::OK;
            DB::beginTransaction();
            $deleteResponse = $this->service->delete($request, $id);
            $data['message'] = __('messages.delete_message');
            if (isset($deleteResponse['alert-danger'])) {
                DB::rollback();
                $data['message'] = $deleteResponse['alert-danger'];
                $data['status'] = HttpStatusCodes::NOT_FOUND;
                return response()->json($data, HttpStatusCodes::NOT_FOUND);
            }
            DB::commit();
            return response()->json($data, HttpStatusCodes::OK);
        } catch (Throwable $e) {
            DB::rollback();
            $data['status'] = HttpStatusCodes::INTERNAL_SERVER_ERROR;
            $data['message'] = __('messages.server_error');
            return response()->json($data, HttpStatusCodes::INTERNAL_SERVER_ERROR);
        }

    }
}
