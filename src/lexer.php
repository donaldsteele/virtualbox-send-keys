<?php

/**
 * Created by PhpStorm.
 * User: Don
 * Date: 4/20/2017
 * Time: 12:24 AM
 */

/***
 * Class lexer
 */
class lexer
{
    /***
     * @param $string
     * @return mixed
     */
    static function parse($string)
    {
        $returns = array(
            '\n',
            '\r\n',
            chr(10) . chr(13),
            '^RETURN',
        );

        $tabs = array(
            '\t',
            '^TAB',
        );

        $out = str_ireplace($returns, chr(10), $string);
        $out = str_ireplace($tabs, chr(9), $out);


        return $out;
    }

}