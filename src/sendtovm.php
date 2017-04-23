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


$kbScanCodes = new scanCodes();


function sendToVBOXwithDelay($vm, $codeArray)
{
    $cmd = 'vboxmanage controlvm %s keyboardputscancode %s' . PHP_EOL;

    foreach ($codeArray as $code) {
        shell_exec(sprintf($cmd, $vm, $code['FULL']));
        usleep(100000);
    }

}


if (array_key_exists('s', $arguments->Parsed)) {
    $codeArray = $kbScanCodes->getFromString($arguments->Parsed['s']);

} elseif (array_key_exists('s', $arguments->Parsed)) {

    $inputFile = $arguments->Parsed['f'];

    if (!file_exists($inputFile)) {
        throw new exception('unable to locate file ' . $inputFile);
    }
    $scriptContents = file_get_contents($inputFile);

    $codeArray = $kbScanCodes->getFromString($scriptContents);
} else {
    throw new exception('something terribly went wrong ');
}


sendToVBOXwithDelay($arguments->Parsed['v'], $codeArray);





