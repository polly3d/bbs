<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

use App\Http\Requests;

class IndexController extends Controller
{
    public function index()
    {
        $posts = Post::paginate(config('blog.post_per_page'));
        return view('home.index',compact('posts'));
    }
}
