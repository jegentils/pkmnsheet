.DEFAULT_GOAL := help

DOCKER_COMPOSE = docker compose -f compose.yaml
PHP ?= php

.PHONY: help boot start stop log connect console test lint check

help: ## Afficher les commandes disponibles
	@awk 'BEGIN {FS = ":.*## "} /^[a-zA-Z0-9_-]+:.*## / {printf "  %-12s %s\n", $$1, $$2}' $(MAKEFILE_LIST)

boot: ## Démarrer les services sans reconstruire l'image
	$(DOCKER_COMPOSE) up -d

start: ## Construire l'image et démarrer les services
	$(DOCKER_COMPOSE) up -d --build

stop: ## Arrêter les services en conservant les conteneurs
	$(DOCKER_COMPOSE) stop

log: ## Suivre les logs des services (Ctrl+C pour quitter)
	$(DOCKER_COMPOSE) logs -f

connect: ## Ouvrir un shell dans le conteneur de l'application
	$(DOCKER_COMPOSE) exec app sh

console: ## Exécuter une commande Symfony (exemple : make console ARGS="about")
	$(DOCKER_COMPOSE) exec -T app php bin/console $(ARGS)

test: ## Exécuter les tests PHPUnit
	$(PHP) bin/phpunit

lint: ## Vérifier la configuration Symfony et les templates Twig
	$(PHP) bin/console lint:yaml config
	$(PHP) bin/console lint:twig templates/
	$(PHP) bin/console lint:container

check: lint test ## Exécuter les vérifications et les tests
