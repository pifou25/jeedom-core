<?php

if(DEBUG) {
    define('E_FATAL',  E_ERROR | E_USER_ERROR | E_PARSE | E_CORE_ERROR | E_COMPILE_ERROR | E_RECOVERABLE_ERROR);

    define('ENV', 'dev');

    // Custom error handling vars
    define('DISPLAY_ERRORS', TRUE);
    define('ERROR_REPORTING', E_ALL | E_STRICT);
    define('LOG_ERRORS', TRUE);
} else {
    define('E_FATAL',  E_ERROR);

    define('ENV', 'production');

    // Custom error handling vars
    define('DISPLAY_ERRORS', FALSE);
    define('ERROR_REPORTING', E_ALL | E_STRICT);
    define('LOG_ERRORS', TRUE);

}

/**
 * this class handles all uncaught Exceptions / Errors / Warnings / Notices ...
 * according to the defined level
 */
class ErrorHandler {

    /**
     * singleton
     */
    public static ?ErrorHandler $_instance = null;

    private static $_EXCEPTIONS = [
        E_ERROR => "E_ERROR",      // 1
        E_WARNING => "E_WARNING",  // 2
        E_PARSE => "E_PARSE",      // 4
        E_NOTICE => "E_NOTICE",    // 8
        E_CORE_ERROR => "E_CORE_ERROR",      // 16
        E_CORE_WARNING => "E_CORE_WARNING",  // 32
        E_COMPILE_ERROR => "E_COMPILE_ERROR",// 64
        E_COMPILE_WARNING => "E_COMPILE_WARNING", // 128
        E_USER_ERROR => "E_USER_ERROR",     // 256
        E_USER_WARNING => "E_USER_WARNING", // 512
        E_USER_NOTICE => "E_USER_NOTICE",   // 1024
        E_STRICT => "E_STRICT",   // 2048
        E_RECOVERABLE_ERROR => "E_RECOVERABLE_ERROR", // 4096
        E_DEPRECATED => "E_DEPRECATED", // 8192
        E_USER_DEPRECATED => "E_USER_DEPRECATED", // 16384
        E_ALL => "E_ALL" // 32767
    ];

    /**
     * register error handler, exception handler, and shutdown handler
     * @param $_scope = html | ajax | json | console = type of error rendering
     */
    public static function init( $_scope = 'html') {
        if(self::$_instance === null) {
            $handler = new ErrorHandler( $_scope);
            register_shutdown_function([$handler, 'shutdownHandler']);
            set_error_handler([$handler, 'ErrorHandler'], ERROR_REPORTING);
            set_exception_handler([$handler, 'exceptionHandler']);
            self::$_instance = $handler;    
        } else {
            die( 'ErrorHandler already initialized !');
        }
    }

    /**
     * flush and return an array with all errors and exceptions
     * @param string $_output = html | json | array
     * @return string|array formatted list of exceptions
     */
    public static function flush( $_output = null) {
        return (self::$_instance !== null ? self::$_instance->flushInst( $_output) : []);
    }

    /**
     * render error into text formatted string
     * @param array $error : array with keys:
     *  type : type of error
     *  message : error description
     *  file : name where occurs error
     *  line : where occurs error
     *  trace : optional stacktrace from debug_backtrace()
     * @param string $_output = html| json | console
     */
    public static function renderError( $error, $_output = 'html') {

        $typestr = self::$_EXCEPTIONS[$error['type']];
        $backtrace = !empty( $error['trace']) ? self::displayDebugBacktrace( $error['trace']) . "\n" : '';
        if( $_output == 'json') {
            return json_encode( [
                'err' => sprintf("%s: %s  in %s on line %s\n%s", $typestr, $error['message'], $error['file'], $error['line'], $backtrace),
            ], JSON_UNESCAPED_UNICODE);
        }else if( $_output == 'console') {
            return sprintf("%s: %s  in %s on line %s\n%s", $typestr, $error['message'], $error['file'], $error['line'], $backtrace);
        } else { // html is the default return type
            return sprintf('<b>%s:</b> <i>%s</i> in <b>%s</b> on line <b>%s</b>%s'."\n",
              $typestr, $error['message'], $error['file'], $error['line'], $backtrace);
       }
    }

    /**
     * display exception in HTML format into span
     * with expandable trace if DEBUG activated
     * @param exception|array $e
     * @param string $_ouput = html | console ... TODO manage other outputs (json array ajax)
     * @return string html formatted exception
     */
    public static function renderException( $e, $_output = 'html') {
        if( is_a( $e, 'Throwable')){
            $message = '<span id="span_errorMessage">' . $e->getMessage() . '</span>';
        } else if( is_array($e)) { // should be an array :
            $message = '<span id="span_errorMessage">' . self::renderError( $e, $_output) . '</span>';
        } else {
            die("ErrorHandler::renderException : unsupported type !" . get_class( $e) . " --- <br/>" . print_r( $e, true));
        }

        if (DEBUG !== 0) {
            if( is_a( $e, 'Throwable')){
                $trace = $e->getTraceAsString();
            } else {
                $trace = empty($e['trace']) ? '' : self::displayDebugBacktrace( $e['trace']);
            }

            $id = rand(10, 99); // random id to avoid identical html id
            $message .= "<a class=\"pull-right bt_errorShowTrace cursor\" onclick=\"event.stopPropagation(); document.getElementById('pre_errorTrace{$id}').toggle()\">Show traces</a>";
            $message .= "<i class=\"pull-right fas fa-clipboard-check\" onclick=\"event.stopPropagation(); copyToClipboard('pre_errorTrace{$id}')\"></i>";
            $message .= sprintf('<br/><pre id="pre_errorTrace%s" style="display : none;">%s</pre>', $id, $trace);
            $id++;
        }
        if ($_output === 'html') {
            return $message;
        } else {
            return strip_tags( $message);
        }
    }

