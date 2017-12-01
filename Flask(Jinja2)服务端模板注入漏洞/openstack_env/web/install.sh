#!/bin/bash

apt-get install -y python-pip

mkdir /app

cp -rf ./bin/* /app/

sed -i "s/xxxxxx/$1/" /app/flagvfkyujnbvfr678iknwdoks.txt

pip install -U -r /app/requirements.txt

#mysql --default-character-set=utf8 -e "source /var/www/html/database/complain_db.sql;"

#rm /var/www/html/database/complain_db.sql




#chmod -R 754 /app

#cd /app

#export FLASK_APP=app.py

#rm requirements.txt

#nohup python -m flask run -p 8000 --host=0.0.0.0 &

