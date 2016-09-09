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
    protected $user_id;

    protected function setUp()
    {
        parent::setUp();
        $this->artisan('db:seed');

        $this->user_id = 1;
        $this->userService = $this->app->make(UserService::class);
    }

    /**
     * @test
     */
    public function 按页查看发布的所有post()
    {
        $expected = DB::table('posts')
            ->where('user_id',$this->user_id)
            ->take(config('blog.user_center_posts_per_page'))
            ->get();

        $posts = $this->userService->getPostsByUserId($this->user_id,true);

        $this->assertEquals($expected->count(),$posts->count());
    }

    /**
     * @test
     */
    public function 按页查看发表的所有comment()
    {
        $expected = DB::table('comments')
            ->where('user_id',$this->user_id)
            ->take(config('blog.user_center_comments_per_page'))
            ->get();

        $posts = $this->userService->getCommentsByUserId($this->user_id,true);

        $this->assertEquals($expected->count(),$posts->count());
    }

    /**
     * @test
     */
    public function 查看最近N条post()
    {
        $expected = DB::table('posts')
            ->where('user_id',$this->user_id)
            ->take(config('blog.user_center_recent'))
            ->get();

        $posts = $this->userService->getPostsByUserId($this->user_id);

        $this->assertEquals($expected->count(),$posts->count());
    }

    /**
     * @test
     */
    public function 查看最近N条的comment()
    {
        $expected = DB::table('comments')
            ->where('user_id',$this->user_id)
            ->take(config('blog.user_center_recent'))
            ->get();

        $posts = $this->userService->getCommentsByUserId($this->user_id);

        $this->assertEquals($expected->count(),$posts->count());
    }

    /**
     * @test
     */
    public function 查看赞过的post()
    {
        factory(\App\Entity\Vote::class,20)->create([
            'user_id'       =>  $this->user_id,
            'voteable_type' =>  \App\Entity\Post::class,
        ]);

        factory(\App\Entity\Vote::class,10)->create([
            'user_id'       =>  $this->user_id,
            'voteable_type' =>  \App\Entity\Comment::class,
        ]);

        $expected = DB::table('votes')
            ->where('user_id',$this->user_id)
            ->where('voteable_type',\App\Entity\Post::class)
            ->get();

        $posts = $this->userService->getUserVotePost($this->user_id);

        $this->assertEquals($expected->count(),$posts->count());
    }
}
