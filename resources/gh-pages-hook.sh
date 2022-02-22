#!/usr/bin/env bash

SCRIPT_DIR=$( cd -- "$( dirname -- "${BASH_SOURCE[0]}" )" &> /dev/null && pwd )

ASSETS_IMAGE_DIR="docs/assets/images"

php $SCRIPT_DIR/graph-uml/build.php application $ASSETS_IMAGE_DIR
php $SCRIPT_DIR/graph-uml/build.php configuration $ASSETS_IMAGE_DIR
php $SCRIPT_DIR/graph-uml/build.php services $ASSETS_IMAGE_DIR
php $SCRIPT_DIR/graph-uml/build.php console-commands $ASSETS_IMAGE_DIR
php $SCRIPT_DIR/graph-uml/build.php custom-autoloader $ASSETS_IMAGE_DIR
php $SCRIPT_DIR/graph-uml/build.php public-methods-only $ASSETS_IMAGE_DIR
php $SCRIPT_DIR/graph-uml/build.php public-architecture $ASSETS_IMAGE_DIR
php $SCRIPT_DIR/graph-uml/build.php generator $ASSETS_IMAGE_DIR