    /**
     * HTML display of debug_backtrace() result
     * @param array $trace result of debug_backtrace
     * @return string HTML rendered stacktrace
     */
    public static function displayDebugBacktrace( $trace) {
        array_shift( $trace); // remove the first error line
        foreach($trace as $i => $call){
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

    /**
     * log error or exception to system log if required
     * @param Throwable $e : any throwable error or exception 
     */
    public static function systemLog( $e) {
        if(LOG_ERRORS) {
            if( is_a( $e, 'Throwable')){
                error_log( "Error: " . $e->getMessage() . (DEBUG ? "\n" . $e->getTraceAsString() : ''), 0);
            } else if( is_array($e)) { // should be an array :
                error_log( self::renderError( $e, 'console'), 0);
            } else {
                error_log( "ErrorHandler::systemLog: unsupported type ! " . get_class( $e) . "\n" . print_r( $e, true), 0);
            }
        }
    }

    // instance methods
    
    /**
     * keep errors and exceptions here for final rendering
     */
    private $_exceptions = [];
    private $_errors = [];
    private $_scope = null;

    public function __construct( $scope) {
        $this->_scope = $scope;
    }

    public function exceptionHandler(Throwable $exception) {
        // this should never happens /!\
        if((E_FATAL) && ENV === 'production'){
            if(LOG_ERRORS)
                error_log( "Uncaught error: " . $exception->getMessage() . "\n" . $exception->getTraceAsString(), 0);

            header('Location: 500.html');
            header('Status: 500 Internal Server Error');
        }
        $this->_exceptions[] = $exception;
    }


    // Function to catch any remaining error after shutdown ...
    public function shutdownHandler() {
        $error = error_get_last();
        if($error && ($error['type'] & E_FATAL)){
            if(DISPLAY_ERRORS)
                echo "Shutdown with error:" + self::renderError( $error, $this->_scope);

            //Logging error on php file error log...
            if(LOG_ERRORS)
                error_log( "Shutdown with error:" + self::renderError( $error, 'console'), 0);

            $this->ErrorHandler( $error['type'], $error['message'], $error['file'], $error['line']);
        }
        
        if(!empty($this->_errors)) {
            if(DISPLAY_ERRORS)
                printf("shutdownHandler Errors : %s\n", count( $this->_errors));
            foreach( $this->_errors as $error) {
                $message = self::renderError( $error, $this->_scope);
                if(DISPLAY_ERRORS)
                    echo $message;
    
                //Logging error on php file error log...
                if(LOG_ERRORS)
                    error_log('(log_errors):' . strip_tags($message), 0);
                }
        }
        if(!empty($this->_exceptions)) {
            if(DISPLAY_ERRORS)
                printf("shutdownHandler Exceptions : %s\n", count( $this->_exceptions));
            foreach( $this->_exceptions as $ex) {
                $message = self::renderException( $ex, $this->_scope);
                if(DISPLAY_ERRORS)
                    echo $message;
    
                //Logging error on php file error log...
                if(LOG_ERRORS)
                    error_log('(log_exceptions):' . strip_tags($message), 0);
            }
        }
    }

    public function ErrorHandler( $errno, $errstr, $errfile, $errline ) {

        if(($errno & E_FATAL) && ENV === 'production'){
            header('Location: 500.html');
            header('Status: 500 Internal Server Error');
        }

        if(!($errno & ERROR_REPORTING))
            return;

        $error = [
            'type' => $errno,
            'message' => $errstr,
            'file' => $errfile,
            'line' => $errline,
        ];
        if(DEBUG)
            $error['trace'] = debug_backtrace();
        $this->_errors[] = $error;
    }

    /**
     * flush current instance
     * @param string $_output = html | ajax | json | array | console
     * @return string|array formatted errors
     */
    private function flushInst( $_output = null) {
        $_output = ($_output == null ? $this->_scope : $_output);
        $_result = [];
        if( $_output == 'array') {
            if(!empty( $this->_errors)) {
                $_result['errors'] = $this->_errors;
            }
            if(!empty( $this->_exceptions)) {
                $_result['exceptions'] = $this->_exceptions;
            }
        } else if( $_output == 'json') { // json
            $_result = array_merge( $this->_errors, $this->_exceptions);
        } else { // html or console
            if(!empty($this->_errors)) {
                foreach( $this->_errors as $error) {
                    $_result[] = self::renderError( $error, $_output);
                }
            }
            if(!empty($this->_exceptions)) {
                foreach( $this->_exceptions as $ex) {
                    $_result[] = self::renderError( ['type' => $ex->getCode(),
                      'message' => $ex->getMessage(),
                      'file' => $ex->getFile(),
                      'line' => $ex->getLine(),
                      'trace' => $ex->getTraceAsString()], $_output);
                }
            }
        }
        // flush and return computed result
        $this->_errors = [];
        $this->_exceptions = [];
        if( $_output == 'html')
            return implode( "\n", $_result);
        if($_output == 'json')
            return json_encode( $_result);
        // array is the default output
        return $_result;
    }

}