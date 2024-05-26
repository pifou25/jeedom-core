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

/**
 * https://github.com/gitonomy/gitlib?tab=readme-ov-file
 * 
 * $ composer require gitonomy/gitlib
 */
use Gitonomy\Git\Repository;

class repo_git {
	/*     * *************************Attributs****************************** */
	
	public static $_name = 'Git';

	private static $_log = null;

	private static function log() {
		if(self::$_log == null){
			self::$_log = log::getObject('update');
			self::$_log->debug('initialize \'update\' logger...');
		}
		return self::$_log;
	}
		
	public static $_scope = array(
		'plugin' => true,
		'backup' => false,
		'hasConfiguration' => true,
		'core' => true,
	);
	
	/*     * ***********************Méthodes statiques*************************** */
	
	/**
	 * parameters_for_add : for modal panel 'add plugin via Git'
	 * configuration : for the Jeedom Core source repo
	 */
	public static function getConfigurationOption(){
		return array(
			'parameters_for_add' => array(
				'url' => array(
					'name' =>  __('URL du dépôt Git', __FILE__),
					'type' => 'input',
				),
				'token' => array(
					'name' =>  __('Token (facultatif)',__FILE__),
					'type' => 'password',
				),
				'branch' => array(
					'name' =>  __('Branche', __FILE__),
					'type' => 'select',
					'default' => 'fill-in url first then update form',
				),
			),
			'configuration' => array(
				'url' => array(
					'name' =>  __('URL du dépôt Git', __FILE__),
					'type' => 'input',
				),
				'token' => array(
					'name' =>  __('Token (facultatif)',__FILE__),
					'type' => 'password',
				),
				'core::branch' => array(
					'name' =>  __('Branche pour le core Jeedom',__FILE__),
					'type' => 'input',
					'default' => 'master',
				),
			),
		);
	}
	
	/**
	 * initialize Repository object from existing plugin if exists
	 * or from a tmp dir;
	 * or clone bare repo to tmp
	 * @param update $_update
	 * @return Repository repository
	 */
	private static function getRepo($_update) {
		$plugin = '/var/www/html/plugins/' . $_update->getLogicalId();
		$dir = '/tmp/gitlib/' . $_update->getLogicalId();
		if(is_dir($plugin)) {
			return new Repository( $plugin);
		}else if (is_dir($dir)){
			return new Repository( $dir);
		}
		// clone bare repo to tmp directory
		return Gitonomy\Git\Admin::cloneBranchTo( $dir, $_update->getConfiguration('url'), $_update->getConfiguration('branch', 'master'));
	}

	/**
	 * reccursive update of repositories
	 * @param update $_update :  update.class.php with the `getConfigurationOption` parameters
	 */
	public static function checkUpdate(&$_update) {
		if (is_array($_update)) {
			if (count($_update) < 1) {
				return;
			}
			foreach ($_update as $update) {
				self::checkUpdate($update);
			}
			return;
		}

		try {
			$repo = self::getRepo( $_update);
		} catch (Exception $e) {
			$_update->setRemoteVersion("repository not found ({$e->getMessage()})");
			$_update->setStatus('ok');
			$_update->save();
			return;
		}
		$_update->setRemoteVersion( $repo->getHeadCommit()->getFixedShortHash());
		if ($_update->getRemoteVersion() != $_update->getLocalVersion()) {
			$_update->setStatus('update');
		} else {
			$_update->setStatus('ok');
		}
		$_update->save();
	}

	/**
	 * Git clone object
	 * usage: update.class.php L309
	 * @param update $_update is update.class.php
	 * return array (['localVersion'])
	 */
	public static function downloadObject($_update) {
		// TODO : add token for private repo
		// $token = $_update->getConfiguration('token',config::byKey('github::token','core',''));
		// $client = self::getGitClient($token);

		self::log()->debug( __('Téléchargement de', __FILE__) . ' ' . $_update->getConfiguration('url') . '/' . $_update->getConfiguration('branch', 'master') . '...');
		
		try {
			$plugin = '/var/www/html/plugins/' . $_update->getLogicalId();
			$repository = Gitonomy\Git\Admin::cloneBranchTo( $plugin, $_update->getConfiguration('url'), $_update->getConfiguration('branch', 'master'), false);
			if($repository != null){
				$head = $repository->getHeadCommit();
				return ['localVersion' => $head->getFixedShortHash(), 'path' => false];
			}
		} catch (Exception $e) {
			$msg = __('Dépot Git non trouvé :', __FILE__) . ' ' . $_update->getConfiguration('url') . '/' . $_update->getConfiguration('branch', 'master')
			. "\n" . $e->getMessage();
			self::log()->error($msg);
			throw new Exception($msg);
		}
		return []; // empty array on error
	}
	
