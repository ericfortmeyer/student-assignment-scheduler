#!/usr/bin/env sh

git config --global push.default simple

git config receive.denyCurrentBranch ignore

git remote add staging ssh://$2@$1:/home/$2/staging

git push -f staging staging
