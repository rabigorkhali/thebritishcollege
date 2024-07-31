<?php

namespace App\Http\Controllers;

use App\Http\Controllers\ResourceController;
use App\Services\PostCategoryService;
use App\Services\UserService;
use Illuminate\Http\Request;

class PostCategoryController extends ResourceController
{
    protected $service;

    public function __construct(PostCategoryService $service)
    {
        parent::__construct($service);
    }

    public function moduleName()
    {
        return 'post-categories';
    }


    public function viewFolder()
    {
        return 'post-categories';
    }

    public function formValidationRequest()
    {
        return 'App\Http\Requests\PostCategoryRequest';
    }

}
