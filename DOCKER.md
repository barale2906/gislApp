# Docker — GISLA Mensajeria (Laravel)

Este proyecto esta dockerizado siguiendo la guia interna de Docker para proyectos
de desarrollo. **No necesitas instalar PHP, Composer, Node ni MySQL** en tu maquina:
todo corre dentro de contenedores.

---

## Requisitos

- Docker Engine 20+ y Docker Compose v2 (`docker compose ...`)
- `make` (opcional pero recomendado)

---

## Servicios

| Servicio    | Puerto host | Descripcion                       |
|-------------|-------------|-----------------------------------|
| web (Nginx) | 8000        | Punto de entrada de la app        |
| app (PHP-FPM 8.2) | -     | Procesa PHP / Composer / Artisan  |
| node (Node 20) | 5173    | Vite dev server (hot reload)      |
| db (MySQL 8.0) | 3306    | Base de datos `gislapp`           |
| redis (Redis 7) | 6379   | Cache, colas y sesiones           |
| mailpit     | 1025 / 8025 | SMTP local + UI web               |
| phpmyadmin  | 8081        | GUI web para MySQL                |

---

## Primer arranque (una sola vez)

```bash
make init
```

`make init` se encarga de:

1. Crear `.env` a partir de `.env.docker` si no existe.
2. Construir y levantar los contenedores.
3. Ejecutar `composer install`.
4. Generar `APP_KEY`.
5. Ajustar permisos de `storage` y `bootstrap/cache`.
6. Crear el enlace `php artisan storage:link`.
7. Ejecutar `php artisan migrate`.

Al terminar veras las URLs de acceso.

> **Importar la base existente**: ver la seccion
> [Importar / exportar la base de datos](#importar--exportar-la-base-de-datos).

---

## Uso diario

| Momento        | Comando      | Que hace                                              |
|----------------|--------------|-------------------------------------------------------|
| Fin del dia    | `make stop`  | Detiene contenedores conservando datos y volumenes.   |
| Inicio del dia | `make start` | Arranca los contenedores existentes y muestra URLs.   |
| Estado         | `make ps`    | Muestra los servicios activos.                        |
| Logs           | `make logs app` (o `web`, `node`, `db`...) | Logs en vivo.       |

**Evita** `docker compose down` en el dia a dia. Solo usalo si necesitas
reconstruir desde cero. **Nunca** uses `docker compose down -v` salvo que quieras
borrar la base de datos.

---

## Comandos utiles

```bash
make app                          # Shell dentro del contenedor PHP
make db                           # Cliente MySQL conectado a gislapp
make redis                        # Redis CLI

make artisan migrate              # php artisan migrate
make artisan migrate:fresh --seed # Reset + seed
make artisan tinker

make composer install
make composer require vendor/paquete

make npm install
make npm run dev
make build                        # npm run build (assets de produccion)

make cache-clear                  # artisan optimize:clear
make permissions                  # Reajusta permisos de storage / cache
make test                         # php artisan test
```

> **Argumentos con `--`**: si necesitas pasar flags como `--ignore-platform-reqs`,
> separa con `--`:
>
> ```bash
> make composer -- install --ignore-platform-reqs
> ```

---

## URLs de acceso

- App (Laravel): http://localhost:8000
- Vite dev server: http://localhost:5173
- phpMyAdmin: http://localhost:8081 (usuario `root`, password `root`)
- Mailpit (correos de desarrollo): http://localhost:8025
- MySQL: `localhost:3306` (`root` / `root`, db `gislapp`)
- Redis: `localhost:6379`

---

## Importar / exportar la base de datos

La carpeta `copiaDb/` esta montada **dentro** del contenedor `db` en la ruta
`/copiaDb` (solo lectura), por lo que puedes importar cualquier archivo `.sql`
que pongas alli sin copiarlo manualmente.

### Importar el dump principal (`alexander_gislapp.sql`)

```bash
make db-import
```

Esto ejecuta:

```bash
docker compose exec db sh -c "mysql -u root -proot gislapp < /copiaDb/alexander_gislapp.sql"
```

### Importar otro archivo `.sql` de `copiaDb/`

```bash
make db-import-file FILE=20250721_1235.sql
```

Equivale a:

```bash
docker compose exec db sh -c "mysql -u root -proot gislapp < /copiaDb/20250721_1235.sql"
```

### Reset y reimportacion desde cero

Si necesitas dejar la base totalmente limpia antes de importar:

```bash
make db-reset      # DROP + CREATE de la base 'gislapp' (la deja vacia)
make db-import     # Importa alexander_gislapp.sql
```

### Exportar (backup) la base actual

```bash
make db-dump
```

Genera un archivo `copiaDb/dump_YYYYMMDD_HHMMSS.sql` con la base completa
(incluyendo rutinas y triggers).

### Importar manualmente (sin make)

Tambien puedes hacerlo directamente con Docker:

```bash
# Opcion 1: el archivo ya esta dentro del contenedor (montado en /copiaDb)
docker compose exec db sh -c "mysql -u root -proot gislapp < /copiaDb/alexander_gislapp.sql"

# Opcion 2: enviarlo desde el host por stdin
docker compose exec -T db mysql -u root -proot gislapp < copiaDb/alexander_gislapp.sql

# Opcion 3: GUI - importar el archivo desde phpMyAdmin en http://localhost:8081
```

> **Nota**: el dump de `alexander_gislapp.sql` **no contiene** `CREATE DATABASE`,
> asi que importa todo dentro de la base `gislapp` (la que crea Docker
> automaticamente). No necesitas renombrar nada.

> **Importante**: tras importar el dump, **no ejecutes** `php artisan migrate`
> sobre esa base si el dump ya trae las tablas. Si quieres migrar desde cero,
> usa `make db-reset` y luego `make artisan migrate`.

---

## Conexion a la base de datos desde DBeaver / TablePlus

- Host: `localhost`
- Puerto: `3306`
- Usuario: `root`
- Password: `root`
- Base de datos: `gislapp`

Desde dentro de otro contenedor usa `db` como host (no `localhost`).

---

## Estructura Docker

```
gislApp/
├── docker/
│   ├── nginx/default.conf      # Configuracion del servidor web
│   ├── php/Dockerfile          # Imagen PHP 8.2-FPM con extensiones Laravel
│   └── node/Dockerfile         # Imagen Node 20 para Vite
├── docker-compose.yml          # Orquestacion de servicios
├── Makefile                    # Comandos estandarizados
├── .env.docker                 # Plantilla de variables para Docker
└── .dockerignore
```

---

## Resolucion de problemas

**Permisos en `storage/` o `bootstrap/cache/`**:

```bash
make permissions
```

**Recompilar imagenes tras cambiar un Dockerfile**:

```bash
docker compose build --no-cache
make up
```

**Reset total (BORRA DATOS)**:

```bash
docker compose down -v
make init
```

**Ver que esta corriendo**:

```bash
make ps
make logs app
```
