#!/usr/bin/env sh

git config --global push.default simple

# git remote add production ssh://$2@$1:/home/$2/production

# git push -f production HEAD:refs/head/master


# alternative

git remote add production ssh://$2@$1:/home/$2/production.git

git push -f production HEAD:refs/head/master

ssh $2@$1 "cd /home/$2/production && git clone ../production.git ."
