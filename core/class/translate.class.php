<?php

/**
 * translate.class.php
 * @package com.jeedom.core
 * @filesource
 */

 require_once __DIR__ . '/../php/core.inc.php';

/*
//DEBUG ONLY
require_once  'utils.class.php';
require_once  'scenarioExpression.class.php';
require_once  'log.class.php';
require_once  'message.class.php';

//log::add('debug_translate', 'error', 'loadTranslation: '.json_encode($test));
*/

/**
 * Helper class for text translation.
 * 
 * Basic Usage with {@see translate::sentence()} :
 * ```
 * echo translate::sentence('Text to translate', __FILE__);
 * ```
 * You may also use the shorter helper {@see function __()} :
 * ```
 * echo __('Texte to translate!' __FILE__);
 * ```
 * @package com.jeedom.core
 */
class translate {
	/*     * *************************Attributs****************************** */

    /**
     * Array of every translations
     * * 1st key is the language (fr_FR)
     * * 2nd key is the plugin Id, or any element of the core (widget...)
     * * 3st element is the french text, and the value is the translated text.
     * 
     * @var array
     */
	protected static $translation = array();
    
    /**
     * The current Jeedom selected language (default: fr_FR)
     * 
     * @var string
     */
	protected static $language = null;
    
    /**
     * Language configuration
     * @var array
     */
	private static $config = null;
    
    /**
     * Array, the key is the plugin Id and the value is boolean, true if
     * the plugin is loaded.
     * 
     * @var bool[]
     */
	private static $pluginLoad = array();
    
    /**
     * 
     * @var array
     */
	private static $widgetLoad = array();

	/*     * ***********************Methode static*************************** */

    /**
     * get the Language configuration of Jeedom
     * 
     * @param string $_key
     * @param string $_default
     * @return string
     */
	public static function getConfig($_key, $_default = '') {
		if (self::$config === null) {
			self::$config = config::byKeys(array('language'));
		}
		if (isset(self::$config[$_key])) {
			return self::$config[$_key];
		}
		return $_default;
	}

    /**
     * return the translation array of the plugin according to Jeedom Language
     * 
     * @param string $_plugin
     * @return array
     */
	public static function getTranslation($_plugin) {
		if (!isset(self::$translation[self::getLanguage()])) {
			self::$translation[self::getLanguage()] = array();
		}
		if (!isset(self::$pluginLoad[$_plugin])) {
			self::$pluginLoad[$_plugin] = true;
			self::$translation[self::getLanguage()] = array_merge(self::$translation[self::getLanguage()], self::loadTranslation($_plugin));
		}
		return self::$translation[self::getLanguage()];
	}

    /**
     * return the widget array translation
     * 
     * @param string $_widget
     * @return array
     */
	public static function getWidgetTranslation($_widget) {
		if (!isset(self::$translation[self::getLanguage()]['core/template/widgets.html'])) {
			self::$translation[self::getLanguage()]['core/template/widgets.html'] = array();
		}
		if (!isset(self::$widgetLoad[$_widget])) {
			self::$widgetLoad[$_widget][$_widget] = array_merge(self::$translation[self::getLanguage()]['core/template/widgets.html'], self::loadTranslation($_widget));
		}
		return self::$widgetLoad[$_widget];
	}

    /**
     * Translate the content text, using the name as reference file
     * 
     * @param string $_content
     * @param string $_name : `__FILE__` or any text defining the reference to use for translation
     * @param bool $_backslash
     * @return string
     */
	public static function sentence($_content, $_name, $_backslash = false) {
		return self::exec("{{" . $_content . "}}", $_name, $_backslash);
	}

    /**
     * get the plugin Id from the complete name
     * 
     * @param string $_name : `__FILE__` or any file path containing the plugin Id
     * @return string
     */
	public static function getPluginFromName($_name) {
		if (strpos($_name, 'plugins/') === false) {
			return 'core';
		}
		preg_match_all('/plugins\/(.*?)\//m', $_name, $matches, PREG_SET_ORDER, 0);
		if(isset($matches[0]) && isset($matches[0][1])){
			return $matches[0][1];
		}
		if (!isset($matches[1])) {
			return 'core';
		}
		return $matches[1];
	}

