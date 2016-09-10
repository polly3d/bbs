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
        $user = new \App\Entity\User();
        $user->name = "wang";
        $user->email = "1@1.com";
        $user->password = bcrypt('123456');
        $user->save();

        factory(\App\Entity\User::class,10)->create();
    }
}
