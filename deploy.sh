#!/usr/bin/env sh

git checkout production
git merge master
git push origin production
git checkout master

wget https://forge.laravel.com/servers/506164/sites/1501171/deploy/http?token=qXHZIsfK6IkdqmrBaYBG3YwLR1nbyKWMBacjhuy3 /dev/null
