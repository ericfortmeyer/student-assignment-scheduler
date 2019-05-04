#!/usr/bin/env sh
BRANCH=production
TARGET_DIR=/home/$2/$BRANCH
BARE_REPO=/home/$2/$BRANCH.git

git config --global push.default simple
git remote add $BRANCH ssh://$2@$1:$BARE_REPO

if [ ! -d "$BARE_REPO" ]; then
    ssh $2@$1 "mkdir $BARE_REPO && git init --bare $BARE_REPO"
    git push -f $BRANCH HEAD:refs/heads/master
    git push -f $BRANCH HEAD:refs/heads/$BRANCH

    ssh $2@$1 "git clone $BARE_REPO && cd $TARGET_DIR && git checkout $BRANCH"
else
    git push -f $BRANCH HEAD:refs/heads/$BRANCH
    ssh $2@$1 "cd $TARGET_DIR && git pull ../$BRANCH.git"
fi
