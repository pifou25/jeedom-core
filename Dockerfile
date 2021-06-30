FROM php:7.3-apache-buster

LABEL version="jeedom for debian buster"
MAINTAINER info@jeedom.com

# Installation des paquets
# 	ccze          : couleur pour les logs
# 	wget          : téléchargement
#   libzip-dev zip: pour l'extension php zip
#   sudo          : pour les droits sudo de jeedom
#   python*       : pour certains plugins
#   mariadb-client: pour backup et restauration

RUN apt-get update && apt-get install -y \
	apt-utils \
	net-tools \
	wget \
	ntp \
	locales \
	ccze \
	cron \
	supervisor \
	python python-pip python3 python-dev python3-pip python-virtualenv \
	libzip-dev zip \
	git \
	mariadb-client \
	systemd gettext librsync-dev \
	sudo && \
# add php extension
    docker-php-ext-install pdo pdo_mysql zip ldap gd imap opcache soap xmlrpc ssh2 && \
# add the jeedom cron task
	echo "* * * * *  /usr/bin/php /var/www/html/core/php/jeeCron.php >> /dev/null\n" > /etc/cron.d/jeedom && \
# add sudo for www-data
    echo "www-data ALL=(ALL:ALL) NOPASSWD: ALL" > /etc/sudoers.d/90-mysudoers

# add manually duplicity v0.7.19 from jeedom image
RUN python -m pip install future fasteners && \
    wget https://images.jeedom.com/resources/duplicity/duplicity.tar.gz -O /tmp/duplicity.tar.gz && \
    tar xvf /tmp/duplicity.tar.gz -C /tmp && \
	cd /tmp/duplicity-0.7.19 && \
	python setup.py install 2>&1 >> /dev/null && \
	rm -rf /tmp/duplicity.tar.gz && \
	rm -rf duplicity-0.7.19


# Apply cron job
RUN crontab /etc/cron.d/jeedom

# add php.ini file
ADD install/OS_specific/Docker/php.ini $PHP_INI_DIR/conf.d/

WORKDIR /var/www/html 
VOLUME /var/www/html 

# for beta: remove anoying .htaccess
# RUN rm /var/www/html/install/.htaccess

# Create the log file to be able to run tail
# RUN touch /var/www/html/log/cron.log

# install composer for dependancies
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
# RUN composer install

# Initialisation 
COPY install/OS_specific/Docker/init.sh /root/
CMD ["sh", "/root/init.sh"]
