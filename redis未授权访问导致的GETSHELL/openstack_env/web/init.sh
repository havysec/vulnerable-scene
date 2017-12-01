#!/bin/bash

#apt-get update 

#apt-get install -y gcc make

cp -rf ./bin/* /root/

#cd /root && wget http://download.redis.io/releases/redis-4.0.2.tar.gz

#tar xvf /root/redis-4.0.2.tar.gz

#cd /root/redis-4.0.2/ && make

rm /root/redis-4.0.2/redis.conf

mv /root/redis.conf /root/redis-4.0.2

sed -i "s/xxxxxx/$1/" /root/flag.txt

cd /root

./redis-4.0.2/src/redis-server redis-4.0.2/redis.conf

#chmod +x /root/start.sh

#nohup bash /root/start.sh & 

#mysql --default-character-set=utf8 -e "source /var/www/html/database/complain_db.sql;"

#rm /var/www/html/database/complain_db.sql

#sudo chown www-data:www-data -R /var/www/html/

#chmod -R 754 /var/www/html

