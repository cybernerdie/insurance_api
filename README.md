# Travel Insurance Quotation API

A REST API for generating travel insurance quotations, with a simple frontend to interact with it.

## Stack

- PHP 8.4
- Laravel 13
- MySQL
- JWT Auth
- Spatie Laravel Data

## Setup

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan jwt:secret
```

Update `.env` with your database credentials, then:

```bash
php artisan migrate
npm install && npm run build
```

## Running locally

```bash
composer dev
```

This starts the PHP server and Vite dev server.

## API

All requests to protected endpoints require:

```
Content-Type: application/json
Authorization: Bearer <token>
```

| Method | Endpoint | Auth | Description |
|--------|----------|------|-------------|
| POST | `/api/v1/register` | No | Register a new user |
| POST | `/api/v1/login` | No | Login and receive a JWT token |
| POST | `/api/v1/logout` | Yes | Invalidate the current token |
| POST | `/api/v1/quotation` | Yes | Generate a quotation |

### Quotation request

```json
{
    "age": [28, 35],
    "currency_id": "EUR",
    "start_date": "2026-10-01",
    "end_date": "2026-10-30"
}
```

### Quotation response

```json
{
    "quotation_id": 1,
    "total": "117.00",
    "currency_id": "EUR"
}
```

## Testing

```bash
composer test
```
