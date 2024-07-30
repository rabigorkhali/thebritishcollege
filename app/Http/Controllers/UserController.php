<?php

namespace App\Http\Controllers;

use App\Http\Controllers\ResourceController;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends ResourceController
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        parent::__construct($userService);
    }

    public function moduleName()
    {
        return 'users';
    }


    public function viewFolder()
    {
        return 'users';
    }

    public function formValidationRequest()
    {
        return 'App\Http\Requests\UserRequest';
    }

    
    public function update($id)
    {
        if (!empty($this->formValidationRequest())) {
            $request = $this->formValidationRequest();
        } else {
            $request = $this->defaultRequest();
        }
        $request = app()->make($request);
        try {
            $this->service->update($request, $id);
            return redirect($this->indexUrl())->withErrors(['alert-success' => __('messages.update_message')]);
        } catch (Throwable $throwable) {
            dd($throwable);
            return redirect()->back()->withErrors(['alert-danger' => __('messages.server_error')]);
        }
    }

}
