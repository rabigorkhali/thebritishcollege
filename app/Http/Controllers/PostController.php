<?php

namespace App\Http\Controllers;

use App\Services\PostService;
use Illuminate\Http\Request;

class PostController extends ResourceController
{
    protected $service;

    public function __construct(PostService $service)
    {
        parent::__construct($service);
    }
    public function moduleName()
    {
        return 'posts';
    }


    public function viewFolder()
    {
        return 'posts';
    }

    public function formValidationRequest()
    {
        return 'App\Http\Requests\PostRequest';
    }
}
