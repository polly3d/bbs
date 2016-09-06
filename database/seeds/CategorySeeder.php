<?php

use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categoryData = [
            ['name'  =>  '招聘'],
            ['name'  =>  '问题'],
            ['name'  =>  '分享'],
            ['name'  =>  '教程'],
        ];
        DB::table('categories')->insert($categoryData);
    }
}
