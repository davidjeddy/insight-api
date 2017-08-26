git clean
git fetch origin
git checkout devel
git pull origin devel
docker-compose up --build -d
docker stop db
docker exec -it insight_app_1 php ./console/yii app/setup --interactive=0
docker exec -it insight_app_1 php ./console/yii migrate/up --interactive=0