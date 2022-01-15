#!/bin/sh
set -e

chown -R application:application .

su application -s /bin/bash -c "composer install"

su application -s /bin/bash -c "bin/console d:d:d --if-exists -f"
su application -s /bin/bash -c "bin/console d:d:c"
su application -s /bin/bash -c "bin/console d:s:u -f"
