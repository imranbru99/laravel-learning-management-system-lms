DC = docker compose
EXEC_APP = $(DC) exec app
EXEC_NODE = $(DC) exec node

.PHONY: help up down restart build install fresh test lint stan shell logs queue horizon npm-dev npm-build backup

help:
	@echo "Learnify LMS — Available Make Commands:"
	@echo "  make up          - Start all docker containers"
	@echo "  make down        - Stop all docker containers"
	@echo "  make restart     - Restart all docker containers"
	@echo "  make build       - Build docker images"
	@echo "  make install     - Complete bootstrap: composer, keys, migrate, seed, link, npm, buckets"
	@echo "  make fresh       - Re-run migrations fresh and re-seed database"
	@echo "  make test        - Run test suite (Pest / PHPUnit)"
	@echo "  make lint        - Run Laravel Pint linter"
	@echo "  make stan        - Run Larastan static analysis"
	@echo "  make shell       - Open bash shell inside app container"
	@echo "  make logs        - Tail docker compose logs"
	@echo "  make queue       - Monitor queues"
	@echo "  make horizon     - Open horizon status"
	@echo "  make npm-dev     - Start Vite frontend dev server"
	@echo "  make npm-build   - Build frontend assets for production"
	@echo "  make backup      - Trigger Spatie Laravel Backup"

up:
	$(DC) up -d

down:
	$(DC) down

restart:
	$(DC) restart

build:
	$(DC) build

install:
	@if [ ! -f .env ]; then cp .env.example .env; fi
	$(DC) up -d --build
	$(EXEC_APP) composer install --optimize-autoloader
	$(EXEC_APP) php artisan key:generate
	$(EXEC_APP) php artisan storage:link
	$(EXEC_APP) php artisan migrate --seed --force
	$(EXEC_APP) php artisan minio:init-buckets
	$(EXEC_APP) npm install
	$(EXEC_APP) npm run build
	$(EXEC_APP) php artisan scout:import "App\Models\Course" || true
	@echo "=========================================================="
	@echo "  Learnify LMS Installed & Ready!"
	@echo "  Web Application:  http://localhost:8080"
	@echo "  Mailpit UI:       http://localhost:8025"
	@echo "  MinIO Console:    http://localhost:9001"
	@echo "  Vite Dev Server:  http://localhost:5173"
	@echo "=========================================================="

fresh:
	$(EXEC_APP) php artisan migrate:fresh --seed --force

test:
	$(EXEC_APP) php artisan test

lint:
	$(EXEC_APP) ./vendor/bin/pint

stan:
	$(EXEC_APP) ./vendor/bin/phpstan analyse --memory-limit=2G

shell:
	$(EXEC_APP) sh

logs:
	$(DC) logs -f

queue:
	$(EXEC_APP) php artisan queue:monitor default,video

horizon:
	$(EXEC_APP) php artisan horizon:status

npm-dev:
	$(DC) up -d node

npm-build:
	$(EXEC_APP) npm run build

backup:
	$(EXEC_APP) php artisan backup:run
