#!/usr/bin/env sh

git config --global push.default simple

git remote add production ssh://$USER@$TARGET_HOST:/home/$USER/production

git push -f production HEAD:refs/head/master
