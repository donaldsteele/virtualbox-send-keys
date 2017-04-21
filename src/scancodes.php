<?php
/**
 * Created by PhpStorm.
 * User: Don
 * Date: 4/20/2017
 * Time: 12:18 AM
 */

require_once 'keys.php';


class scanCodes
{


    /*
     * Reference code https://github.com/pwnall/scancodes
     */


    /***
     * @param $str
     * @return array
     */
    static function getFromString($str)
    {
        $str = lexer::parse($str);
        $out = array();

        $strlen = strlen($str) - 1;
        for ($i = 0; $i <= $strlen; $i++) {
            $char = substr($str, $i, 1);
            $out[] = self::getKey(ord($char));
        }
        return $out;
    }

    /***
     * @param string $input single character in ascii format
     * @return array
     * @throws Exception
     */
    static function getKey($input)
    {
        //in case a user passes return instead of RETURN
        if (strlen($input) > 1) {
            $input = strtoupper($input);
        }

        $inLower = key_exists($input, keys::lower());
        $inUpper = key_exists($input, keys::upper());

        if ($inLower !== FALSE) {
            $decCode = keys::lower()[$input];
            $modShift = FALSE;

        } elseif ($inUpper !== FALSE) {
            // try and find our key in the control codes tables
            $decCode = keys::upper()[$input];
            $modShift = TRUE;

        } else {
            //couldnt find anything give up!

            throw new Exception('Unable to find key requested => ' . $input);
        }


        $key_down = self::keyDOWN($decCode, true);
        $key_up = self::keyUP($decCode, true);
        $shift_down = self::keyDOWN(keys::control()['LSHIFT'], true);
        $shift_up = self::keyUP(keys::control()['LSHIFT'], true);
        $out = array();
        $out['DOWN'] = sprintf('%02s', $key_down);
        $out['UP'] = sprintf('%02s', $key_up);
        $out['ShiftRequired'] = $modShift;
        if ($modShift == true) {
            $out['FULL'] = sprintf('%02s %02s %02s %02s', $shift_down, $key_down, $key_up, $shift_up);
        } else {
            $out['FULL'] = sprintf('%02s %02s', $key_down, $key_up);
        }
        return $out;
    }

    /**
     * @param int $decCode character code in decimal that needs to be converted
     * @param bool $asHex return the output as hexadecimal instead of decimal
     * @return string
     */
    static function keyDOWN($decCode, $asHex = false)
    {

        if ($asHex == false) {
            return $decCode;
        } else {
            return sprintf('%02s', dechex($decCode));
        }
    }

    /***
     * @param int $decCode character code in decimal that needs to be converted
     * @param bool $asHex return the output as hexadecimal instead of decimal
     * @return string*
     */
    static function keyUP($decCode, $asHex = false)
    {
        $decCode = $decCode + 0x80;
        if ($asHex == false) {
            return $decCode;
        } else {
            return sprintf('%02s', dechex($decCode));
        }
    }

    function getControlChar($char)
    {
        $out = array();
        $char = strtoupper($char);
        $out[] = self::getKey(ord($char));
        return $out;
    }

}