    /**
     * Translate the content text, using the name as reference file
     * 
     * @param string $_content : text to be translated
     * @param string $_name `__FILE__` or any file location
     * @param bool $_backslash = true to replace backslash escaping characters
     * @return string
     */
	public static function exec($_content, $_name = '', $_backslash = false) {
		if ($_content == '' || $_name == '') {
			return $_content;
		}
		$language = self::getLanguage();

		if ($language == 'fr_FR') {
			return preg_replace("/{{(.*?)}}/s", '$1', $_content);
		}

		if (substr($_name, 0, 1) == '/') {
			if (strpos($_name, 'plugins') !== false) {
				$_name = substr($_name, strpos($_name, 'plugins'));
			} else {
				if (strpos($_name, 'core') !== false) {
					$_name = substr($_name, strpos($_name, 'core'));
				}
				if (strpos($_name, 'install') !== false) {
					$_name = substr($_name, strpos($_name, 'install'));
				}
			}
		}

		//is a custom user widget:
		if (substr($_name, 0, 12) == 'customtemp::') {
			$translate = self::getWidgetTranslation($_name);
			if (empty($translate[$_name])) {
				return preg_replace("/{{(.*?)}}/s", '$1', $_content);
			}
		} else {
			$translate = self::getTranslation(self::getPluginFromName($_name));
		}

		//replacing {{content parts}} by $translate parts:
		$replace = array();
		preg_match_all("/{{(.*?)}}/s", $_content, $matches);
		foreach ($matches[1] as $text) {
			if (trim($text) == '') {
				$replace['{{' . $text . '}}'] = $text;
			}
			if (isset($translate[$_name]) && isset($translate[$_name][$text]) && $translate[$_name][$text] != '') {
				$replace['{{' . $text . '}}'] = ltrim($translate[$_name][$text],'##');
			}else if(strpos($text,"'") !== false && isset($translate[$_name]) && isset($translate[$_name][str_replace("'","\'",$text)]) && $translate[$_name][str_replace("'","\'",$text)] != ''){
				$replace["{{" . $text . "}}"] = ltrim($translate[$_name][str_replace("'","\'",$text)],'##');
			}
			if (!isset($replace['{{' . $text . '}}']) && isset($translate['common']) && isset($translate['common'][$text])) {
				$replace['{{' . $text . '}}'] = $translate['common'][$text];
			}
			if (!isset($replace['{{' . $text . '}}'])) {
				if (strpos($_name, '#') === false) {
					if (!isset($translate[$_name])) {
						$translate[$_name] = array();
					}
					$translate[$_name][$text] = $text;
				}
			}
			if ($_backslash && isset($replace['{{' . $text . '}}'])) {
				$replace['{{' . $text . '}}'] = str_replace("'", "\'", str_replace("\'", "'", $replace['{{' . $text . '}}']));
			}
			if (!isset($replace['{{' . $text . '}}']) || is_array($replace['{{' . $text . '}}'])) {
				$replace['{{' . $text . '}}'] = $text;
			}
		}
		return str_replace(array_keys($replace), $replace, $_content);
	}

    /**
     * get the full core path translation file
     * 
     * @param string $_language
     * @return string
     */
	public static function getPathTranslationFile($_language) {
		return __DIR__ . '/../i18n/' . $_language . '.json';
	}

    /**
     * get the widget path translation file
     * 
     * @param string  $_widgetName
     * @return string 
     */
	public static function getWidgetPathTranslationFile($_widgetName) {
		return __DIR__ . '/../../data/customTemplates/i18n/' . $_widgetName . '.json';
	}

    /**
     * Load the json translation file, for core or plugin
     * 
     * @param string $_plugin : optional, the plugin Id, or 'core' or 'customtemp::'
     * @return array
     */
	public static function loadTranslation($_plugin=null) {
		$return = array();
		if ($_plugin == null || $_plugin == 'core') {
			$filename = self::getPathTranslationFile(self::getLanguage());
			if (file_exists($filename)) {
				$content = file_get_contents($filename);
				$return = is_json($content, array());
			}
		}
		if ($_plugin == null) {
			foreach (plugin::listPlugin(true, false, false, true) as $plugin) {
				$return = array_merge($return, plugin::getTranslation($plugin, self::getLanguage()));
			}
		} else {
			//is non core widget:
			if (substr($_plugin, 0, 12) == 'customtemp::') {
				$filename = self::getWidgetPathTranslationFile(str_replace('customtemp::', '', $_plugin));
				if (file_exists($filename)) {
					$content = file_get_contents($filename);
					return is_json($content, array())[self::getLanguage()];
				} else {
					return array([self::getLanguage()] => array());
				}
			} else {
				return array_merge($return, plugin::getTranslation($_plugin, self::getLanguage()));
			}
		}

		return $return;
	}

    /**
     * get the Jeedom language, default is fr_FR
     * 
     * @return string
     */
	public static function getLanguage() {
		if (self::$language == null) {
			self::$language = self::getConfig('language', 'fr_FR');
		}
		return self::$language;
	}

    /**
     * set the language configuration
     * 
     * @param string $_langage
     */
	public static function setLanguage($_langage) {
		self::$language = $_langage ;
	}

	/*     * *********************Methode d'instance************************* */
}

/**
 * This function is a common helper for {@see translate::sentence()}
 * 
 * @use translate
 * 
 * @param string $_content
 * @param string $_name
 * @param bool $_backslash
 * @return string
 */
function __($_content, $_name, $_backslash = false) {
	return translate::sentence($_content, $_name, $_backslash);
}
