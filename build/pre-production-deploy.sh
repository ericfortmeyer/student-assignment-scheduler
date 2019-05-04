#!/usr/bin/env sh

git config --global push.default simple

# git remote add staging ssh://$2@$1:/home/$2/staging

# git push -f staging staging

# alternative
TARGET_DIR=/home/$2/staging
BARE_REPO=/home/$2/staging.git
git remote add staging ssh://$2@$1:$BARE_REPO

if [ ! -d "$BARE_REPO" ]; then
    ssh $2@$1 "mkdir $BARE_REPO && git init --bare $BARE_REPO"
    git push -f staging HEAD:refs/heads/master
    git push -f staging HEAD:refs/heads/staging

    ssh $2@$1 "git clone $BARE_REPO && cd $TARGET_DIR && git checkout staging"
else
    git push -f staging HEAD:refs/heads/staging
    ssh $2@$1 "cd $TARGET_DIR && git pull ../staging.git"
fi
