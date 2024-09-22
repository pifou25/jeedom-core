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

/* * ***************************Includes********************************* */
require_once __DIR__ . '/../../core/php/core.inc.php';

class ajax {
	/*     * *************************Attributs****************************** */
	
	/*     * *********************Methode static ************************* */
	
	public static function init($_allowGetAction = array()) {
		if (!headers_sent()) {
			header('Content-Type: application/json');
		}
		if(isset($_GET['action']) && !in_array($_GET['action'], $_allowGetAction)){
			throw new \Exception(__('Méthode non autorisée en GET : ',__FILE__).$_GET['action']);
		}
	}
	
	public static function getToken(){
		return '';
	}
	
	public static function success($_data = '') {
		echo self::getResponse($_data);
		die();
	}
	
	/**
	 * return error as ajax json response
	 * @param $exception Exception
	 */
	public static function returnError($exception) {
		die( self::getResponse( ErrorHandler::renderException( $exception), $exception->getCode()));
	}

	public static function error($_data = '', $_errorCode = 0) {
		echo self::getResponse($_data, $_errorCode);
		die();
	}

	private static function getResponse($_data = '', $_errorCode = null) {
		$errors = ErrorHandler::flush( 'array');
		$isError = !(null === $_errorCode && empty($errors));
		$return = array(
			'state' => $isError ? 'error' : 'ok',
			'result' => $_data,
		);
		if ($isError) {
			$return['code'] = $_errorCode === null ? -1 : $_errorCode;
		}
		// only the 1rst error may be displayed in JS toaster
		if(!empty($errors)){
			$nb = count( $errors) - 1;
			$result = ( $nb > 0 ? "($nb errors)" : '');
			if( !empty($errors['errors'])) {
				$err = $errors['errors'][0];
				$return['result'] = $result . ErrorHandler::displayHtmlException( $err);
			} else if( !empty( $errors['exceptions'])){
				$return['result'] = $result . $errors['exceptions'][0]->getTraceAsString();
			}
		}
		// only the 1rst error may be displayed in JS toaster
		if(!empty($errors)){
			$nb = count( $errors) - 1;
			$result = ( $nb > 0 ? "($nb errors)" : '');
			if( !empty($errors['errors'])) {
				$err = $errors['errors'][0];
				$return['result'] = $result . ErrorHandler::renderException( $err);
			} else if( !empty( $errors['exceptions'])){
				$return['result'] = $result . $errors['exceptions'][0]->getTraceAsString();
			}
		}
		return json_encode($return, JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_SUBSTITUTE);
	}
	/*     * **********************Getteur Setteur*************************** */
}
