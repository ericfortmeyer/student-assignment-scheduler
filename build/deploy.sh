#!/usr/bin/env sh

deploy() {
    REMOTE_HOST=$1
    REMOTE_USER=$2
    BRANCH=$3
    HOME=/home/$REMOTE_USER
    URL=$REMOTE_USER@$REMOTE_HOST
    TARGET_DIR=$HOME/$BRANCH
    BARE_REPO=$HOME/$BRANCH.git

    git config --global push.default simple
    git remote add $BRANCH ssh://$URL:$BARE_REPO

    if ssh $URL "[ ! -d $BARE_REPO ]"; then
        ssh $URL "mkdir $BARE_REPO && git init --bare $BARE_REPO"
        git push -f $BRANCH HEAD:refs/heads/master
        git push -f $BRANCH HEAD:refs/heads/$BRANCH

        ssh $URL "git clone $BARE_REPO && cd $TARGET_DIR && git checkout $BRANCH"
    else
        git push -f $BRANCH HEAD:refs/heads/master
        git push -f $BRANCH HEAD:refs/heads/$BRANCH
        ssh $URL "cd $TARGET_DIR && git pull ../$BRANCH.git --no-ff"
    fi

}

export -f deploy
