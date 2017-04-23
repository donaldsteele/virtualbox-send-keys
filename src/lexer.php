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
     * @var string[] list of positions that we should pause / wait at
     */
    public static $wait;


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
        $out = self::findScriptTerms($out);

        return $out;
    }


    static private function findScriptTerms($string)
    {

        //only support the wait function for now, will expand this more at a later date
        $re = '/\^WAIT\[([0-9]+)\]/i';

        // get positions of command
        if (preg_match_all($re, $string, $matches, PREG_OFFSET_CAPTURE)) {
            // Print the entire match result
            // now that we have the positions recorded we can remove them from our input string.
            $out = preg_replace($re, '', $string);

            foreach ($matches[0] as $matchToken => $matchDetails) {

                $watchStart = $matchDetails[1];
                // look in the second array [1] and get the corrisponding value inside our regex () match in this case the number passed to ^WAIT
                $watchValue = $matches[1][$matchToken][0];
                self::$wait[$watchStart] = $watchValue;
            }

        } else {
            $out = $string;
        }


        return $out;
    }
}