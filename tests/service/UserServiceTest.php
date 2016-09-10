<?php

use App\Services\UserService;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserServiceTest extends TestCase
{
    use DatabaseMigrations;

    /** @var  UserService */
    protected $userService;
    protected $user;

    protected function setUp()
    {
        parent::setUp();
        $this->artisan('db:seed');

        $this->user = \App\Entity\User::findOrFail(1);
        $this->userService = $this->app->make(UserService::class);
    }

    /**
     * @test
     */
    public function 按页查看发布的所有post()
    {
        $expected = DB::table('posts')
            ->where('user_id',$this->user->id)
            ->take(config('blog.user_center_posts_per_page'))
            ->get();

        $posts = $this->userService->getPostsByUser($this->user,true);

        $this->assertEquals($expected->count(),$posts->count());
    }

    /**
     * @test
     */
    public function 按页查看发表的所有comment()
    {
        $expected = DB::table('comments')
            ->where('user_id',$this->user->id)
            ->take(config('blog.user_center_comments_per_page'))
            ->get();

        $posts = $this->userService->getCommentsByUser($this->user,true);

        $this->assertEquals($expected->count(),$posts->count());
    }

    /**
     * @test
     */
    public function 查看最近N条post()
    {
        $expected = DB::table('posts')
            ->where('user_id',$this->user->id)
            ->take(config('blog.user_center_recent'))
            ->get();

        $posts = $this->userService->getPostsByUser($this->user);

        $this->assertEquals($expected->count(),$posts->count());
    }

    /**
     * @test
     */
    public function 查看最近N条的comment()
    {
        $expected = DB::table('comments')
            ->where('user_id',$this->user->id)
            ->take(config('blog.user_center_recent'))
            ->get();

        $posts = $this->userService->getCommentsByUser($this->user);

        $this->assertEquals($expected->count(),$posts->count());
    }

    /**
     * @test
     */
    public function 查看赞过的post()
    {
        factory(\App\Entity\Vote::class,20)->create([
            'user_id'       =>  $this->user->id,
            'voteable_type' =>  \App\Entity\Post::class,
        ]);

        factory(\App\Entity\Vote::class,10)->create([
            'user_id'       =>  $this->user->id,
            'voteable_type' =>  \App\Entity\Comment::class,
        ]);

        $expected = DB::table('votes')
            ->where('user_id',$this->user->id)
            ->where('voteable_type',\App\Entity\Post::class)
            ->get();

        $posts = $this->userService->getVotePostByUser($this->user);

        $this->assertEquals($expected->count(),$posts->count());
    }

    /**
     * @test
     */
    public function 活跃用户()
    {
        $limit = config('blog.active_user_number');

        //发贴最多的人 and 回复最多的人
        $usersByCreatePost = \App\Entity\User::withCount('posts')
            ->withCount('comments')
            ->get();

        foreach($usersByCreatePost as &$user)
        {
            $user->active_count = $user->comments_count + $user->posts_count * 4;
        }

        $expected = $usersByCreatePost->sortByDesc('active_count')
            ->take($limit);

        $actual = $this->userService->getActiveUsers($limit);

        $this->assertArraySubset($expected->toArray(),$actual->toArray());
    }
}
