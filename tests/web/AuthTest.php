<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Auth;
use App\User;

class AuthTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function 注册()
    {
        $userData = [
            'name'      =>  'wang',
            'email'     =>  'wang@wang.com',
            'password'  =>  '123456',
            'password_confirmation' =>  '123456',//容易忘记写这个
        ];

        $this->visit('/register')
            ->submitForm('Register',$userData)
            ->seeCredentials($userData)
            ->seePageIs('/')
            ->seeIsAuthenticated();
    }

    /**
     * @test
     */
    public function 登陆()
    {
        $userData = [
            'email'     =>  'wang@wang.com',
            'password'  =>  '123456',
        ];
        $user = factory(User::class)->create([
            'email' => $userData['email'],
            'password'  => bcrypt($userData['password']),
        ]);

        $this->visit('/login')
            ->submitForm('Login',$userData)
            ->seeCredentials($userData)
            ->seePageIs('/')
            ->seeIsAuthenticated();
    }

    /**
     * 由于前台logout采用js提交，暂时就不理了
     */
    public function 退出登陆()
    {
        $userData = [
            'email'     =>  'wang@wang.com',
            'password'  =>  '123456',
        ];
        $user = factory(User::class)->create([
            'email' => $userData['email'],
            'password'  => bcrypt($userData['password']),
        ]);

        $this->visit('/login')
            ->submitForm('Login',$userData)
            ->seePageIs('/')
            ->seeIsAuthenticated();

        $this->visit('/')
            ->submitForm('logout-form');

        $this->dontSeeIsAuthenticated();
    }
}
