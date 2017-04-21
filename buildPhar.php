<?php

/**
 * Created by PhpStorm.
 * User: Don
 * Date: 4/20/2017
 * Time: 12:44 AM
 */
class PharBuilder
{

    var $pharfile;      // File name of the PHAR.
    var $startfile;     // File to start the program
    var $basedir;       // Base directory of the source tree.
    var $phar;          // Phar object
    var $excludePrefixes = array(); // File prefixes to exclude from PHAR
    var $excludeSuffixes = array(); // File suffixes to exclude from PHAR

    var $squash = 'stripWhitespace';

    function __construct($filename, $startup, $basedir)
    {
        $this->pharfile = $filename;
        $this->startfile = $startup;
        $this->basedir = $basedir;
    }

    public function addExcludePrefix($prefix)
    {
        array_push($this->excludePrefixes, $prefix);
    }

    public function addExcludeSuffix($suffix)
    {
        array_push($this->excludeSuffixes, $suffix);
    }

    public function compile()
    {

        @unlink($this->pharfile);
        $this->phar = new \Phar($this->pharfile);

        $fileIter = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($this->basedir, \FileSystemIterator::SKIP_DOTS));

        $files = iterator_to_array($fileIter);

        foreach ($this->excludePrefixes as $prefix) {
            $files = $this->prunePrefix($files, $this->basedir . $prefix);
        }

        foreach ($this->excludeSuffixes as $suffix) {
            $files = $this->pruneSuffix($files, $suffix);
        }

        $this->phar->startBuffering();

        foreach ($files as $file) {
            $name = substr($file, strlen($this->basedir) + 1);
            print_r("Adding $name ...");
            if (substr($file, -3) === 'php') {
                $this->phar[$name] = $this->{$this->squash}(file_get_contents($file));
            } else {
                $this->phar[$name] = file_get_contents($file);
            }
        }

        $this->addGITinfo();
        $this->addStub();
        $this->phar->stopBuffering();
        $this->phar->compressFiles(Phar::GZ);
        $this->setExecutableBit();
    }

    public function prunePrefix($files, $prefix)
    {
        $newlist = array();
        $prefix_len = strlen($prefix);
        foreach ($files as $file => $data) {
            if (substr($file, 0, $prefix_len) !== $prefix) {
                $newlist[$file] = $data;
            }
        }
        return $newlist;
    }

    // This is from the composer source. Handy!
    // Se mantiene el código fuente de los números de línea.

    public function pruneSuffix($files, $suffix)
    {
        $newlist = array();
        $suffix_len = strlen($suffix);
        foreach ($files as $file => $data) {
            if (substr($file, -$suffix_len) !== $suffix) {
                $newlist[$file] = $data;
            }
        }
        return $newlist;
    }

    private function addGITinfo()
    {
        $this->phar['compiled.php'] = "<?php return array( 'date' => '"
            . date('Y-m-d H:i')
            . "', 'git'  => '"
            . exec("git -C {$this->basedir} describe --tags 2>&1") . "',);";
    }

    private function addStub()
    {
        $defaultStub = $this->phar->createDefaultStub($this->startfile);
        $stub = "#!/usr/bin/php -q\n" . $defaultStub;

        $this->phar->setStub($stub);
    }

    private function setExecutableBit()
    {
        system("chmod +x {$this->pharfile}");
    }

    private function stripWhitespace($source)
    {
        $output = '';
        foreach (token_get_all($source) as $token) {
            if (is_string($token)) {
                $output .= $token;
            } elseif (in_array($token[0], array(T_COMMENT, T_DOC_COMMENT))) {
                // Replace comments with the just the newlines, to
                // keep the source line numbers the same.
                $output .= str_repeat("\n", substr_count($token[1], "\n"));
            } elseif (T_WHITESPACE === $token[0]) {
                // reduce wide spaces
                $whitespace = preg_replace('{[ \t]+}', ' ', $token[1]);
                // normalize newlines to \n
                $whitespace = preg_replace('{(?:\r\n|\r|\n)}', "\n", $whitespace);
                // trim leading spaces
                $whitespace = preg_replace('{\n +}', "\n", $whitespace);
                $output .= $whitespace;
            } else {
                $output .= $token[1];
            }
        }
        return $output;
    }

    private function stripWhitespaceAgressive($source)
    {
        $output = '';
        foreach (token_get_all($source) as $token) {
            if (is_string($token)) {
                $output .= $token;
            } elseif (in_array($token[0], array(T_COMMENT, T_DOC_COMMENT))) {
                // No comments at all
            } elseif (T_WHITESPACE === $token[0]) {
                $output .= ' ';
            } else {
                $output .= $token[1];
            }
        }
        return $output;
    }

    private function nostrip($source)
    {
        return $source;
    }
}

;


$pb = new PharBuilder('vsk.phar', 'sendtovm.php', './src');
$pb->addExcludePrefix('/.idea');
$pb->addExcludePrefix('/.git');
$pb->addExcludePrefix('/composer');
$pb->addExcludePrefix('/build.php');
$pb->addExcludeSuffix('~');
$pb->compile();
rename('vsk.phar', './bin/vsk');
