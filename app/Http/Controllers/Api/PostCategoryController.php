<?php

namespace App\Http\Controllers\Api;

use App\Constants\HttpStatusCodes;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\PostCategoryRequest;
use App\Services\PostCategoryService;
use App\Transformers\PostCategoryTransformer;
use Illuminate\Http\Request;
use App\Models\PostCategory;
use Throwable;
use DB;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;

class PostCategoryController extends Controller
{

    protected $service, $fractal;

    public function __construct(PostCategoryService $service)
    {
        $this->service = $service;
        $this->fractal = new Manager();

    }
    /**
     * @OA\Tag(
     *     name="Post Categories",
     *     description="Operations related to post categories"
     * )
     */

    /**
     * @OA\Get(
     *     path="/api/post-categories",
     *     summary="Get a list of post categories",
     *     tags={"Post Categories"},
     *     security={{"sanctum": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="List of post categories",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="Technology"),
     *                 @OA\Property(property="description", type="string", example="Posts related to technology")
     *             )
     *         )
     *     )
     * )
     */
    public function index()
    {
        $postCategories = PostCategory::paginate(5);

        $resource = new Collection($postCategories->items(), new PostCategoryTransformer());
        $data = $this->fractal->createData($resource)->toArray();

        return response()->json([
            'data' => $data,
            'meta' => [
                'current_page' => $postCategories->currentPage(),
                'last_page' => $postCategories->lastPage(),
                'per_page' => $postCategories->perPage(),
                'total' => $postCategories->total(),
            ]
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/post-categories",
     *     summary="Create a new post category",
     *     tags={"Post Categories"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 @OA\Property(property="name", type="string", example="Health"),
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Post category created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=2),
     *             @OA\Property(property="name", type="string", example="Health"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request",
     *         @OA\JsonContent(
     *             @OA\Property(property="errors", type="object",
     *                 @OA\Property(property="name", type="array", @OA\Items(type="string")),
     *             )
     *         )
     *     )
     * )
     */
    public function store(PostCategoryRequest $request)
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
     *     path="/api/post-categories/{id}",
     *     summary="Update an existing post category",
     *     tags={"Post Categories"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the post category",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 @OA\Property(property="name", type="string", example="Updated Name"),
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Post category updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="name", type="string", example="Updated Name"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request",
     *         @OA\JsonContent(
     *             @OA\Property(property="errors", type="object",
     *                 @OA\Property(property="name", type="array", @OA\Items(type="string")),
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Post category not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Post category not found")
     *         )
     *     )
     * )
     */
    public function update(PostCategoryRequest $request, $id)
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
     *     path="/categories/{id}",
     *     summary="Delete a post category",
     *     tags={"Post Categories"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the post category",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Post category deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Post category not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Post category not found")
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
