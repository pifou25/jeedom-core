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
	echo "${JAUNE}Stopping Jeedom container${NORMAL}"
	echo "${VERT}Killing CRON${NORMAL}"
	killall cron
	echo "${VERT}Stopping Apache gracefully${NORMAL}"
	service apache2 stop
	echo "${VERT}Stopping Database gracefully${NORMAL}"
	service_mariadb stop
	echo "${VERT}Stopping ATD gracefully${NORMAL}"
	service atd stop
	echo "${ROUGE}Requesting stop on init.sh${NORMAL}"
	touch ${FILE_STOP}
	exit 0
}

service_mariadb(){
	service mysql $1
	if [ $? -ne 0 ]; then
		service mariadb $1
		if [ $? -ne 0 ]; then
			echo "${ROUGE}Cannot start mariadb - Cancelling${NORMAL}"
			return 1
		fi
	fi
	return 0
}

echo 'Start init'

# $WEBSERVER_HOME and $VERSION env variables comes from Dockerfile

if [ -f ${WEBSERVER_HOME}/core/config/common.config.php ]; then
	echo 'Jeedom is already install'
	JEEDOM_INSTALL=1
else
	echo 'Start jeedom installation'
	JEEDOM_INSTALL=0
	rm -rf /root/install.sh
	wget https://raw.githubusercontent.com/jeedom/core/${VERSION}/install/install.sh -O /root/install.sh
	chmod +x /root/install.sh
	/root/install.sh -s 6 -v ${VERSION} -w ${WEBSERVER_HOME}
	if [ $(which mysqld | wc -l) -ne 0 ]; then
		chown -R mysql:mysql /var/lib/mysql
		mysql_install_db --user=mysql --basedir=/usr/ --ldata=/var/lib/mysql/
		service_mariadb restart
		DB_PASSWORD=$(cat /dev/urandom | tr -cd 'a-f0-9' | head -c 15)
		echo "DROP USER 'jeedom'@'localhost';" | mysql > /dev/null 2>&1
		echo  "CREATE USER 'jeedom'@'localhost' IDENTIFIED BY '${DB_PASSWORD}';" | mysql
		echo  "DROP DATABASE IF EXISTS jeedom;" | mysql
		echo  "CREATE DATABASE jeedom;" | mysql
		echo  "GRANT ALL PRIVILEGES ON jeedom.* TO 'jeedom'@'localhost';" | mysql
	fi

	cp ${WEBSERVER_HOME}/core/config/common.config.sample.php ${WEBSERVER_HOME}/core/config/common.config.php
	sed -i "s/#PASSWORD#/${DB_PASSWORD}/g" ${WEBSERVER_HOME}/core/config/common.config.php
	sed -i "s/#DBNAME#/${DB_NAME:-jeedom}/g" ${WEBSERVER_HOME}/core/config/common.config.php
	sed -i "s/#USERNAME#/${DB_USERNAME:-jeedom}/g" ${WEBSERVER_HOME}/core/config/common.config.php
	sed -i "s/#PORT#/${DB_PORT:-3306}/g" ${WEBSERVER_HOME}/core/config/common.config.php
	sed -i "s/#HOST#/${DB_HOST:-localhost}/g" ${WEBSERVER_HOME}/core/config/common.config.php
	/root/install.sh -s 10 -v ${VERSION} -w ${WEBSERVER_HOME}
	/root/install.sh -s 11 -v ${VERSION} -w ${WEBSERVER_HOME}
fi

echo 'Start atd'
service atd restart

if [ $(which mysqld | wc -l) -ne 0 ]; then
	echo 'Starting mariadb'
	chown -R mysql:mysql /var/lib/mysql /var/run/mysqld
	service_mariadb restart
	if [ $? -ne 0 ]; then
		# That can lead to FATAL corruption of databases
		# rm /var/lib/mysql/ib_logfile*
		# service_mariadb restart
		echo "${ROUGE}Starting Database FAILED${NORMAL}"
		exit 1
	fi
fi

if [ ${JEEDOM_INSTALL} -eq 0 ] && [ ! -z "${RESTOREBACKUP}" ] && [ "${RESTOREBACKUP}" != 'NO' ]; then
	echo 'Need restore backup '${RESTOREBACKUP}
	wget ${RESTOREBACKUP} -O /tmp/backup.tar.gz
	php ${WEBSERVER_HOME}/install/restore.php backup=/tmp/backup.tar.gz
	rm /tmp/backup.tar.gz
	if [ ! -z "${UPDATEJEEDOM}" ] && [ "${UPDATEJEEDOM}" != 'NO' ]; then
		echo 'Need update jeedom'
		php ${WEBSERVER_HOME}/install/update.php
	fi
fi

echo 'All init complete'
chmod 777 /dev/tty*
chmod 777 -R /tmp
chmod 755 -R ${WEBSERVER_HOME}
chown -R www-data:www-data ${WEBSERVER_HOME}

echo 'Start apache2'
service apache2 start

echo 'Start CRON daemon'
cron

#TAKE CARE : the init.sh script is running under sh so trap only takes signal_number
echo 'Add trap docker_stop'
trap "docker_stop $$ ;" 15

rm "${FILE_STOP}" 1>/dev/null 2>&1
while [ ! -e "${FILE_STOP}" ]; do sleep 1; done
