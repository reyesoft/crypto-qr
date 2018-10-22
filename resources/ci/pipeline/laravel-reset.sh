#!/bin/sh

## Copyright (C) 1997-2017 Reyesoft <info@reyesoft.com>.
## This file is part of a Reyesoft Project. This can not be copied and/or
## distributed without the express permission of Reyesoft

echo '#### LARAVEL RESET ####'
php artisan migrate:reset --env=testing &&

exit 0;
