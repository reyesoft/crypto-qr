#!/bin/sh

## Copyright (C) 1997-2017 Reyesoft <info@reyesoft.com>.
## This file is part of a Reyesoft Project. This can not be copied and/or
## distributed without the express permission of Reyesoft

echo '#### ENV LARAVEL CONFIGURATION ####'
cat .env.example >> .env.testing
sed -i -e "
s/APP_ENV.*$/APP_ENV=testing/g;
s/DB_HOST.*$/DB_HOST=localhost/g;
s/DB_DATABASE.*$/DB_DATABASE=mysql_test/g;
s/DB_USERNAME.*$/DB_USERNAME=forge/g;
s/DB_PASSWORD.*$/DB_PASSWORD=secret/g;
s/QUEUE_DRIVER.*$/QUEUE_DRIVER=sync/g;
" .env.testing

exit 0;
