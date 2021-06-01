<?php

use DebugBar\StandardDebugBar;

// use DebugBar\DataCollector\ExceptionsCollector;
// ########### init error handler ##################
define('E_FATAL', E_ERROR | E_USER_ERROR | E_PARSE | E_CORE_ERROR |
        E_COMPILE_ERROR | E_RECOVERABLE_ERROR);

define('ENV', 'dev'); // or 'production'
// Custom error handling vars
define('DISPLAY_ERRORS', TRUE);
define('ERROR_REPORTING', E_ALL | E_STRICT);
define('LOG_ERRORS', TRUE);



const ERROR_CONSTANTS = [
    E_ERROR // 1 //
    => 'E_ERROR',
    E_WARNING // 2 //
    => 'E_WARNING',
    E_PARSE // 4 //
    => 'E_PARSE',
    E_NOTICE // 8 //
    => 'E_NOTICE',
    E_CORE_ERROR // 16 //
    => 'E_CORE_ERROR',
    E_CORE_WARNING // 32 //
    => 'E_CORE_WARNING',
    E_COMPILE_ERROR // 64 //
    => 'E_COMPILE_ERROR',
    E_COMPILE_WARNING // 128 //
    => 'E_COMPILE_WARNING',
    E_USER_ERROR // 256 //
    => 'E_USER_ERROR',
    E_USER_WARNING // 512 //
    => 'E_USER_WARNING',
    E_USER_NOTICE // 1024 //
    => 'E_USER_NOTICE',
    E_STRICT // 2048 //
    => 'E_STRICT',
    E_RECOVERABLE_ERROR // 4096 //
    => 'E_RECOVERABLE_ERROR',
    E_DEPRECATED // 8192 //
    => 'E_DEPRECATED',
    E_USER_DEPRECATED // 16384 //
    => 'E_USER_DEPRECATED',
];

class debug {

    private $debugBar = null;

    public function __construct($type = 'Normal') {
        if (is_callable([$this, "handler$type"])) {
            set_error_handler([&$this, "handler$type"]);
        } else {
            die("no method 'handler$type' in debug.class.php");
        }
        if (is_callable([$this, "shutdown$type"])) {
            register_shutdown_function([&$this, "shutdown$type"]);
        } else {
            die("no method 'shutdown$type' in debug.class.php");
        }
    }

    public function getDebugBar() {
        if ($this->debugBar === null) {
            // PHP DebugBar
            $this->debugBar = new StandardDebugBar();
            // $this->debugBar->addCollector(new ExceptionsCollector());
            $this->debugBar['messages']->addMessage("Init debugbar!");
        }
        return $this->debugBar;
    }

    public function getDebugJavascriptRenderer() {
        return $this->getDebugBar()->getJavascriptRenderer();
    }

    public function addDebugMessage($msg) {
        $this->getDebugBar()['messages']->addMessage($msg);
    }

    public function addDebugException(Exception $e) {
        $this->getDebugBar()['exceptions']->addException($e);
    }

    public function renderDebugBar() {
        foreach ($GLOBALS['loadingErrors'] as $msg) {
            $this->addDebugMessage($msg);
        }
        unset($GLOBALS['loadingErrors']);
        return $this->getDebugBar()->getJavascriptRenderer()->render();
    }

    // Function to catch no user error handler function errors...
    public function shutdownNormal() {
        $e = new Exception();
        $msg = ' -- shutdown function -- ' . str_replace('/var/www/html', '', $e->getTraceAsString());

        if (headers_sent($filename, $linenum)) {
            $msg .= "\nLes en-têtes ont déjà été envoyés, depuis le fichier $filename à la ligne $linenum\n";
        } else {
            $msg .= "\n -- no headers sent --\n";
        }

        $error = error_get_last();
        if ($error && ($error['type'] & E_FATAL)) {
            handler($error['type'], $error['message'], $error['file'], $error['line']);
        }
        if ($error) {
            $msg .= " -- no fatal error --\n";
        }
    }

    public static function FriendlyErrorType($type) {
        $return = "";
        foreach (ERROR_CONSTANTS as $key => $value) {
            if ($type & $key) {
                $return .= " & $value";
            }
        }
        return substr($return, 2);
    }

    public function handlerNormal($errno, $errstr, $errfile, $errline) {

        $typestr = self::FriendlyErrorType($errno);
        $message = "<b>$typestr: </b>$errstr in <b>$errfile</b> on line <b>$errline</b><br/>";

        if (($errno & E_FATAL) && ENV === 'production') {
            header('Location: 500.html');
            header('Status: 500 Internal Server Error');
        }

        if (!($errno & ERROR_REPORTING)) {
            return;
        }

        if (DISPLAY_ERRORS) {
            printf('%s', $message);
        }

        //Logging error on php file error log...
        if (LOG_ERRORS) {
            error_log(strip_tags($message), 0);
        }
    }

}
