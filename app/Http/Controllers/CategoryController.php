<?php

namespace App\Http\Controllers;

use App\Polly3d\PostListNav;
use App\Services\CategoryService;
use App\Services\PostShowService;
use App\Services\UserService;
use Illuminate\Http\Request;

use App\Http\Requests;

class CategoryController extends Controller
{
    public function posts(CategoryService $service, PostListNav $listNav, UserService $userService, PostShowService $postShowService, Request $request, $id)
    {
        $filter = PostShowService::ACTIVE;
        $inputFilter = $request->input('filter');
        if($inputFilter)
        {
            $filter = $inputFilter;
        }
        $postsLimit = config('blog.post_per_page');
        $posts = $service->getPostWithFilterById($id,$filter,$postsLimit);

        $nav = $listNav->createCategoryNav($id,$filter);

        $activeUsers = $userService->getActiveUsers(config('blog.active_user_number'));

        $hotPosts = $postShowService->getHotPosts(config('blog.hot_post'));
        return view('home.post.list',compact('posts','activeUsers','nav','hotPosts'));
    }
}
