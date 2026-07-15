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
- [ ] **User** — update fillable: first_name, last_name, email_address, mobile_number, address, status
- [ ] **Product** — create with fillable: product_name, product_description, quantity, price, status
- [ ] **Order** — create with fillable: product_id, user_id, price
  - Relationships: `belongsTo(Product)`, `belongsTo(User)`

### 1.3 Seeders
- [ ] **User seeder** — 5–10 dummy users
- [ ] **Product seeder** — 10–15 dummy flower products
- [ ] **Order seeder** — 15–20 dummy orders referencing products & users
- [ ] **DatabaseSeeder** — call all seeders

---

## Phase 2 — Backend API

### 2.1 API Routes (`routes/api.php`)
- [ ] `GET    /api/products`       — list all products (with optional `?include_disabled=1`)
- [ ] `POST   /api/products`       — create product
- [ ] `PUT    /api/products/{id}`  — update product
- [ ] `PATCH  /api/products/{id}/toggle-status` — toggle enabled/disabled
- [ ] `GET    /api/orders`         — list orders with product name, user info

### 2.2 Controllers
- [ ] **ProductController** — index, store, update, toggleStatus
- [ ] **OrderController** — index (with eager-loaded product name)

### 2.3 Form Requests / Validation
- [ ] `StoreProductRequest` — product_name required|string|max:255, product_description required|string, quantity required|integer|min:0, price required|numeric|min:0
- [ ] `UpdateProductRequest` — same as store but all optional

---

## Phase 3 — Frontend (Vue 3 SPA)

### 3.1 Setup
- [ ] Install Vue 3 + Vue Router via npm
- [ ] Create `resources/js/app.js` — mount Vue app
- [ ] Create `resources/js/router/index.js` — routes for Products and Orders
- [ ] Create `resources/js/App.vue` — root component with navigation (tab bar)
- [ ] Create `resources/js/components/Products.vue` — product list + CRUD modal
- [ ] Create `resources/js/components/Orders.vue` — order list with summary

### 3.2 Products Page
- [ ] Data table: Product Name | Description | Price | Status | Actions
- [ ] "Add Product" button → modal/form
- [ ] "Edit" button → same modal pre-filled
- [ ] Toggle (Enable/Disable) button per row
- [ ] Validation feedback

### 3.3 Orders Page
- [ ] Data table: Order ID | Product Name | Price
- [ ] Summary footer: total orders count, total price sum

### 3.4 Views
- [ ] `resources/views/welcome.blade.php` — update to serve the SPA (mount div + Vite directives)

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
