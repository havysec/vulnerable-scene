#!/bin/bash

cp -rf ./bin/* /var/www/html/

sed -i "s/xxxxxx/$1/" /var/www/html/flag4tregyjo8ikuwefd6ythrbfqwd.php

#mysql --default-character-set=utf8 -e "source /var/www/html/database/complain_db.sql;"

#rm /var/www/html/database/complain_db.sql

sudo chown www-data:www-data -R /var/www/html/

chmod -R 754 /var/www/html

