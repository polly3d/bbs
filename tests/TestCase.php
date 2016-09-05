<?php

abstract class TestCase extends Illuminate\Foundation\Testing\TestCase
{
    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://localhost';

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

        return $app;
    }

    /**
     * @return \App\User
     */
    protected function getUser($username = 'wang@wang.com', $password = '123456')
    {
        $userData = [
            'email'     =>  $username,
            'password'  =>  $password,
        ];

        $user = factory(\App\User::class)->create([
            'email' => $userData['email'],
            'password'  => bcrypt($userData['password']),
        ]);
        return $user;
    }
}
