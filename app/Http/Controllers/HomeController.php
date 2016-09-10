<?php

namespace App\Http\Controllers;

use App\Services\PostShowService;
use Illuminate\Http\Request;

use App\Http\Requests;

class HomeController extends Controller
{
    public function index(PostShowService $service)
    {
        $limit = config('blog.post_per_page');
        $excellentPosts = $service->getFilterHasPaginate(PostShowService::EXCELLENT,$limit);
        return view('home.index',['posts' => $excellentPosts]);
    }
}
