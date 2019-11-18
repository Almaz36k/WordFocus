#!/bin/bash

if [[ "$1" == "init" ]]; then
  exec docker-php-entrypoint php-fpm
else
  exec docker-php-entrypoint "$0"
fi
