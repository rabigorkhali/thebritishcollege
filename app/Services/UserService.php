<?php

namespace App\Services;

use App\Events\UserSaved;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserService extends Service
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function store($request)
    {
        $data = $request->except('_token');
        $data['password'] = Hash::make($data['password']);
        // DB::beginTransaction();
        $user = $this->model->create($data);

        return $user;
    }

    public function update($request, $id)
    {
        $data = $request->only('name', 'email');
        if (trim($request->get('password'))) {
            $data['password'] = Hash::make($request->get('password'));
        }
        $user = $this->itemByIdentifier($id);
        $user->fill($data)->save();
        $newUserData = $this->itemByIdentifier($id);
        return $newUserData;
    }

    public function delete($request, $id)
    {
        if (Auth::user()->id == $id) {
            $responseErrorData['alert-danger'] = __('messages.delete_denied_custom_message', ['custom_message' => __('messages.is_user_logined')]);
            return $responseErrorData;
        }
        $item = $this->itemByIdentifier($id);
        return $item->delete();
    }
}
