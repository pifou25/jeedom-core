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

class userFunction {

	public static function zwaveGetQueueSize() {
		//return 0; //si tout va bien dans le reseau
		// Information sur l'etat de la Queue Zwave
		$networkState = openzwave::callOpenzwave('/network?type=info&info=getStatus');
		$queueSize=$networkState['result']['outgoingSendQueue'];
		log::add('zwaveordercheck', 'debug', '[Debug] -> queueSize : '.$queueSize);
		return $queueSize;
	}

	public static function isQubinoFilPiloteStatusOk ($_mycmd) {
		$arraycmd = explode("][",$_mycmd);
		$mystate = '#'.trim($arraycmd[0]).']['.trim($arraycmd[1]).'][Etat]#';
		$mystateName = cmd::byString($mystate)->getHumanName();
		$state = cmd::byString($mystate)->execCmd();
		log::add('zwaveordercheck', 'info', '[Etat] -> '.$mystateName.' : '.$state);
		$cmd = substr($arraycmd[2], 0, $arraycmd[2].length-1);
        switch ($cmd) {
			case "Arret":
				$ret = ($state == 0) ? 1 : 0;
				break;
			case "Hors Gel":
				$ret = ($state == 20) ? 1 : 0;
				break;
			case "Eco":
				$ret = ($state == 30) ? 1 : 0;
				break;
			case "Confort -2":
				$ret = ($state == 40) ? 1 : 0;
				break;
			case "Confort -1":
				$ret = ($state == 50) ? 1 : 0;
				break;
			case "Confort":
				$ret = ($state>=100) ? 1 : 0;
				break;
		}
        return $ret;
	}

	public static function sendQubinoFilPiloteOrder($_mycmd, $_mysleep='5') {
		$_mycmd = trim($_mycmd);
		$cmd = '#'.$_mycmd.'#';
		try {
			$mycmdName = cmd::byString($cmd)->getHumanName();
        } catch (Exception $e) {
    		log::add('zwaveordercheck', 'info', 'Exception recue : '.  $e->getMessage());
            $mycmdName = $_mycmd;
		}
		log::add('zwaveordercheck', 'info', '[Action demandee] -> '.$mycmdName);
		$i = 0;
		while (!userFunction::isQubinoFilPiloteStatusOk($_mycmd) && $i < 4) {
			// Tant que la valeur de l'etat ne colle pas la commande, on recommence
			if (userFunction::zwaveGetQueueSize() == 0) {
				if ($i > 1) {
					log::add('zwaveordercheck', 'warning', '[Action] -> '.$mycmdName.' [execution '.$i.']');
				} else {
					log::add('zwaveordercheck', 'info', '[Action] -> '.$mycmdName);
				}
				cmd::byString($cmd)->execCmd(); // Execution de la commande demandee
				sleep($_mysleep*($i + 1)); // Stoppe pour $_mysleep * execution secondes
				$i++;
			} else {
				sleep(1);
			}
		}
		if ($i == 4) {
			log::add('zwaveordercheck', 'warning', '[Info] -> '.$mycmdName. ' ne semble pas avoir ete executee');
			return 0;
		} else {
			log::add('zwaveordercheck', 'info', '[Action executee] -> '.$mycmdName);
			return 1;
		}
	}
}