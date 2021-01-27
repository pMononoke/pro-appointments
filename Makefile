SHELL=/bin/bash

ifndef PHP_DOCKER_COMMAND
PHP_DOCKER_COMMAND=docker-compose exec app php
endif

ifndef DEPTRAC_VERSION
DEPTRAC_VERSION=0.10.1
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
	- ${PHP_DOCKER_COMMAND} bin/phpunit --testdox

.PHONY: analyse
analyse: ## Run phpstan
#	- ${PHP_DOCKER_COMMAND} bin/console cache:warmup -e test
	- ${PHP_DOCKER_COMMAND} vendor/bin/phpstan analyse

.PHONY: cs-check
cs-check: ## Run code style check tool
	- ${PHP_DOCKER_COMMAND} vendor/bin/php-cs-fixer fix --dry-run --diff --ansi -v

.PHONY: cs-fix
cs-fix: ## Run code style fixer tool
	- ${PHP_DOCKER_COMMAND} vendor/bin/php-cs-fixer fix -v --ansi

.PHONY: behat
behat: ## Run behat
	- ${MAKE} ensure-database-for-test
	- ${PHP_DOCKER_COMMAND} vendor/bin/behat

.PHONY: migration-run
migration-run: ## Run database migrations
	- ${PHP_DOCKER_COMMAND} bin/console doctrine:migrations:migrate --no-interaction --ansi

.PHONY: schema-update
schema-update: ## Run database schema update
	- ${PHP_DOCKER_COMMAND} bin/console doctrine:schema:update --force --no-interaction --ansi

.PHONY: ensure-database-for-test
ensure-database-for-test:
	- ${PHP_DOCKER_COMMAND} bin/console doctrine:schema:update --env test --force --no-interaction --ansi

.PHONY: deptrac-install
deptrac-install: ## Install deptrac tool
	- curl -LS https://github.com/sensiolabs-de/deptrac/releases/download/${DEPTRAC_VERSION}/deptrac.phar -o deptrac.phar
	- chmod +x deptrac.phar
	- mv deptrac.phar deptrac
	- $(If you want to create nice dependency graphs, you need to install graphviz:)

.PHONY: architecture-check
architecture-check: ## Run deptrac  (architecture check)
	- ./deptrac analyze depfile.boundedContext.yml --formatter-graphviz=0 --ansi --no-progress
	- ./deptrac analyze depfile.domainLayer.yml --formatter-graphviz=0 --ansi --no-progress

.PHONY: pre-commit
pre-commit: ## pre commit checks
	- ${MAKE} cs-check
	- ${MAKE} analyse
	- ${MAKE} test
	- ${MAKE} architecture-check