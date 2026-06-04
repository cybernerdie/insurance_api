# Travel Insurance Quotation API

Built with Laravel 13, JWT auth, and a simple Blade/JS frontend.

## Stack

- PHP 8.4 / Laravel 13
- MySQL
- JWT Auth (tymon/jwt-auth)
- Spatie Laravel Data

## Setup

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan jwt:secret
```

Fill in your DB credentials in `.env`, then:

```bash
php artisan migrate
npm install && npm run build
```

## Running locally

```bash
composer dev
```

Starts the Laravel dev server and Vite together.

## API

Protected endpoints need:

```
Content-Type: application/json
Authorization: Bearer <token>
```

| Method | Endpoint | Auth | Description |
|--------|----------|------|-------------|
| POST | `/api/v1/register` | No | Create an account |
| POST | `/api/v1/login` | No | Get a JWT token |
| POST | `/api/v1/logout` | Yes | Invalidate token |
| POST | `/api/v1/quotation` | Yes | Get a quote |

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

## Assumptions

A few things weren't fully specified so I made some calls:

- **`age` is an array, not a comma-separated string** — the spec shows `"28,35"` but a JSON array is cleaner and avoids string parsing on the server.
- **Ages outside 18–70 are rejected** — the load table only covers that range so anything outside it gets a validation error.
- **Trip length is inclusive** — Oct 1 to Oct 30 = 30 days, which lines up with the worked example.
- **Start date can't be in the past** — doesn't make sense to insure a trip that's already happened.
- **Quotations are stored** — the spec returns a `quotation_id` which implies persistence. Each quotation is linked to the user who requested it.
- **Max 10 travellers** — the spec sets no upper limit, 10 felt reasonable for a single policy.

## Testing

```bash
composer test
```
