#!/bin/bash

VERT="\\033[1;32m"
NORMAL="\\033[0;39m"
ROUGE="\\033[1;31m"
ROSE="\\033[1;35m"
BLEU="\\033[1;34m"
BLANC="\\033[0;02m"
BLANCLAIR="\\033[1;08m"
JAUNE="\\033[1;33m"
CYAN="\\033[1;36m"

FILE_STOP="/root/stop_requested"

docker_stop(){
	echo "${JAUNE}Signal $@ Stopping Jeedom container${NORMAL}"
	echo "${VERT}Killing CRON${NORMAL}"
	killall cron
	echo "${VERT}Stopping Apache gracefully${NORMAL}"
	service apache2 stop
	echo "${VERT}Stopping Database gracefully${NORMAL}"
	service mariadb stop
	echo "${VERT}Stopping ATD gracefully${NORMAL}"
	service atd stop
	echo "${VERT}Stopping fail2ban gracefully${NORMAL}"
	service fail2ban stop
	echo "${ROUGE}Requesting stop on init.sh${NORMAL}"
	touch ${FILE_STOP}
	exit 0
}

say() {
  if [[ -z "$2" ]]; then COLOR=$VERT; else COLOR=$2; fi
  echo "******************************
${COLOR}$1${NORMAL}
******************************"
}

# flag to fail fast on errors
set -e

# $WEBSERVER_HOME and $VERSION env variables comes from Dockerfile

say "Start mariadb and atd services"

service mariadb start
service mariadb status

service atd restart
service atd status

if [[ -f ${WEBSERVER_HOME}/initialisation ]]; then

	if [ ! -f "/var/www/html/core/config/common.config.php" ]; then
		#
		# nouvelle installation
		#
	    say "Start JEEDOM initialisation !"
		JEEDOM_INSTALL=1

		DB_PASSWORD=$(cat /dev/urandom | tr -cd 'a-f0-9' | head -c 15)
		echo "DROP USER IF EXISTS 'jeedom'@'localhost';" | mysql
		echo  "CREATE USER 'jeedom'@'localhost' IDENTIFIED BY '${DB_PASSWORD}';" | mysql
		echo  "DROP DATABASE IF EXISTS jeedom;" | mysql
		echo  "CREATE DATABASE jeedom;" | mysql
		echo  "GRANT ALL PRIVILEGES ON jeedom.* TO 'jeedom'@'localhost';" | mysql

		cp ${WEBSERVER_HOME}/core/config/common.config.sample.php ${WEBSERVER_HOME}/core/config/common.config.php
		sed -i "s/#PASSWORD#/${DB_PASSWORD}/g" ${WEBSERVER_HOME}/core/config/common.config.php
		sed -i "s/#DBNAME#/${DB_NAME:-jeedom}/g" ${WEBSERVER_HOME}/core/config/common.config.php
		sed -i "s/#USERNAME#/${DB_USERNAME:-jeedom}/g" ${WEBSERVER_HOME}/core/config/common.config.php
		sed -i "s/#PORT#/${DB_PORT:-3306}/g" ${WEBSERVER_HOME}/core/config/common.config.php
		sed -i "s/#HOST#/${DB_HOST:-localhost}/g" ${WEBSERVER_HOME}/core/config/common.config.php

		if [ -d "${WEBSERVER_HOME}/backup" ] && [ "$(ls -At ${WEBSERVER_HOME}/backup/*.gz)" ]; then
		  RESTOREFILE=$(ls -At ${WEBSERVER_HOME}/backup/*.gz |  head -n1)
		  say "found a backup ${RESTOREFILE}, restore ongoing"
		  php ${WEBSERVER_HOME}/install/restore.php backup=${RESTOREFILE}
		else
			say "start JEEDOM PHP script installation"
			php ${WEBSERVER_HOME}/install/install.php mode=force
		fi

	else
		#
		# nouveau container, volumes partagés
		# Jeedom déjà configuré
		#
		say "NEW Jeedom container for existing installation"
	fi

	# remove default fail2ban, contains useless sshd check
	rm -f /etc/fail2ban/jail.d/defaults-debian.conf

	# remove the flag file after the first successfull installation
	rm ${WEBSERVER_HOME}/initialisation
else
    say "Resuming container..." $JAUNE
fi

if [[ ${JEEDOM_INSTALL} == 1 ]]; then
	if [[ ! -z "${RESTOREBACKUP}" ]] && [[ "${RESTOREBACKUP}" != 'NO' ]]; then
		say "Need restore backup ${RESTOREBACKUP}"
		wget ${RESTOREBACKUP} -O /tmp/backup.tar.gz
		php ${WEBSERVER_HOME}/install/restore.php backup=/tmp/backup.tar.gz
		rm /tmp/backup.tar.gz
	fi
	if [[ ! -z "${UPDATEJEEDOM}" ]] && [[ "${UPDATEJEEDOM}" != 'NO' ]]; then
		say "Need update jeedom ? '${UPDATEJEEDOM}'"
		php ${WEBSERVER_HOME}/install/update.php
	fi
fi

echo 'All init complete'
chmod 777 /dev/tty*
chmod 755 -R ${WEBSERVER_HOME}

echo 'Start apache2'
service apache2 start
service apache2 status

echo 'Start fail2ban'
service fail2ban start
service fail2ban status

echo 'Start CRON daemon'
cron

# step_12_jeedom_check
sh /tmp/install.sh -s 12 -v ${VERSION} -w ${WEBSERVER_HOME} -i docker

#TAKE CARE : the init.sh script is running under sh so trap only takes signal_number
echo 'trap signal 15 SIGTERM causes docker_stop'
trap "docker_stop $$ ;" 15

if [[ ${JEEDOM_INSTALL} == 1 ]]; then
    say "Sucessfull installation !
Jeedom is now up and running
https://doc.jeedom.com/fr_FR/premiers-pas/"
else
    say "Jeedom is now up and running"
fi

# infinite loop until stop requested
while [[ ! -e "${FILE_STOP}" ]]; do sleep 1; done
# gracefully stop
docker_stop "${FILE_STOP}"