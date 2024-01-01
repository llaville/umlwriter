#!/usr/bin/env bash

SCRIPT_DIR=$( cd -- "$( dirname -- "${BASH_SOURCE[0]}" )" &> /dev/null && pwd )

ASSETS_IMAGE_DIR="docs/assets/images"

php $SCRIPT_DIR/build.php graph-composer $ASSETS_IMAGE_DIR
php $SCRIPT_DIR/../examples/graphviz.php configuration $ASSETS_IMAGE_DIR svg 1
php $SCRIPT_DIR/../examples/graphviz.php console-commands $ASSETS_IMAGE_DIR svg 1
php $SCRIPT_DIR/../examples/graphviz.php custom-autoloader $ASSETS_IMAGE_DIR svg 1
php $SCRIPT_DIR/../examples/graphviz.php formatter $ASSETS_IMAGE_DIR svg 1
php $SCRIPT_DIR/../examples/graphviz.php generator $ASSETS_IMAGE_DIR svg 1
php $SCRIPT_DIR/../examples/graphviz.php public-architecture $ASSETS_IMAGE_DIR svg 1
php $SCRIPT_DIR/../examples/graphviz.php public-methods-only $ASSETS_IMAGE_DIR svg 1
php $SCRIPT_DIR/../examples/graphviz.php services $ASSETS_IMAGE_DIR svg 1
