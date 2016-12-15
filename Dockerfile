FROM ubuntu:trusty

WORKDIR /var/www/cms
COPY . /var/www/cms

CMD export DEBIAN_FRONTEND=noninteractive

## Install required packages
RUN apt-get update && apt-get -y install apache2 libapache2-mod-php5 php5-mysql pwgen php-apc php5-mcrypt php5-curl libssl-dev links
RUN apt-get -q -y install mysql-server


## Configure mysql
RUN service mysql start \
    && echo "create database admin" | mysql -uroot \
    && echo "GRANT ALL ON *.* TO root@'%' IDENTIFIED BY '' WITH GRANT OPTION; FLUSH PRIVILEGES" | mysql -uroot \
    && mysql -f -uroot admin < /var/www/cms/database.sql

## Apache configure
RUN a2enmod rewrite

ENV APACHE_RUN_USER www-data
ENV APACHE_RUN_GROUP www-data
ENV APACHE_LOG_DIR /var/log/apache2
ENV APACHE_LOCK_DIR /var/lock/apache2
ENV APACHE_PID_FILE /var/run/apache2.pid

RUN echo "ServerName localhost" | sudo tee /etc/apache2/conf-available/fqdn.conf && sudo a2enconf fqdn
RUN cat apache-config.conf > /etc/apache2/sites-available/000-default.conf

## Start Apache and MySQL
CMD service mysql start && /usr/sbin/apache2ctl -D FOREGROUND

EXPOSE 80 3306
