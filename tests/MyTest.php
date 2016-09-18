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
        $mdParsedown = Parsedown::instance();
        $expected = '<pre><code>hello world</code></pre>';

        $str = <<<'MD'
```
hello world
```
MD;

        $actual = $mdParsedown->parse($str);

        $this->assertEquals($expected,$actual);
    }
}
