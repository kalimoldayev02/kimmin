include .env
DOCKER_COMPOSE=docker-compose

composer-install:
	$(DOCKER_COMPOSE) exec $(APP_CONTAINER) composer install

up:
	$(DOCKER_COMPOSE) up -d

down:
	$(DOCKER_COMPOSE) down

artisan:
	$(DOCKER_COMPOSE) exec $(APP_CONTAINER) php artisan $(args)

init: up composer-install
	$(DOCKER_COMPOSE) exec $(APP_CONTAINER) php artisan key:generate
