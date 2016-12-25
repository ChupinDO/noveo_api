# Simple user API

## Environment

- Yii 2
- PHP 7.0
- PostgreSQL 9.5

## API methods:
   
- `/users/fetch` list of users
    - Method: `GET`
    - Response: `json`

- `/users/create` a user
    - Method: `POST`
    - Response: `json`
    - Request: `json`
    - Request fields
        - `email` string, required, unique
        - `first_name` string
        - `last_name` string
        - `state` integer, default `0`
        - `group_id` integer, required

- `/users/id/fetch` info of a user
    - Method: `GET`
    - Response: `json`

- `/users/id/modify` users info
    - Method: `PUT, PATCH`
    - Response: `json`
    - Request: `json`
    - Request fields
        - `email` string
        - `first_name` string
        - `last_name` string
        - `state` integer, default `0`
        - `group_id` integer

- `/groups/fetch` list of groups
    - Method: `GET`
    - Response: `json`

- `/groups/create`a group
    - Method: `POST`
    - Response: `json`
    - Request: `json`
    - Request fields
        - `name` string, required, unique

- `/groups/id/modify` group info
    - Method: `PUT, PATCH`
    - Response: `json`
    - Request: `json`
    - Request fields
        - `name` string

## Migrations and initial DB structure

To create initial db structure please use project migrations.

Run the following command in project root:

 ```bash
./yii migrate
 ```

## Deploy with Docker

You can easily deploy this project in one command with [Docker](https://www.docker.com/).

Please use official documentation to install [Docker Engine](https://docs.docker.com/engine/installation/) and [Docker Compose](https://docs.docker.com/compose/install/).

Then run following command in project root:

 ```bash
 # start all services
 docker-compose up
 
 # and in another terminal window run database migrations
 docker-compose run --rm fpm ./yii migrate --interactive=0
 
 # check containers
 docker ps
 
 CONTAINER ID        IMAGE               COMMAND                  CREATED             STATUS              PORTS                         NAMES
 87189005f94e        nginx:latest        "nginx -g 'daemon off"   3 minutes ago       Up 3 minutes        0.0.0.0:80->80/tcp, 443/tcp   noveo_web_1
 25a03c0fd2ea        noveo_fpm           "docker-php-entrypoin"   3 minutes ago       Up 3 minutes        9000/tcp                      noveo_fpm_1
 30ddf563e3ee        postgres:9.5        "/docker-entrypoint.s"   14 minutes ago      Up 3 minutes        0.0.0.0:5432->5432/tcp        noveo_db_1
 ```

## Tests

Run the following command in project root:
 
 ```bash
 # load the fixtures for tests
 ./yii fixture/load "*"
 
 # run all tests
 ./vendor/bin/codecept run
 ```
 
> Please note that all data will be deleted from tables which is used in fixtures.  
So avoid to run it on production environment.