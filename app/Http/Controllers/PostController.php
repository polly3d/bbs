<?php

namespace App\Http\Controllers;

use App\Entity\Category;
use App\Polly3d\PostListNav;
use App\Services\PostOperationService;
use App\Services\PostShowService;
use App\Services\UserService;
use Illuminate\Http\Request;

use App\Http\Requests;

class PostController extends Controller
{
    /**
     * PostController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth')->except('index','show');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,PostShowService $service,UserService $userService,PostListNav $listNav)
    {
        $filter = PostShowService::ACTIVE;
        $inputFilter = $request->input('filter');
        if($inputFilter)
        {
            $filter = $inputFilter;
        }

        $limit = config('blog.post_per_page');
        $posts = $service->getFilterHasPaginate($filter,$limit);

        $nav = $listNav->createNav($filter);

        $activeUsers = $userService->getActiveUsers(config('blog.active_user_number'));

        $hotPosts = $service->getHotPosts(config('blog.hot_post'));
        return view('home.post.list',compact('posts','activeUsers','nav','hotPosts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('home.post.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, PostOperationService $service)
    {
        $rule = [
            'title' => 'required|max:255',
            'category_id' => 'required',
            'content_md' => 'required',
        ];
        $message = [
            'title.required' => '标题必须填写',
            'title.max' => '标题过长',
            'category_id.required' => '请选择分类',
            'content_md.required' => '内容不能不空',
        ];
        $this->validate($request,$rule,$message);

        $post = $service->createPost($request->only('title','category_id','content_md'));
        return redirect(route('post.create'))
            ->withSuccess('创建成功');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(PostShowService $service,$id)
    {
        $data = $service->getById($id);
        return view('home.post.show',$data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
