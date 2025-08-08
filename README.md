# Currency Converter (minimal PHP project)

Lightweight example repository containing:
- `/convert` HTTP endpoint (GET) at `/convert?from=EUR&to=USD&amount=100`
- Services, DTO, Value Objects, Dependency Injection configured via YAML
- Unit tests demonstrating mocking (PHPUnit)
- PHPStan (static analysis) and PHP-CS-Fixer (PSR-12) configs
- Docker + docker-compose setup to run the app and run the tools inside the container

## Quick start (with Docker)

Build & start the container (runs built-in PHP server):
```bash
docker compose up --build -d
```

Open the endpoint:
```
http://localhost:8000/convert?from=EUR&to=USD&amount=100
```

Run phpstan:
```bash
docker compose run --rm php composer phpstan
```

Run php-cs-fixer (check):
```bash
docker compose run --rm php composer cs-check
```

Run php-cs-fixer (fix files):
```bash
docker compose run --rm php composer cs-fix
```

Run unit tests:
```bash
docker compose run --rm php composer test
```

## Notes
- The service wiring is done in `public/index.php` by reading `config/services.yaml` via `symfony/yaml`.
- Rates are declared in `config/packages/currency_rates.yaml`.
- This is a minimal, easy-to-run example meant for the coding task; it is **not** a full Symfony app.
