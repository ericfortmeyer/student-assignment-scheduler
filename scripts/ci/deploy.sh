#!/usr/bin/env sh

git config --global push.default simple

git remote add production ssh://red-rock@baruch:/home/red-rock/production

git push -f production HEAD:refs/head/master
