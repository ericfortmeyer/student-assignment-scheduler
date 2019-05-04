#!/usr/bin/env sh
REMOTE_HOST=$1
REMOTE_USER=$2
DIR="$(dirname $0)"
BRANCH=production
source $DIR/deploy.sh

deploy $REMOTE_HOST $REMOTE_USER $BRANCH
