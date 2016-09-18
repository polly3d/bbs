<?php
/**
 * Created by PhpStorm.
 * User: Wang
 * Date: 2016/9/18
 * Time: 11:06
 */

namespace App\Polly3d;


class MarkdownParser
{
    /**
     * 将md转化为HTML
     * @param $value string
     * @return string
     */
    public static function text($value)
    {
        $parser = \Parsedown::instance();
        return $parser->text($value);
    }
}