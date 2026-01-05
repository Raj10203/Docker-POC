## Docker: Using Composer & Artisan via Docker Compose 🔧

If your host machine doesn't have PHP or Composer installed, you can use the project's Docker Compose services. The compose file defines the helpful services: `composer`, `artisan`, `php`, `server`, `mysql`.

### Install dependencies

```bash
# Install composer dependencies
docker-compose run --rm composer install

# If you see platform requirement errors:
docker-compose run --rm composer install --ignore-platform-reqs
```

### Run Artisan

The repo provides an `artisan` service that runs `php /var/www/html/artisan`, so any Artisan command works directly:

```bash
# Run migrations
docker-compose run --rm artisan migrate

# Run a command
docker-compose run --rm artisan <command>

# Or via the php service:
docker-compose run --rm php php artisan migrate
```

### Start the application

```bash
# Build and start all services in detached mode
docker-compose up -d --build

# Or start specific services
docker-compose up -d --build server php mysql
```

### Tips & Troubleshooting

- Use `--rm` to remove the temporary container after the command finishes.
- If you get permission errors (e.g. with `storage/` or `bootstrap/cache`):

```bash
docker-compose run --rm php chown -R $(id -u):$(id -g) storage bootstrap/cache
```

- Install a package with Composer:

```bash
docker-compose run --rm composer require vendor/package
```

- Run tests:

```bash
docker-compose run --rm php ./vendor/bin/phpunit
```

- If Composer fails for missing PHP extensions, add the extension to the PHP Dockerfile or use `--ignore-platform-reqs` as a temporary workaround.

---

If you'd like, I can add convenience scripts (Makefile or npm scripts) to simplify these commands — tell me which commands you use most.


## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
