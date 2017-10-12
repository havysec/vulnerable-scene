#!/bin/bash

sed -i "s/xxxxxx/$1/" /var/www/html/sql.sql 
sed -i "s/xxxxxx/$1/" /var/www/html/config.php

sudo chown www-data:www-data -R /var/www/html/

mysql -e "source /var/www/html/sql.sql"

rm /var/www/html/sql.sql