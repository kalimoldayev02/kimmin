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
	$(DOCKER_COMPOSE) exec $(APP_CONTAINER) php artisan migrate
	$(DOCKER_COMPOSE) exec $(APP_CONTAINER) php artisan storage:link
	$(DOCKER_COMPOSE) exec $(APP_CONTAINER) php artisan vendor:publish --provider="L5Swagger\\L5SwaggerServiceProvider"
	$(DOCKER_COMPOSE) exec $(APP_CONTAINER) php artisan db:seed
	swagger-generate

swagger-generate:
	$(DOCKER_COMPOSE) exec $(APP_CONTAINER) php artisan l5-swagger:generate
