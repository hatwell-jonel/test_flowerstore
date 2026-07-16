# Flower Store — Task Checklist

## Goal
Build a Laravel + Vue.js single-page app for a flower store with product CRUD and order listing.

## Tech
- Laravel 12 + Vue 3 (via Vite)
- MySQL (for production-like env) or SQLite (dev/testing)
- Vue Router for SPA navigation

---

## Phase 1 — Database & Models

### 1.1 Database Migrations
- [x] **Users** — edit existing `create_users_table.php`:
  - Replace `name` → `first_name` (string) + `last_name` (string)
  - Replace `email` → `email_address` (string, unique)
  - Add `mobile_number` (string), `address` (text), `status` (tinyInteger, default 1)
  - Drop `password`, `email_verified_at`, `remember_token`
  - Remove `password_reset_tokens` and `sessions` tables entirely (no auth)
- [x] **Products** — new `create_products_table.php`:
  - id, product_name, product_description (text), quantity (integer), price (decimal 10,2), timestamps, status (tinyInteger, default 1)
- [x] **Orders** — new `create_orders_table.php`:
  - id, product_id (FK→products), user_id (FK→users), price (decimal 10,2), timestamps

### 1.2 Models
- [x] **User** — update fillable: first_name, last_name, email_address, mobile_number, address, status
  - Removed auth traits (Notifiable, Auth password/hidden/casts)
  - Added `orders()` hasMany relation
- [x] **Product** — created with fillable, price/quantity casts, `orders()` hasMany
- [x] **Order** — created with fillable, price cast, `belongsTo(Product)` + `belongsTo(User)`

### 1.3 Seeders
- [x] **UserSeeder** — 10 dummy users via updated UserFactory
- [x] **ProductSeeder** — 15 flower products (Rose, Tulip, Lily, etc.)
- [x] **OrderSeeder** — 20 dummy orders linking random users & products
- [x] **DatabaseSeeder** — calls UserSeeder → ProductSeeder → OrderSeeder

---

## Phase 2 — Backend API

### 2.1 API Routes (`routes/api.php`)
- [x] `GET    /api/products`       — `ProductController@index`
- [x] `POST   /api/products`       — `ProductController@store`
- [x] `PUT    /api/products/{product}` — `ProductController@update`
- [x] `PATCH  /api/products/{product}/toggle-status` — `ProductController@toggleStatus`
- [x] `GET    /api/orders`         — `OrderController@index`
- [x] Registered in `bootstrap/app.php` with `api:` entry

### 2.2 Controllers
- [x] **ProductController** — index (with `include_disabled` query), store, update, toggleStatus
- [x] **OrderController** — index (eager-loads product name)

### 2.3 Form Requests / Validation
- [x] Skipped — inline validation inside controllers instead (simpler for this project)

---

## Phase 3 — Frontend (Vue 3 SPA)

### 3.1 Setup
- [x] Installed vue@3, vue-router@4, @vitejs/plugin-vue
- [x] Updated `vite.config.js` with Vue plugin
- [x] Created `resources/js/app.js` — Vue mount entrypoint
- [x] Created `resources/js/router/index.js` — /products and /orders routes
- [x] Created `resources/js/App.vue` — tab navigation + router-view
- [x] Created `resources/js/components/Products.vue` — CRUD table + modal
- [x] Created `resources/js/components/Orders.vue` — order table + summary

### 3.2 Products Page
- [x] Data table: Product Name | Description | Price | Status | Actions
- [x] Add / Edit modal form with validation (required fields, min values)
- [x] Enable/Disable toggle per row

### 3.3 Orders Page
- [x] Data table: Order ID | Product Name | Price
- [x] Summary footer: total orders count + total price sum

### 3.4 Views
- [x] `resources/views/welcome.blade.php` — minimal SPA shell with `<div id="app">`

---

## Phase 4 — Polish & Git

### 4.1 Verification
- [ ] `./vendor/bin/pint` — Laravel Pint formatting
- [ ] `php artisan test` — run PHPUnit tests
- [ ] `npm run build` — Vite production build succeeds

### 4.2 Git
- [ ] `rm -rf .opencode/node_modules .opencode/package*` (clean opencode artifacts)
- [ ] Initialize git repo
- [ ] `.gitignore` — already handles vendor, node_modules, .env
- [ ] `git add . && git commit -m "Initial commit: Laravel + Vue flower store SPA"`
- [ ] Push to preferred remote (GitHub/GitLab/Bitbucket)

---

## Notes
- No real order processing — dummy data only
- Use in-memory SQLite for tests (already configured in `phpunit.xml`)
- MySQL for actual dev env (update `.env` DB_* values accordingly)
- Tailwind CSS v4 available for styling
