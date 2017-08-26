#!/usr/bin/env bash
# repo steps
git fetch origin
git checkout devel
git pull origin devel

# build services, stop the db (using RDS)
docker-compose up --build -d
docker stop db

# run migrations
docker exec -it insight_app_1 php ./console/yii app/setup --interactive=0
docker exec -it insight_app_1 php ./console/yii migrate/up --interactive=0

# run php dependency update
docker exec -it insight_app_1 php composer.phar update --ansi --profile --prefer-source -o -vvv