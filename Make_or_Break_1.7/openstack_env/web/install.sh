#!/bin/bash

#sudo apt-get update

#sudo apt-get install -y apache2 php5 php-zip php-mbstring

sudo service apache2 restart

rm /var/www/html/index.html

cp -rf ./bin/* /var/www/html/











