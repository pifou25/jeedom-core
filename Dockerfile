FROM debian:10

MAINTAINER info@jeedom.com

COPY install/install.sh /tmp/

WORKDIR /var/www/html 
VOLUME /var/www/html 

# toutes les étapes sauf download jeedom
RUN sh /tmp/install.sh -s 1 && \
    sh /tmp/install.sh -s 2 && \
	sh /tmp/install.sh -s 3 && \
	sh /tmp/install.sh -s 4 && \
	sh /tmp/install.sh -s 5 && \
	sh /tmp/install.sh -s 7 && \
	sh /tmp/install.sh -s 8 && \
	sh /tmp/install.sh -s 9 && \
	sh /tmp/install.sh -s 10 && \
	sh /tmp/install.sh -s 11 && \
	sh /tmp/install.sh -s 12

# install composer for dependancies
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
RUN composer install

COPY install/OS_specific/Docker/init.sh /root/
CMD ["sh", "/root/init.sh"]
