#!/usr/bin/env sh

git config --global push.default simple

# git remote add staging ssh://$2@$1:/home/$2/staging

# git push -f staging staging

# alternative
TARGET_DIR=/home/$2/staging
BARE_REPO=/home/$2/staging.git

for [ dir in $TARGET_DIR $BARE_REPO ]
do
    if [ ! -d "$dir" ]; then
        if [ $dir == $BARE_REPO ]; then
            ssh $2@$1 "bash mkdir $dir && cd $dir && git init --bare"
        else
            ssh $2@$1 "bash mkdir $dir"
        fi
    fi
done

git remote add staging ssh://$2@$1:$BARE_REPO

git push -f staging HEAD:refs/head/staging

ssh $2@$1 "bash cd $TARGET_DIR && git clone $BARE_REPO ."
