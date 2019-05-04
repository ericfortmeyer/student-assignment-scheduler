#!/usr/bin/env sh
BRANCH=staging
TARGET_DIR=/home/$2/$branch
BARE_REPO=/home/$2/$branch.git

git config --global push.default simple
git remote add $branch ssh://$2@$1:$BARE_REPO

if [ ! -d "$BARE_REPO" ]; then
    ssh $2@$1 "mkdir $BARE_REPO && git init --bare $BARE_REPO"
    git push -f $branch HEAD:refs/heads/master
    git push -f $branch HEAD:refs/heads/$branch

    ssh $2@$1 "git clone $BARE_REPO && cd $TARGET_DIR && git checkout $branch"
else
    git push -f $branch HEAD:refs/heads/$branch
    ssh $2@$1 "cd $TARGET_DIR && git pull ../$branch.git"
fi
