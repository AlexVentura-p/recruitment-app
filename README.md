# Hiring App

Hiring App is an API made to manage the hire process of companies.

## Deployment

* Create env respective env files, you can find examples on root folder, this project makes use 
of .env for development, .env.testing for testing and .env.prod for production


* If using docker run docker compose file and access container bash console 
    ```
    docker-compose -f docker-compose-dev.yml up
    ```
    (For production use docker-compose-prod.yml instead)

    Once app container is running open bash in app container
    ```
    docker ps (For container list)
    docker exec -it [containerId] /bin/bash
    ```
* Install composer dependencies
    ```
    composer install
    ```
* Once database is up and ready for connections install migrations and passport (using personal access client) 
    ```
    php artisan migrate:fresh
    php artisan passport:keys
    php artisan passport:client --personal
    ```
* place client secret and client id on respective env file
  ```
  PASSPORT_PERSONAL_ACCESS_CLIENT_ID=
  PASSPORT_PERSONAL_ACCESS_CLIENT_SECRET=
  ```

* If using docker compose for production, you need allow permission for logs and framework folder
  ```
  chown -R www-data:www-data storage/logs
  chown -R www-data:www-data storage/framework
  ```

* Seed database with basic roles needed on the application (admin,admin-company,recruiter,candidate)
and create api admin level user with the following commands
  ```
  php artisan db:seed --class=RoleSeeder
  php artisan make:admin
  ```
* If needed you can also run default seeder to populate all tables with fake data
  ```
  php artisan migrate:fresh --seed
  ```
## IMAGES USED ON DOCKER CONTAINERS

* php:8.0.2-fpm
* composer
* nginx:1.19-alpine
* mysql:8.0
docker mysql image uses "mysql" as DB_HOST

* mailhog/mailhog:v1.0.1 for email testing 
mailhog configuration by using DOCKER: (when not using docker host can be "localhost")
  MAIL_MAILER=smtp
  MAIL_HOST=mailhog
  MAIL_PORT=1025
  MAIL_USERNAME=null
  MAIL_PASSWORD=null
  MAIL_ENCRYPTION=null
  MAIL_FROM_ADDRESS=hiringapp@dev.com
  MAIL_FROM_NAME="${APP_NAME}"

## ADDITIONAL NOTES

*To access to mailhog inbox using mailhog you can use port 8025

Dockerfile for development allows containers to use files in host machine meanwhile 
the Dockerfile for production file creates a copy of all files and creates a named volume for containers.
