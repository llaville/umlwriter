#!/bin/sh

[ "$APP_DEBUG" == 'true' ] && set -x
set -e

if [ "$APP_DEBUG" == 'true' ]
then
  echo "> You will act as user: $(id -u -n)"
fi

/usr/local/bin/umlwriter $@
