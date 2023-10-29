# contabilidapp
CRUD of Providers made using Symfony
Steps to be followed to set up the project:
1) git clone this repository
2) docker-compose up -d
3) docker-compose exec composer composer install
4) docker-compose exec php php bin/console doctrine:database:create
5) docker-compose exec php php bin/console doctrine:migrations:migrate
6) docker-compose exec php php bin/console doctrine:fixtures:load
7) Go to 127.0.0.1
