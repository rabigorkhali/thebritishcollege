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
