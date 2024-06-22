<?php

if(DEBUG) {
    define('E_FATAL',  E_ERROR | E_USER_ERROR | E_PARSE | E_CORE_ERROR | E_COMPILE_ERROR | E_RECOVERABLE_ERROR);

    define('ENV', 'dev'); // or 'production'

    // Custom error handling vars
    define('DISPLAY_ERRORS', FALSE);
    define('ERROR_REPORTING', E_ALL | E_STRICT);
    define('LOG_ERRORS', TRUE);
} else {
    define('E_FATAL',  E_ERROR);

    define('ENV', 'production');

    // Custom error handling vars
    define('DISPLAY_ERRORS', FALSE);
    define('ERROR_REPORTING', E_ALL | E_STRICT);
    define('LOG_ERRORS', FALSE);

}

/**
 * this class handles all uncaught Exceptions / Errors / Warnings / Notices ...
 * according to the defined level
 * from https://stackoverflow.com/questions/277224/how-do-i-catch-a-php-fatal-e-error-error
 */
class errorHandler {

    /**
     * singleton
     */
    public static ?errorHandler $_instance = null;

    /**
     * keep errors and exceptions here for final rendering
     */
    private $_exceptions = [];
    private $_errors = [];

    public static function init() {
        if(self::$_instance == null) {
            $handler = new errorHandler();
            register_shutdown_function([$handler, 'shutdownHandler']);
            set_error_handler([$handler, 'errorHandler'], ERROR_REPORTING);
            set_exception_handler([$handler, 'exceptionHandler']);
            self::$_instance = $handler;    
        }
    }

    /**
     * flush and return an array with all errors and exceptions
     * @param string $_output = html | json | array
     * @return string|array formatted list of exceptions
     */
    public static function flush( $_output = 'html') {
        return (self::$_instance !== null ? self::$_instance->flushInst( $_output) : []);
    }

    public static function err2String( $errno, $errstr, $errfile, $errline, $trace = '', $_output = 'html') {

        switch ($errno) {

            case E_ERROR: // 1 //
                $typestr = 'E_ERROR'; break;
            case E_WARNING: // 2 //
                $typestr = 'E_WARNING'; break;
            case E_PARSE: // 4 //
                $typestr = 'E_PARSE'; break;
            case E_NOTICE: // 8 //
                $typestr = 'E_NOTICE'; break;
            case E_CORE_ERROR: // 16 //
                $typestr = 'E_CORE_ERROR'; break;
            case E_CORE_WARNING: // 32 //
                $typestr = 'E_CORE_WARNING'; break;
            case E_COMPILE_ERROR: // 64 //
                $typestr = 'E_COMPILE_ERROR'; break;
            case E_CORE_WARNING: // 128 //
                $typestr = 'E_COMPILE_WARNING'; break;
            case E_USER_ERROR: // 256 //
                $typestr = 'E_USER_ERROR'; break;
            case E_USER_WARNING: // 512 //
                $typestr = 'E_USER_WARNING'; break;
            case E_USER_NOTICE: // 1024 //
                $typestr = 'E_USER_NOTICE'; break;
            case E_STRICT: // 2048 //
                $typestr = 'E_STRICT'; break;
            case E_RECOVERABLE_ERROR: // 4096 //
                $typestr = 'E_RECOVERABLE_ERROR'; break;
            case E_DEPRECATED: // 8192 //
                $typestr = 'E_DEPRECATED'; break;
            case E_USER_DEPRECATED: // 16384 //
                $typestr = 'E_USER_DEPRECATED'; break;
        }

        if( $_output == 'json') {
            return json_encode( [
                'err' => sprintf('%s: %s  in %s on line %s', $typestr, $errstr, $errfile, $errline),
            ], JSON_UNESCAPED_UNICODE);
        } else { // html is the default return type
            return sprintf('<b>%s:</b> <i>%s</i> in <b>%s</b> on line <b>%s</b>%s'."\n",
              $typestr, $errstr, $errfile, $errline, print_r($trace, true));
       }
    }

    /**
     * display exception in HTML format into span
     * with expandable trace if DEBUG activated
     * @param exception|array $e
     * @return string html formatted exception
     */
    public static function displayHtmlException( $e) {
        if( is_a( $e, 'Exception')){
            $message = '<span id="span_errorMessage">' . $e->getMessage() . '</span>';
            if (DEBUG !== 0) {
                $id = rand(10, 99); // random id to avoid identical html id
                $message .= "<a class=\"pull-right bt_errorShowTrace cursor\" onclick=\"event.stopPropagation(); document.getElementById('pre_errorTrace{$id}').toggle()\">Show traces</a>";
                $message .= "<i class=\"pull-right fas fa-clipboard-check\" onclick=\"event.stopPropagation(); copyToClipboard('pre_errorTrace{$id}')\"></i>";
                $message .= sprintf('<br/><pre id="pre_errorTrace%s" style="display : none;">%s</pre>', $id, $e->getTraceAsString());
                $id++;
            }
        } else if( is_array($e)) { // should be an array :
            $message = '<span id="span_errorMessage">' . self::err2String( $e['type'], $e['message'], $e['file'], $e['line']) . '</span>';
            if (DEBUG !== 0) {
                $id = rand(10, 99); // random id to avoid identical html id
                $message .= "<a class=\"pull-right bt_errorShowTrace cursor\" onclick=\"event.stopPropagation(); document.getElementById('pre_errorTrace{$id}').toggle()\">Show traces</a>";
                $message .= "<i class=\"pull-right fas fa-clipboard-check\" onclick=\"event.stopPropagation(); copyToClipboard('pre_errorTrace{$id}')\"></i>";
                $message .= sprintf('<br/><pre id="pre_errorTrace%s" style="display : none;">%s</pre>', $id, self::displayHtmlDebugBacktrace( $e['trace']));
                $id++;
            }
        } else {
            die("errorHandler::displayHtmlException : unsupported type !" . print_r( $e, true));
        }

        return $message;
    }

