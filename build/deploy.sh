#!/usr/bin/env sh

deploy() {
    REMOTE_HOST=$1
    REMOTE_USER=$2
    BRANCH=$3
    HOME=/home/$REMOTE_USER
    URL=$REMOTE_USER@$REMOTE_HOST
    TARGET_DIR=$HOME/$BRANCH
    BARE_REPO=$HOME/$BRANCH.git
    PATH_EXPORT_COMMAND='export PATH=$PATH:'
    PATH_EXPORT_COMMAND+="$TARGET_DIR"

    echo $PATH_EXPORT_COMMAND >> $HOME/.profile # to easily run commands from CLI

    git config --global push.default simple
    git remote add $BRANCH ssh://$URL:$BARE_REPO

    if ssh $URL "[ ! -d $BARE_REPO ]"; then # first push
        ssh $URL "mkdir $BARE_REPO && git init --bare $BARE_REPO"
        git push -f $BRANCH HEAD:refs/heads/master
        git push -f $BRANCH HEAD:refs/heads/$BRANCH

        ssh $URL "git clone $BARE_REPO --recursive && cd $TARGET_DIR && git checkout $BRANCH"
    else # not the first push
        git push -f $BRANCH HEAD:refs/heads/master
        git push -f $BRANCH HEAD:refs/heads/$BRANCH
        ssh $URL "cd $TARGET_DIR && git pull ../$BRANCH.git --recurse-submodules --no-ff"
    fi

}

export -f deploy
