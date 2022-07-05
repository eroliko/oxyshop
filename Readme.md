# oXyShop mini project
This is a mini project for oXyShop company.

To accomplish the assigment I used Symfony 6.1.2.

## Requirements
- Docker

## Installation
In the project root, run:
- Run `docker-compose build`
- Run `docker-compose up -d`
- Run `cp .env.example .env`

Run `docker-compose exec app bash` in the project root and then
int the opened environment:
- `composer i`
- `php bin/console doctrine:migrations:migrate`

## Server
Server was tested on Ubuntu 20.04.4 LTS with Docker version
20.10.17, build 100c701.

## Usage
Go to URL `http://oxyshop.localhost`. MySQL DB is accessible
via URL `http://localhost:3000/` - credentials are in the
`.env.example` file.