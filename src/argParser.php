<?php

/**
 * Created by PhpStorm.
 * User: don
 * Date: 4/20/2017
 * Time: 3:45 PM
 */

/***
 * Class argParser
 */
class argParser
{

    public $Parsed;


    function __construct($my_arg = null)
    {

        $this->Parsed = $this->parseArguments($my_arg);

        if (array_key_exists('?', $this->Parsed) ||
            array_key_exists('help', $this->Parsed) ||
            array_key_exists('v', $this->Parsed) === FALSE ||
            array_key_exists('s', $this->Parsed) === FALSE
        ) {
            $this->print_help();
            exit;
        }
    }

    /***
     * @param null $my_arg
     * @return array
     */
    function parseArguments($my_arg = null)
    {
        $cmd_args = array();
        $skip = array();

        global $argv;
        $new_argv = is_null($my_arg) ? $argv : $my_arg;

        if (is_null($my_arg)) {
            array_shift($new_argv); // skip arg 0 which is the filename
        }

        foreach ($new_argv as $idx => $arg) {
            if (in_array($idx, $skip)) {
                continue;
            }

            $arg = preg_replace('#\s*\=\s*#si', '=', $arg);
            $arg = preg_replace('#(--+[\w-]+)\s+[^=]#si', '${1}=', $arg);

            if (substr($arg, 0, 2) == '--') {
                $eqPos = strpos($arg, '=');

                if ($eqPos === false) {
                    $key = trim($arg, '- ');
                    $val = isset($cmd_args[$key]);

                    // We handle case: --user-id 123 -> this is a long option with a value passed.
                    // the actual value comes as the next element from the array.
                    // We check if the next element from the array is not an option.
                    if (isset($new_argv[$idx + 1]) && !preg_match('#^-#si', $new_argv[$idx + 1])) {
                        $cmd_args[$key] = trim($new_argv[$idx + 1]);
                        $skip[] = $idx;
                        $skip[] = $idx + 1;
                        continue;
                    }

                    $cmd_args[$key] = $val;
                } else {
                    $key = substr($arg, 2, $eqPos - 2);
                    $cmd_args[$key] = substr($arg, $eqPos + 1);
                }
            } else if (substr($arg, 0, 1) == '-') {
                if (substr($arg, 2, 1) == '=') {
                    $key = substr($arg, 1, 1);
                    $cmd_args[$key] = substr($arg, 3);
                } else {
                    $chars = str_split(substr($arg, 1));

                    foreach ($chars as $char) {
                        $key = $char;
                        $cmd_args[$key] = isset($cmd_args[$key]) ? $cmd_args[$key] : true;
                    }
                }
            } else {
                $cmd_args[] = $arg;
            }
        }

        return $cmd_args;
    }

    /***
     *
     */
    function print_help()
    {

        $this->display_message('====================================================');
        $this->display_message($this->Parsed[0] . ' Help');
        $this->display_message('-v        Name of the vm to send to');
        $this->display_message('-s        quoted string to send to vm');
        $this->display_message('-f        use file as string to send to vm');
        $this->display_message('');
        $this->display_message('Available control characters:');
        $this->display_message('^RETURN \n ^TAB \t');
        $this->display_message('');
        $this->display_message('Example: (login and download a file)');
        $this->display_message($this->Parsed[0] . ' -v="myVM" -s=\'root\nmypass\n\'');
        $this->display_message($this->Parsed[0] . ' -v="myVM" -s=\'wget http://www.somedomain.com/myfile.tar.gz\n\'');
        $this->display_message('');


    }

    /***
     * @param $str
     */
    function display_message($str)
    {
        print $str . PHP_EOL;
    }


}