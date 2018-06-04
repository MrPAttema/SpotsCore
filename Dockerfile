FROM phusion/baseimage:0.9.21

#Install Core Components
RUN apt-get update -q
RUN apt-get upgrade -y -q
RUN apt-get install -y apache2 zip unzip git php7.0-fpm php7.0-cli php7.0-mcrypt php7.0-mbstring php7.0-xml php7.0-curl php7.0-mysql
RUN apt-get clean -q && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

#Install Composer
WORKDIR /root
RUN curl -sS https://getcomposer.org/installer | php
RUN mv /root/composer.phar /usr/local/bin/composer

#Open Ports
EXPOSE 80 443
