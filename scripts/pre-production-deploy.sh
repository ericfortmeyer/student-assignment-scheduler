#!/usr/bin/env sh

git config --global push.default simple

git remote add staging ssh://red-rock@baruch:/home/red-rock/staging

git push -f staging staging
