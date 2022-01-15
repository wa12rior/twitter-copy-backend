# Twitter Copy API

## Overview

Microservice that provides robust API for twitter. It includes data reading, information extraction and transfering this data into database.
All the data gathered is exposed on REST API. 

## Instalation

On the local environment as well as on production you have to install docker.

https://docs.docker.com/get-docker/

Then you have to install all dependencies:

```shell
docker exec -it receipt-engine_php /bin/bash
composer install
```

That's all

## Environment variables

```dotenv
APP_ENV=dev
DB_HOST=database
DB_NAME=receipt-engine
DB_PASSWORD=password
DB_USER=user
DB_PORT=5432
```

## Run containers

```shell
docker-compose up -d
```

### Get keycloak token

```shell
curl -d 'client_id=api-client' -d 'username=admin' -d 'password=admin' -d 'grant_type=password' -d 'client_secret=ahgh3ALUhHaq4Ta3ZJ8Qy0xY5dqoaRRK' 'http://localhost:8080/auth/realms/next-realm/protocol/openid-connect/token'
```
