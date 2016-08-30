<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

use App\Http\Requests;

class IndexController extends Controller
{
    public function index()
    {
        $posts = Post::all();
        return view('home.index',compact('posts'));
    }
}
