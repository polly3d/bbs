<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserCenterTest extends TestCase
{
    protected $user;

    protected function setUp()
    {
        parent::setUp();
        $this->user = \App\Entity\User::findOrFail(1);
    }

    /**
     * @test
     */
    public function 查看用户中心首页()
    {
        $this->visit(route('user.show',$this->user->id))
            ->see($this->user->name);
    }

    /**
     * @test
     */
    public function 查看用户发表的所有帖子带分页()
    {
        $this->visit(route('userPosts',$this->user->id))
            ->see('page');
    }

    /**
     * @test
     */
    public function 分页查看用户所有回复()
    {
        $this->visit(route('userComments',$this->user->id))
            ->see('page');
    }

    /**
     * @test
     */
    public function 分布查看用户所有的点赞帖子()
    {
        $this->visit(route('userVotePosts',$this->user->id))
            ->see('page');
    }
}
