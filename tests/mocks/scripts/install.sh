#!/usr/bin/env bash

set -e

command composer -v >/dev/null 2>&1 || { echo >&2 "Composer is required: https://getcomposer.org/"; exit 1; }


VENDOR_DIR=$1
mkdir $VENDOR_DIR
