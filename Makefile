.PHONY: up down start stop restart ps logs app db redis node artisan composer npm migrate seed key env init show-urls fresh tinker test build cache-clear permissions db-import db-import-file db-dump db-reset db-shell

UID := $(shell id -u)
GID := $(shell id -g)
export UID
export GID

up:
	@echo "=> Levantando contenedores (build incluido)..."
	docker compose up -d --build
	@$(MAKE) show-urls

init:
	@echo "=> Inicializando proyecto por primera vez..."
	@$(MAKE) env
	@$(MAKE) up
	@echo "=> Esperando que la base de datos este lista..."
	@sleep 10
	@echo "=> Instalando dependencias de Composer..."
	docker compose exec app composer install
	@echo "=> Generando APP_KEY..."
	docker compose exec app php artisan key:generate
	@$(MAKE) permissions
	@echo "=> Creando enlace simbolico de storage..."
	-docker compose exec app php artisan storage:link
	@echo "=> Ejecutando migraciones..."
	-docker compose exec app php artisan migrate --force
	@echo "=> Inicializacion completada."
	@$(MAKE) show-urls

down:
	@echo "=> Deteniendo y eliminando contenedores/red..."
	docker compose down

stop:
	@echo "=> Deteniendo contenedores (sin borrar datos)..."
	docker compose stop

start:
	@echo "=> Iniciando contenedores existentes..."
	docker compose start
	@$(MAKE) show-urls

restart:
	@echo "=> Reiniciando contenedores..."
	docker compose restart
	@$(MAKE) show-urls

ps:
	@echo "=> Estado de servicios:"
	docker compose ps

logs:
	docker compose logs -f $(filter-out $@,$(MAKECMDGOALS))

app:
	docker compose exec app bash

db:
	docker compose exec db mysql -u root -proot gislapp

db-shell:
	docker compose exec db mysql -u root -proot

db-import:
	@echo "=> Importando copiaDb/alexander_gislapp.sql a la base 'gislapp'..."
	@docker compose exec db sh -c "mysql -u root -proot gislapp < /copiaDb/alexander_gislapp.sql"
	@echo "=> Importacion completada."

db-import-file:
	@if [ -z "$(FILE)" ]; then echo "Uso: make db-import-file FILE=nombre.sql"; exit 1; fi
	@echo "=> Importando copiaDb/$(FILE) a la base 'gislapp'..."
	@docker compose exec db sh -c "mysql -u root -proot gislapp < /copiaDb/$(FILE)"
	@echo "=> Importacion completada."

db-dump:
	@mkdir -p copiaDb
	@FILE=copiaDb/dump_$$(date +%Y%m%d_%H%M%S).sql; \
	echo "=> Exportando base 'gislapp' a $$FILE..."; \
	docker compose exec -T db mysqldump -u root -proot --single-transaction --routines --triggers gislapp > $$FILE; \
	echo "=> Dump generado: $$FILE"

db-reset:
	@echo "=> Vaciando base de datos 'gislapp' (drop + create)..."
	@docker compose exec db mysql -u root -proot -e "DROP DATABASE IF EXISTS gislapp; CREATE DATABASE gislapp CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
	@echo "=> Base 'gislapp' recreada vacia."

redis:
	docker compose exec redis redis-cli

node:
	docker compose exec node bash

artisan:
	docker compose exec app php artisan $(filter-out $@,$(MAKECMDGOALS))

composer:
	docker compose exec app composer $(filter-out $@,$(MAKECMDGOALS))

npm:
	docker compose exec node npm $(filter-out $@,$(MAKECMDGOALS))

migrate:
	docker compose exec app php artisan migrate

fresh:
	docker compose exec app php artisan migrate:fresh --seed

seed:
	docker compose exec app php artisan db:seed

key:
	docker compose exec app php artisan key:generate

tinker:
	docker compose exec app php artisan tinker

test:
	docker compose exec app php artisan test

build:
	docker compose exec node npm run build

cache-clear:
	docker compose exec app php artisan optimize:clear

permissions:
	@echo "=> Ajustando permisos de storage y bootstrap/cache..."
	docker compose exec app chown -R www-data:www-data storage bootstrap/cache
	docker compose exec app chmod -R 775 storage bootstrap/cache

env:
	@if [ ! -f .env ]; then \
		if [ -f .env.docker ]; then \
			cp .env.docker .env && echo "=> .env creado desde .env.docker"; \
		else \
			cp .env.example .env && echo "=> .env creado desde .env.example"; \
		fi; \
	else \
		echo "=> .env ya existe"; \
	fi

show-urls:
	@echo ""
	@echo "=> Accesos:"
	@echo "   App (Nginx):    http://localhost:8000"
	@echo "   Vite dev:       http://localhost:5173"
	@echo "   phpMyAdmin:     http://localhost:8081  (root/root)"
	@echo "   Mailpit (UI):   http://localhost:8025"
	@echo "   MySQL:          localhost:3306  (root/root, db: gislapp)"
	@echo "   Redis:          localhost:6379"
	@echo ""

%:
	@:
