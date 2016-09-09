<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MyTest extends TestCase
{
    use DatabaseMigrations;

    protected $user_id;

    protected function setUp()
    {
        parent::setUp();
        $this->artisan('db:seed');

        $this->user_id = 1;
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        factory(\App\Entity\Vote::class,20)->create([
            'user_id'       =>  $this->user_id,
            'voteable_type' =>  \App\Entity\Post::class,
        ]);

        factory(\App\Entity\Vote::class,10)->create([
            'user_id'       =>  $this->user_id,
            'voteable_type' =>  \App\Entity\Comment::class,
        ]);

        $user = \App\Entity\User::find($this->user_id);
        $data = $user->votePosts()->count();
        var_dump($data);
    }
}
