#!/usr/bin/env bash

set -e

command composer -v >/dev/null 2>&1 || { echo >&2 "Composer is required: https://getcomposer.org/"; exit 1; }

echo "Welcome!"
echo "Now installing dependecies..."
sleep 0.5

composer -q install

echo "You're all set!\n\n"
