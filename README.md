# Flower Store

A flower store management SPA built with Laravel + Vue 3.

## Tech Stack

| Layer | Technology |
|-------|-----------|
| Backend | Laravel 12 (PHP 8.2+) |
| Frontend | Vue 3 (Options API) + Vue Router 5 |
| Styling | TailwindCSS v4 |
| Database | MySQL |
| Build | Vite 7 |
| HTTP | Axios |

## System Architecture

```
Browser (Vue SPA) ──HTTP/JSON──▶ Laravel API ──Eloquent──▶ MySQL
        ◀───────────────────────── REST/JSON ◀────────────
```

- **Laravel** serves as a RESTful JSON API under `/api/v1/`
- **Vue 3 SPA** handles all UI rendering via Vue Router
- A single catch-all web route (`/{any?}`) serves the SPA shell
- No authentication — customer records are data, not login accounts

## System Design

### Database Schema
- **users** — id, first_name, last_name, email_address, mobile_number, address, status (active/inactive), timestamps
- **products** — id, product_name, product_description, quantity, price, status (enabled/disabled), timestamps
- **orders** — id, product_id (FK), user_id (FK), price, timestamps

### API Endpoints (all under `/api/v1/`)
| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | /products | List products (supports sort, search, include_disabled, paginate 7) |
| POST | /products | Create product |
| PUT | /products/{id} | Update product |
| PATCH | /products/{id}/toggle-status | Enable/disable product |
| GET | /orders | List orders (supports sort, search, paginate 7, grand total) |

### Frontend Routes
| Path | Page | Features |
|------|------|----------|
| / | Redirects → /products | — |
| /products | Product CRUD | Add/edit products, enable/disable, search, sort, pagination |
| /orders | Order listing | View orders with page total + grand total, search, sort, pagination |

## How to Run the App

### Prerequisites
- PHP 8.2+
- Composer
- Node.js + pnpm
- MySQL

### Setup

```bash
# 1. Install PHP dependencies
composer install

# 2. Install frontend dependencies
pnpm install

# 3. Configure environment
cp .env.example .env
# Edit .env with your MySQL credentials (DB_DATABASE, DB_USERNAME, DB_PASSWORD)

# 4. Generate app key
php artisan key:generate

# 5. Run migrations and seeders (creates 10 users, 15 products, 20 orders)
php artisan migrate --seed

# 6. Build frontend assets for production
npm run build

# 7. Start the server
php artisan serve

# (Optional) In a second terminal, run Vite for hot-reload during development:
npm run dev
```

Open `http://localhost:8000` in your browser.

## Testing the API Endpoints

### Using the included api.http file (VS Code REST Client)

1. Install the [REST Client](https://marketplace.visualstudio.com/items?itemName=humao.rest-client) extension
2. Open `api.http`
3. Ensure the server is running (`php artisan serve`)
4. Click **Send Request** above any endpoint

| # | Request | Description |
|---|---------|-------------|
| 1 | `GET /api/v1/products` | List enabled products |
| 2 | `GET /api/v1/products?include_disabled=true` | List all products |
| 3 | `POST /api/v1/products` | Create a new product |
| 4 | `PUT /api/v1/products/1` | Update a product |
| 5 | `PATCH /api/v1/products/1/toggle-status` | Toggle product status |
| 6 | `GET /api/v1/orders` | List all orders |