#!/usr/bin/env bash

SCRIPT_DIR=$( cd -- "$( dirname -- "${BASH_SOURCE[0]}" )" &> /dev/null && pwd )

php $SCRIPT_DIR/release/build.php
STATUS_CODE=$?

if [ $STATUS_CODE == 1 ]
then
    echo "No release notes found."
fi
if [ $STATUS_CODE == 2 ]
then
    echo "Unable to write the current release notes in workspace."
fi
if [ $STATUS_CODE == 0 ]
then
    docker run --rm -it -u "$(id -u):$(id -g)" -v $SCRIPT_DIR/..:/usr/src ghcr.io/llaville/box-manifest:latest compile
fi

exit $STATUS_CODE
