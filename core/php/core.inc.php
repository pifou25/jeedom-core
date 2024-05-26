<?php

/* This file is part of Jeedom.
*
* Jeedom is free software: you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation, either version 3 of the License, or
* (at your option) any later version.
*
* Jeedom is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
* GNU General Public License for more details.
*
* You should have received a copy of the GNU General Public License
* along with Jeedom. If not, see <http://www.gnu.org/licenses/>.
*/


define('E_FATAL',  E_ERROR | E_USER_ERROR | E_PARSE | E_CORE_ERROR |
		E_COMPILE_ERROR | E_RECOVERABLE_ERROR);

define('ENV', 'dev'); // or 'production'

// Custom error handling vars
define('DISPLAY_ERRORS', TRUE);
define('ERROR_REPORTING', E_ALL | E_STRICT);
define('LOG_ERRORS', TRUE);

register_shutdown_function('shut');
set_error_handler('handler');
set_exception_handler('exception_handler');

function exception_handler(Throwable $exception) {
	// this should never happens /!\
	echo "Uncaught exception: " , $exception->getMessage(), "\n";
	if(($errno & E_FATAL) && ENV === 'production'){
		header('Location: 500.html');
		header('Status: 500 Internal Server Error');
	}
	echo $exception->getTraceAsString();
}
  
  
// Function to catch no user error handler function errors...
function shut(){
	$error = error_get_last();
	if($error && ($error['type'] & E_FATAL)){
		handler($error['type'], $error['message'], $error['file'], $error['line']);
	}
}

function handler( $errno, $errstr, $errfile, $errline ) {

	switch ($errno){

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

	$message =
		'<b>' . $typestr .
		': </b>' . $errstr .
		' in <b>' . $errfile .
		'</b> on line <b>' . $errline .
		'</b><br/>';

	if(($errno & E_FATAL) && ENV === 'production'){
		header('Location: 500.html');
		header('Status: 500 Internal Server Error');
	}

	if(!($errno & ERROR_REPORTING))
		return;

	if(DISPLAY_ERRORS)
		printf('%s', $message);

	//Logging error on php file error log...
	if(LOG_ERRORS)
		error_log(strip_tags($message), 0);
}


date_default_timezone_set('Europe/Brussels');
require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../config/common.config.php';
require_once __DIR__ . '/../class/DB.class.php';
require_once __DIR__ . '/../class/config.class.php';
require_once __DIR__ . '/../class/jeedom.class.php';
require_once __DIR__ . '/../class/plugin.class.php';
require_once __DIR__ . '/../class/translate.class.php';
require_once __DIR__ . '/utils.inc.php';
include_file('core', 'jeedom', 'config');
include_file('core', 'compatibility', 'config');
include_file('core', 'utils', 'class');
include_file('core', 'log', 'class');

try {
	$configs = config::byKeys(array('timezone', 'log::level'));
	if (isset($configs['timezone'])) {
		date_default_timezone_set($configs['timezone']);
	}
} catch (Exception $e) {
} catch (Error $e) {
}

try {
	if (isset($configs['log::level'])) {
		log::define_error_reporting($configs['log::level']);
	}
} catch (Exception $e) {
} catch (Error $e) {
}

function jeedomAutoload($_classname) {
	/* core class always in /core/class : */
	$path = __DIR__ . "/../../core/class/$_classname.class.php";
	if (file_exists($path)) {
		include_file('core', $_classname, 'class');
	} else if (substr($_classname, 0, 4) === 'com_') {
		/* class com_$1 in /core/com/$1.com.php */
		include_file('core', substr($_classname, 4), 'com');
	} else if (substr($_classname, 0, 5) === 'repo_') {
		/* class repo_$1 in /core/repo/$1.repo.php */
		include_file('core', substr($_classname, 5), 'repo');
	} else if (strpos($_classname, '\\') === false && strpos($_classname, '/') === false) {
		/* autoload for plugins : no namespace */
		$classname = str_replace(array('Real', 'Cmd'), '', $_classname);
		$plugin_active = config::byKey('active', $classname, null);
		if (($plugin_active === null || $plugin_active == '' || $plugin_active == 0) && strpos($classname, '_') !== false) {
			$classname = explode('_', $classname)[0];
			$plugin_active = config::byKey('active', $classname, null);
		}
		if ($plugin_active == 1) {
			try {
				include_file('core', $classname, 'class', $classname);
			} catch (Exception $e) {
				
			} catch (Error $e) {
				
			}
		}
	}
}

spl_autoload_register('jeedomAutoload', true, true);
