#docker-compose variables
DOCKER_COMPOSE=docker-compose
DOCKER = docker
DOCKER_COMPOSE_EXEC = $(DOCKER_COMPOSE) exec

#docker-compose commands
up:
	$(DOCKER_COMPOSE) up -d

down:
	$(DOCKER_COMPOSE) down

prune:
	$(DOCKER) system prune -a -f

reinstall: down prune up

#Run symfony migrations
migrate:
	$(DOCKER_COMPOSE_EXEC) php bin/console doctrine:migrations:migrate --no-interaction

migrate-diff:
	$(DOCKER_COMPOSE_EXEC) php bin/console doctrine:migrations:diff

sh:
	$(DOCKER_COMPOSE_EXEC) php /bin/bash

test-db:
	$(DOCKER_COMPOSE_EXEC) php bin/console doctrine:query:sql "DROP DATABASE IF EXISTS app_test" 2>/dev/null || true
	$(DOCKER_COMPOSE_EXEC) php bin/console doctrine:query:sql "CREATE DATABASE app_test"
	$(DOCKER_COMPOSE_EXEC) -e APP_ENV=test php bin/console doctrine:migrations:migrate --no-interaction

cache-clear:
	$(DOCKER_COMPOSE_EXEC) php bin/console cache:clear

cache-clear-test:
	$(DOCKER_COMPOSE_EXEC) -e APP_ENV=test php bin/console cache:clear

composer-install:
	$(DOCKER_COMPOSE_EXEC) php composer install
