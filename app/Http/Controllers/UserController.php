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


}
