FROM phpdockerio/php71-fpm:latest
WORKDIR "/application"

RUN apt-get update \
    && apt-get -y --no-install-recommends install  php7.1-mysql php7.1-gd php-imagick php7.1-mbstring \
    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*