<?php

/**
 * Created by PhpStorm.
 * User: Don
 * Date: 4/17/2017
 * Time: 6:21 PM
 */
require_once 'scancodes.php';
require_once 'lexer.php';
require_once 'argParser.php';

$arguments = new argParser($_SERVER["argv"]);


$scancodes = new scanCodes();


function sendToVBOXwithDelay($vm, $codeArray)
{
    $cmd = 'vboxmanage controlvm %s keyboardputscancode %s' . PHP_EOL;

    foreach ($codeArray as $code) {
        shell_exec(sprintf($cmd, $vm, $code['FULL']));
        usleep(100000);
    }

}


if (array_key_exists('s', $arguments->args)) {
    $codeArray = $scancodes->getFromString($arguments->args['s']);

    /* } elseif (array_key_exists('c', $arguments)) {
        TODO: beef this logic up to support more scripting
        $codeArray = $scancodes->getFromString($arguments['c']); */
} else {
    throw new exception('something terribly went wrong ');
}


sendToVBOXwithDelay($arguments->args['v'], $codeArray);





