<?php

use App\Services\UserService;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MyTest extends TestCase
{

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $user_id = 11;
        $user = \App\Entity\User::findOrFail($user_id);
        $userService = $this->app->make(UserService::class);

        $comment = $userService->getCommentsByUser($user,true);
        dd($comment->count());
    }
}
