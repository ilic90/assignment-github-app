Assingment Github Application
========================

Requirements
------------

  * PHP 8.1.0 or higher;
  * MySQL 8.0;
  * and the [usual Symfony application requirements].

Installation
------------

Clone the repo locally:

```sh
git clone https://github.com/ilic90/assignment-github-app
cd assignment-github-app
```

Setup configuration:

```sh
cp .env.example .env
update DATABASE_URL from .env according to your database params
```

Install PHP dependencies:

```sh
composer install
```

Run command to create database:
```sh
php bin/console doctrine:database:create
```

Run command to migrate tables/columns to database:
```sh
php bin/console doctrine:migrations:migrate
```

Testing
------------

Run command to create test database:
```sh
php bin/console --env=test doctrine:database:create
```

Run command to migrate tables/columns to test database:
```sh
php bin/console --env=test doctrine:schema:create
```

Run tests:
```sh
php bin/phpunit
```

Runing the local server
------------

Install Symfony CLI
```sh
Download the symfony from https://symfony.com/download
```

Run command to start your server
```sh
symfony server:start
```


Running application (Docker)
------------
For convenience it might be better to run project inside Docker container, we will assume that Docker & docker-compose is already installed, so steps for running application in Docker container:

Building docker images
```sh
docker-compose build
```
Running container from previously built images 
```sh
docker-compose up
```


API documentation
------------

```sh
Api documentation page is on /api/doc endpoint or /api/doc.json for json format
```