    /**
     * HTML display of debug_backtrace() result
     * @param array $trace result of debug_backtrace
     * @return string HTML rendered stacktrace
     */
    public static function displayHtmlDebugBacktrace( $trace) {
        array_shift( $trace);
        foreach($trace as $i=>$call){
            /**
             * THIS IS NEEDED! If all your objects have a __toString function it's not needed!
             */
            if (isset( $call['object']) && is_object($call['object'])) {
                $call['object'] = sprintf('obj{%s}', get_class($call['object']));
            }
            if (is_array($call['args'])) {
                foreach ($call['args'] AS &$arg) {
                    if (is_object($arg)) {
                        $arg = sprintf( 'obj{%s}', get_class($arg));
                    }
                }
            }
            
            $trace_text[$i] = sprintf('#%s: %s:%s %s%s(%s)', $i, $call['file'] ?? 'no file', $call['line'] ?? '__', 
                ( !empty( $call['object']) ? $call['object'].$call['type'] : ''),
                $call['function'], json_encode($call['args']));
        }
        return implode("\n", $trace_text);
    }

    // instance methods

    public function exceptionHandler(Throwable $exception) {
        echo "Uncaught exception: " , $exception->getMessage(), "\n";
        // this should never happens /!\
        if((E_FATAL) && ENV === 'production'){
            header('Location: 500.html');
            header('Status: 500 Internal Server Error');
        }
        echo 'Exception Handler: ' . $exception->getTraceAsString();
        $this->_exceptions[] = $exception;
    }


    // Function to catch any remaining error after shutdown ...
    public function shutdownHandler() {
        $error = error_get_last();
        if($error && ($error['type'] & E_FATAL)){
            if(DISPLAY_ERRORS)
                echo "Shutdown with error: {$error['type']}, {$error['message']}, {$error['file']}, {$error['line']}\n";

            //Logging error on php file error log...
            if(LOG_ERRORS)
                error_log("Shutdown with error: {$error['type']}, {$error['message']}, {$error['file']}, {$error['line']}\n", 0);

            $this->errorHandler( $error['type'], $error['message'], $error['file'], $error['line']);
        }
        if(!empty($this->_errors)) {
            printf("shutdownHandler Errors : %s\n", count( $this->_errors));
            foreach( $this->_errors as $error) {
                echo self::err2String( $error['type'], $error['message'], $error['file'], $error['line'], $error['trace'] ?? '');
            }
        }
        if(!empty($this->_exceptions)) {
            printf("shutdownHandler Exceptions : %s\n", count( $this->_exceptions));
            foreach( $this->_exceptions as $ex) {
                // echo self::err2String( $ex->getCode(), $ex->getMessage(), $ex->getFile(), $ex->getLine(), $ex->getTraceAsString());
                echo self::displayHtmlException( $ex);
            }
        }
    }

    public function errorHandler( $errno, $errstr, $errfile, $errline ) {

        if(($errno & E_FATAL) && ENV === 'production'){
            header('Location: 500.html');
            header('Status: 500 Internal Server Error');
        }

        if(!($errno & ERROR_REPORTING))
            return;

        $this->_errors[] = [
            'type' => $errno,
            'message' => $errstr,
            'file' => $errfile,
            'line' => $errline,
            'trace' => debug_backtrace(),
        ];

        $message = self::err2String( $errno, $errstr, $errfile, $errline);
        if(DISPLAY_ERRORS)
            printf('(errorHandler): %s', $message);

        //Logging error on php file error log...
        if(LOG_ERRORS)
            error_log('(log_errors):' . strip_tags($message), 0);
    }

    /**
     * flush current instance
     * @param string $_output = html | json | array
     * @return string|array formatted errors
     */
    private function flushInst( $_output) {
        $_result = [];
        if( $_output == 'array') {
            if(!empty( $this->_errors)) {
                $_result['errors'] = $this->_errors;
            }
            if(!empty( $this->_exceptions)) {
                $_result['exceptions'] = $this->_exceptions;
            }
        } else { // json or html
            $_result = [];
            if(!empty($this->_errors)) {
                foreach( $this->_errors as $error) {
                    $_result[] = self::err2String( $error['type'], $error['message'], $error['file'], $error['line'], $error['trace'] ?? '', $_output);
                }
            }
            if(!empty($this->_exceptions)) {
                foreach( $this->_exceptions as $ex) {
                    $_result[] = self::err2String( $ex->getCode(), $ex->getMessage(), $ex->getFile(), $ex->getLine(), $ex->getTraceAsString(), $_output);
                }
            }
        }
        // flush and return computed result
        $this->_errors = [];
        $this->_exceptions = [];
        if( $_output == 'html')
            return 'flush html --- ' . implode( "\n", $_result);
        if($_output == 'json')
            return 'flush json --- ' . implode( ",\n", $_result);
        // array is the default output
        return $_result;
    }

}