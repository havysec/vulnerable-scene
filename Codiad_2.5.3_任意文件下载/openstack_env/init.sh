#!/bin/bash

sed -i "s/xxxxxx/$1/" /flag.txt

sudo chown www-data:www-data -R /var/www/html/