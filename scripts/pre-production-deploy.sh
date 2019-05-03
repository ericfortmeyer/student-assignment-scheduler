#!/usr/bin/env sh

git config --global push.default simple

git remote add staging ssh://$USER@$TARGET_HOST:/home/$USER/staging

git push -f staging staging
