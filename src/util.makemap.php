<?php
/**
 * Created by PhpStorm.
 * User: Don
 * Date: 4/17/2017
 * Time: 6:21 PM
 */

/*
 * Reference code https://github.com/pwnall/scancodes
 */


// Unshifted codes.
$baseCodes = array(
    "Error",
    "Esc", "1", "2", "3", "4", "5", "6", "7", "8", "9", "0", "-", "=", chr(8),
    chr(9), "q", "w", "e", "r", "t", "y", "u", "i", "o", "p", "[", "]",
    chr(10),
    "LCtrl",
    "a", "s", "d", "f", "g", "h", "j", "k", "l", ";", "'",
    "`",
    "LShift", "\\",
    "z", "x", "c", "v", "b", "n", "m", ",", ".", "/", "RShift",
    "Keypad_*",
    "LAlt", chr(32),
    "CapsLock",
    "F1", "F2", "F3", "F4", "F5", "F6", "F7", "F8", "F9", "F10",
    "NumLock", "ScrollLock",
    "Keypad_7", "Keypad_8", "Keypad_9",
    "Keypad_-",
    "Keypad_4", "Keypad_5", "Keypad_6", "Keypad_Plus",
    "Keypad_1", "Keypad_2", "Keypad_3",
    "Keypad_0", "Keypad-.",
    "Alt_SysRq",
);


// Shifted codes.
// NOTE: Uppercase letters are special-cased in code. They're only here because
//       they help us align the other keys.
$shiftCodes = array(
    "",
    "", "!", "@", "#", "$", "%", "^", "&", "*", "(", ")", "_", "+", "",
    "", "Q", "W", "E", "R", "T", "Y", "U", "I", "O", "P", "{", "}",
    "",
    "",
    "A", "S", "D", "F", "G", "H", "J", "K", "L", ":", "'",
    "~",
    "", "|",
    "Z", "X", "C", "V", "B", "N", "M", "<", ">", "?", "",
    "PrintScreen",
    "", "",
    "",
    "", "", "", "", "", "", "", "", "", "",
    "", "",
    "", "", "",
    "",
    "", "", "", "",
    "", "", "",
    "", "",
    "",
);


$numLockCodes = array(
    "",
    "", "", "", "", "", "", "", "", "", "", "", "", "", "",
    "", "", "", "", "", "", "", "", "", "", "", "", "",
    "",
    "",
    "", "", "", "", "", "", "", "", "", "", "",
    "",
    "", "",
    "", "", "", "", "", "", "", "", "", "", "",
    "",
    "", "",
    "",
    "", "", "", "", "", "", "", "", "", "",
    "", "",
    "Home", "Up", "PageUp",
    "",
    "Left", "", "Right", "",
    "End", "Down", "PageDown",
    "Ins", "Del",
    "",
);


$chars = array();
$controlchars = array();

// process lower case chars
foreach ($baseCodes as $key => $value) {
    // skip if blank
    if ($value != '' && strlen($value) == 1) {
        $chars[ord($value)] = $key . ' // ' . $value;
    } elseif ($value != '' && strlen($value) > 1) {
        $controlchars[strtoupper($value)] = $key;
    }
}

// process shift chars
foreach ($shiftCodes as $key => $value) {
    // skip if blank
    if ($value != '' && strlen($value) == 1) {
        $shiftchars[ord($value)] = $key . ' // ' . $value;
    } elseif ($value != '' && strlen($value) > 1) {
        if (!array_key_exists(strtoupper($value), $controlchars)) {
            $controlchars[strtoupper($value)] = $key;
        }
    }
}


ksort($chars);
ksort($shiftchars);
ksort($controlchars);
echo '$lower = ';
var_export($chars);
echo ';' . PHP_EOL;
echo '$upper = ';
var_export($shiftchars);
echo ';' . PHP_EOL;
echo '$control = ';
var_export($controlchars);
echo ';' . PHP_EOL;
//var_export($controlchars);
