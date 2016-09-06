<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new \App\User();
        $user->name = "wang";
        $user->email = "wang@wang.com";
        $user->password = bcrypt('123456');
        $user->save();

        factory(\App\User::class,10)->create();
    }
}
