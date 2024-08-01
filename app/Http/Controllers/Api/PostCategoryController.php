<?php

namespace App\Http\Controllers\Api;

use App\Constants\HttpStatusCodes;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\PostCategoryRequest;
use App\Services\PostCategoryService;
use Illuminate\Http\Request;
use App\Models\PostCategory;
use Throwable;
use DB;

class PostCategoryController extends Controller
{

    protected $service;

    public function __construct(PostCategoryService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return PostCategory::all();
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
