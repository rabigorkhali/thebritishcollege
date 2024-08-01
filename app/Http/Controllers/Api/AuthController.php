<?php
namespace App\Http\Controllers\Api;

use App\Constants\HttpStatusCodes;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\RegisterUserRequest;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Throwable;
use DB;

class AuthController extends Controller
{
    protected $service;

    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    public function register(RegisterUserRequest $request)
    {
        try {
            $data = [];
            $data['status'] = HttpStatusCodes::OK;
            DB::beginTransaction();
            $user = $this->service->store($request);
            $data['data']['user'] = $user;
            $data['data']['token'] = $user->createToken('Personal Access Token')->plainTextToken;
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

    public function login(LoginRequest $request)
    {
        $data = [];
        if (!Auth::attempt($request->only('email', 'password'))) {
            $data['status'] = HttpStatusCodes::UNAUTHORIZED;
            $data['message'] = 'Unauthorized';
            return response()->json($data, HttpStatusCodes::UNAUTHORIZED);
        }
        $user = Auth::user();
        $data['status'] = HttpStatusCodes::UNAUTHORIZED;
        $data['data']['token'] = $user->createToken('Personal Access Token')->plainTextToken;
        $data['message'] = __('messages.login_successful');
        ;
        return response()->json($data, HttpStatusCodes::OK);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Logged out']);
    }
}