	public static function deleteObjet($_update) {
	}
	
	/**
	 * return doc and changelog URL of the plugin
	 * from various Git sources, it may be available or not ... ?
	 */
	public static function objectInfo($_update) {
		return array(
			'doc' => $_update->getConfiguration('url') 
			 . '/blob/' . $_update->getConfiguration('version', 'master') . '/doc/' . config::byKey('language', 'core', 'fr_FR') . '/index.asciidoc',
			'changelog' => $_update->getConfiguration('url') . '/commits/' . $_update->getConfiguration('version', 'master'),
		);
	}
	
	/**
	 * download Jeedom Core
	 * usage: install/update.php
	 * @param string $_path & zip file name
	 */
	public static function downloadCore($_path) {
		// TODO : add token for private repo
		// $client = self::getGitClient(config::byKey('github::token','core',''));

		try {
			$repository = Gitonomy\Git\Admin::cloneBranchTo('/tmp/gitlib/core', config::byKey('github::core::url', 'core', 'git.default.url'), config::byKey('github::core::branch', 'core', 'master'));
		} catch (Exception $e) {
			throw new Exception(__('Dépot github non trouvé :', __FILE__) . ' ' . config::byKey('github::core::url', 'core', 'git.default.url') . '/' . config::byKey('github::core::branch', 'core', 'master') );
		}

		return;
	}
	
	/** get online available version of Jeedom Core from core/config/version */
	public static function versionCore() {
		try {
			$repository = Gitonomy\Git\Admin::cloneBranchTo('/tmp/gitlib/core', config::byKey('github::core::url', 'core', 'git.default.url'), config::byKey('github::core::branch', 'core', 'master'));
			return trim($ $content);
		} catch (Exception $e) {
			
		} catch (Error $e) {
			
		}
		return null;
	}
	
	/**
	 * check git repo URL and look for list of branches and plugin tag ID
	 * @param array $args with key [configuration][url]
	 * @return array with results or error message
	 */
	public static function repoUpdateForm($args) {
		self::log()->debug('repoUpdateForm: ' . print_r( $args, true));
		if(!empty($args['configuration']['url'])){
			$url = $args['configuration']['url'];
			$valid = \Gitonomy\Git\Admin::isValidRepository($url);
			if($valid) {
				$words = explode('/', str_replace('.git', '',  $url));
				$name = $words[count($words) - 1];
				if(!file_exists("/tmp/gitlib/$name")){
					if(!mkdir("/tmp/gitlib/$name", 0777, true)){
						return ["error" => "unable to create dir /tmp/gitlib/{$name}"];
					}
					$repository = \Gitonomy\Git\Admin::cloneRepository("/tmp/gitlib/$name", $url);
				} else {
					$repository = new Repository("/tmp/gitlib/$name");
				}
				$references = $repository->getReferences();
				$branches = $references->getBranches();
				$names = [];
				foreach($branches as $branche){
					if(str_starts_with( $branche->getName(), 'origin/')){
						$names[] = str_replace('origin/', '', $branche->getName());
					}
				}
				$count = count($names);
				$id = $name;
				if(file_exists("/tmp/gitlib/$name/plugin_info/infos.json")){
					// Read the JSON file  
					$json = file_get_contents('my_data.json'); 
					// Decode the JSON file 
					$json_data = json_decode($json,true);
					$id = $json_data['id'];
				}
				self::log()->info("get info from git repo {$url} into {$name} - {$count} branches");
				return ["branch" => $names, "logicalId" => $id];
			} else {
				return ["error" => "invalid url {$url}"];
			}
		} else {
			return ["error" => "no URL provided"];
		}

	}

	/*     * *********************Methode d'instance************************* */
	
	/*     * **********************Getteur Setteur*************************** */
	
}
