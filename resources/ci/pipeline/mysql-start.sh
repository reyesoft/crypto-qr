#!/bin/sh

## Copyright (C) 1997-2017 Reyesoft <info@reyesoft.com>.
## This file is part of a Reyesoft Project. This can not be copied and/or
## distributed without the express permission of Reyesoft

echo '#### MYSQL CONFIGURATION ####'
service mysql start
mysql --password=root -e "DROP DATABASE IF EXISTS idpal; CREATE DATABASE IF NOT EXISTS idpal;"
mysql --password=root -e 'create database mysql_test;' -v
mysql --password=root -e "CREATE USER 'forge'@'localhost' IDENTIFIED BY 'secret';"
mysql --password=root -e 'GRANT ALL PRIVILEGES ON * . * TO 'forge'@'localhost';'

exit 0;
