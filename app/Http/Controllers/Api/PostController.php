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

class PostController extends Controller
{

    protected $service,$fractal;

    public function __construct(PostService $service)
    {
        $this->service = $service;
        $this->fractal = new Manager();

    }

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
        ]);    }

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
