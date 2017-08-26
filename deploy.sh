#!/usr/bin/env bash

# repo steps
git fetch origin
git checkout devel
git pull origin devel

# build services, stop the db (using RDS)
docker-compose up --build -d
docker stop db

# run php dependency update
docker exec -it hackathonproject_app_1 wget https://getcomposer.org/composer.phar -O composer.phar
docker exec -it hackathonproject_app_1 php composer.phar install --ansi --profile --prefer-source -o -vvv
docker exec -it hackathonproject_app_1 php composer.phar update --ansi --profile --prefer-source -o -vvv

# run migrations
docker exec -it hackathonproject_app_1 php ./console/yii app/setup --interactive=0
docker exec -it hackathonproject_app_1 php ./console/yii migrate/up --interactive=0