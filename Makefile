SHELL=/bin/bash

ifndef PHP_DOCKER_COMMAND
PHP_DOCKER_COMMAND=docker-compose exec app php
endif

# Mute all `make` specific output. Comment this out to get some debug information.
.SILENT:


.PHONY: help
help:
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'

##@ DEV Docker

.PHONY: up
up: ## start docker instances
	- docker-compose up -d

.PHONY: down
down: ## stop docker instances
	- docker-compose down -v

.PHONY: status
status: ## List containers
	- docker-compose ps

.PHONY: test
test: ## Run phpunit
	- ${MAKE} ensure-database-for-test
	- ${PHP_DOCKER_COMMAND} bin/phpunit

.PHONY: analyse
analyse: ## Run phpstan
#	- ${PHP_DOCKER_COMMAND} bin/console cache:warmup -e test
	- ${PHP_DOCKER_COMMAND} vendor/bin/phpstan analyse

.PHONY: cs-check
cs-check: ## Run code style check tool
	- ${PHP_DOCKER_COMMAND} vendor/bin/php-cs-fixer fix --dry-run --diff --ansi

.PHONY: cs-fix
cs-fix: ## Run code style fixer tool
	- ${PHP_DOCKER_COMMAND} vendor/bin/php-cs-fixer fix -v --ansi

.PHONY: migration-run
migration-run: ## Run database migrations
	- ${PHP_DOCKER_COMMAND} bin/console doctrine:migrations:migrate --no-interaction --ansi

.PHONY: schema-update
schema-update: ## Run database schema update
	- ${PHP_DOCKER_COMMAND} bin/console doctrine:schema:update --force --no-interaction --ansi

.PHONY: ensure-database-for-test
ensure-database-for-test:
	- ${PHP_DOCKER_COMMAND} bin/console doctrine:schema:update --env test --force --no-interaction --ansi
