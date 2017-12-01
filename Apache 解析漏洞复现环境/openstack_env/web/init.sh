#!/bin/bash

cp -rf ./bin/* /var/www/html/

sed -i "s/xxxxxx/$1/" /var/www/html/flag.php

#mysql --default-character-set=utf8 -e "source /var/www/html/database/complain_db.sql;"

#rm /var/www/html/database/complain_db.sql

sudo chown www-data:www-data -R /var/www/html/

mv /var/www/html/docker-php.conf /etc/apache2/conf-enabled/

chmod -R 754 /var/www/html

chmod 777 /var/www/html/uploadfiles

service apache2 restart

rm -rf /var/www/html/uploadfiles/*
