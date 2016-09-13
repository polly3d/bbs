<?php

namespace App\Http\Controllers;

use App\Entity\Category;
use App\Polly3d\PostListNav;
use App\Services\CategoryService;
use App\Services\PostOperationService;
use App\Services\PostShowService;
use App\Services\UserService;
use Illuminate\Http\Request;

use App\Http\Requests;
use Auth;

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
        $this->validePost($request);

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
    public function show(PostShowService $service, CategoryService $categoryService,$id)
    {
        $post = $service->getById($id);
        $categoryPosts = $categoryService->getPostById($post->category_id);
        return view('home.post.show',compact('post','categoryPosts'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(PostShowService $service,$id)
    {
        $post = $service->getByIdOnlyPost($id);
        $data = $post->toArray();
        $data['categories'] = Category::all();
        return view('home.post.update',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PostOperationService $service,Request $request, $id)
    {
        $this->validePost($request);
        $service->updatePost($id,$request->only('title','category_id','content_md'));
        return redirect(route('post.edit',$id))
            ->withSuccess('修改成功');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(PostOperationService $service, $id)
    {
        $result = $service->deletePost($id);
        return redirect(route('post.index'))
            ->withSuccess('删除成功');
    }

    /**
     * 将帖子设为精华
     * @param $id
     */
    public function toExcellent(PostOperationService $service, $id)
    {
        if(Auth::id() !== 1)
        {
            return redirect('/');
        }

        $post = $service->toExcellent($id);
        return redirect(route('post.show',$id))
            ->withSuccess('设置成功');

    }

    protected function validePost(Request $request)
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
    }
}
