#!/bin/bash

# This script is necessary since the application uses 'read -s'
# If this application is used with 'sh' on the CLI instead of 'bash'
# the -s flag is unavailable and will throw and error
# The readline function in PHP exposes the password which is the reason for using 'read -s'

# receives user input
read -rs passwd

# use to send what the user typed to exec|system|passthru function in PHP
echo $passwd
