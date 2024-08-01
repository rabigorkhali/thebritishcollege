<?php

namespace App\Http\Controllers;

use App\Http\Controllers\ResourceController;
use App\Services\PostCategoryService;
use App\Services\PostService;
use Illuminate\Http\Request;

class HomeController extends ResourceController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $postService,$postCategoryService;

    public function __construct(PostService $postService, PostCategoryService $postCategoryService)
    {
        $this->middleware('auth');
        $this->postService=$postService;
        $this->postCategoryService=$postCategoryService;
    }

    public function index(Request $request)
    {
        $data=[];
        $data['posts']= $this->postService->getAllData($request);
        $data['postCategories']= $this->postCategoryService->getAllData($request);
        $data['postUrl']= 'posts';
        return view('home',$data);
    }

}
