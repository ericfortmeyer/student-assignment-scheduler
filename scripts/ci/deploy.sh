#!/usr/bin/env sh

git config --global push.default simple

git remote add production ssh://$2@$1:/home/$2/production

git push -f production HEAD:refs/head/master
