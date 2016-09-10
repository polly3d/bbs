<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserCenterTest extends TestCase
{
    /**
     * @test
     */
    public function 查看用户中心首页()
    {
        $user = \App\Entity\User::findOrFail(1);

        $this->visit(route('user.show',$user->id))
            ->see($user->name);
    }
}
