## Docker: Using Composer & Artisan via Docker Compose 🔧

If your host machine doesn't have PHP or Composer installed, you can use the project's Docker Compose services. The compose file defines the helpful services: `composer`, `artisan`, `php`, `server`, `mysql`.

### Install dependencies

```bash
# Install composer dependencies
docker compose run --rm composer install

# If you see platform requirement errors:
docker compose run --rm composer install --ignore-platform-reqs
```

### Start the application

```bash
# Build and start all services in detached mode
docker compose up server -d --build

# Or start specific services
docker compose up -d --build server php mysql
```

Before running Artisan, make sure there's an `.env` file in the API project root (`Sim-Sanctum-Api`). If it doesn't exist, create one from the example:

```bash
cp Sim-Sanctum-Api/.env.example Sim-Sanctum-Api/.env

# Give Dockerized PHP access to the storage directory (avoid permission issues when containers write files):
sudo chmod -R 777 ./Sim-Sanctum-Api/storage/
```

### Run Artisan

The repo provides an `artisan` service that runs `php /var/www/html/artisan`, so any Artisan command works directly:

```bash
# Run migrations
docker compose run --rm artisan migrate

# Run Database Seeder:
docker compose run --rm artisan db:seed

# Run to generate application key:
docker compose run --rm artisan key:generate
```

---

### Accessing services & testing ✅

- **App:** http://localhost:8000
- **Mailpit UI:** http://localhost:8025 — open this in your browser to view captured emails.
- **Redis:** containerized and used for caching (ensure `CACHE_DRIVER=redis` in your env).

You can verify cache and mail integration with the built-in debug route:

```bash
# Open in your browser or curl:
http://localhost:8000/debug/test-cache-mail

# Example using curl:
curl http://localhost:8000/debug/test-cache-mail
```

This route is defined in `Sim-Sanctum-Api/routes/web.php` and handled by `App\Http\Controllers\TestController@check`. It returns JSON with `cache_key`, `cache_value`, `cache_driver`, and `mail` status.

## Production (DockerFile) 🚀

Build the production image from the API Dockerfile:

```bash
# Build production Docker image
docker build -t docker-poc ./Sim-Sanctum-Api/
```

Example run (adjust values as needed):


```bash
# Expose the app on host port 8080 and make the host reachable as host.docker.internal
docker run --rm -d -p 8080:80 \
  --add-host=host.docker.internal:host-gateway \
  docker-poc
```

---