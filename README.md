# Poorti Cosmetic Center — Shop Website (Laravel)

A full shop-management website for **Poorti Cosmetic Center**
(Khanday Ray Ka Purwa, Binaur, Sachendi, Kanpur Nagar) built with Laravel.

## Features

- **Colorful storefront UI** — raspberry pink / violet / marigold theme with a
  gradient hero, gradient buttons, and a gradient brand name
- **Login / Signup with two roles**: `admin` and `customer` (phone number collected at signup)
- **Admin panel** — Add / View / Update / Delete products (image upload included)
- **Customer shopping flow** — add products to cart, adjust quantity, checkout
- **Automatic bill generation** — every checkout creates an itemized order with a total
- **Order workflow** — admin moves each order through **Pending → Confirmed → Packed
  → Delivered** (or Cancelled) with one click
- **WhatsApp invoice delivery** — the moment an order is marked **Delivered**, the
  itemized invoice is sent automatically to the customer's WhatsApp number; admin
  can also resend it manually any time from the bill page
- Custom-designed UI (Blade views only, no external theme)

---

## 1. What's included in this package

```
app/Http/Controllers/HomeController.php          -> public storefront
app/Http/Controllers/ProductController.php       -> admin product CRUD
app/Http/Controllers/CartController.php          -> add/update/remove cart items
app/Http/Controllers/CheckoutController.php       -> turns cart into an Order (bill)
app/Http/Controllers/OrderController.php          -> customer's own order history/bill
app/Http/Controllers/Admin/OrderController.php    -> admin: all orders, workflow, WhatsApp send
app/Http/Controllers/Auth/AuthController.php      -> login / register (+phone) / logout
app/Http/Middleware/EnsureUserIsAdmin.php         -> blocks non-admins from /admin/*
app/Services/CartService.php                      -> session-based cart logic
app/Services/WhatsAppService.php                  -> sends invoice via Twilio WhatsApp API
app/Models/{User,Product,Order,OrderItem}.php
database/migrations/...                           -> users.role/phone, products, orders, order_items, whatsapp_sent_at
database/seeders/{AdminUserSeeder,ProductSeeder,DatabaseSeeder}.php
database/poorti_cosmetic_center.sql                -> plain SQL for the products table
database/orders_and_roles.sql                      -> plain SQL for roles/phone + orders tables
config/services-twilio-snippet.php                -> snippet to merge into config/services.php
routes/web.php
resources/views/layouts/app.blade.php             -> shared layout (colorful, role-aware navbar/footer)
resources/views/home.blade.php                    -> storefront with Add to Cart
resources/views/auth/{login,register}.blade.php
resources/views/cart/index.blade.php
resources/views/orders/{index,show}.blade.php     -> "show" is the printable bill + admin workflow
resources/views/admin/orders/index.blade.php
resources/views/products/*.blade.php
```

This package contains the **application code only** — not the full Laravel
framework skeleton (that comes from Composer/Packagist). Follow the steps below
to drop it into a fresh Laravel install.

## 2. Requirements

- PHP 8.2+, Composer, MySQL/MariaDB
- (Optional, for WhatsApp sending) a free Twilio account

## 3. Setup steps

```bash
# 1. Create a fresh Laravel 11 project
composer create-project laravel/laravel poorti-cosmetic-center
cd poorti-cosmetic-center

# 2. Copy every folder from this package into the new project
#    (app/, database/, resources/, routes/, config/, .env.example), overwriting
#    app/Http/Controllers/Controller.php and app/Models/User.php.

# 3. Register the "admin" middleware alias.
#    Open bootstrap/app.php and edit the ->withMiddleware() block so it looks like:
```
```php
->withMiddleware(function (Middleware $middleware) {
    $middleware->alias([
        'admin' => \App\Http\Middleware\EnsureUserIsAdmin::class,
    ]);
})
```
```bash
# 4. Add the Twilio config block.
#    Open config/services.php and paste the array from
#    config/services-twilio-snippet.php into the existing return [ ... ] array.

# 5. Configure your database in .env
DB_DATABASE=poorti_cosmetic_center
DB_USERNAME=root
DB_PASSWORD=yourpassword

# 6. Generate app key
php artisan key:generate

# 7. Create the database, then run migrations + seeders
php artisan migrate --seed

#    (Alternative: import database/poorti_cosmetic_center.sql for the products
#     table, then database/orders_and_roles.sql for roles/phone/orders — only
#     use this path if you are not running `php artisan migrate` at all.)

# 8. Link storage (so uploaded product images are visible)
php artisan storage:link

# 9. Run the app
php artisan serve
```

Visit:
- **Storefront:** http://localhost:8000/
- **Admin panel:** http://localhost:8000/admin/products (redirects here automatically after admin login)

## 4. Default admin login

- **Email:** `admin@poorti.com`
- **Password:** `admin123`

Change this password immediately after your first login. Anyone who signs up
through **Sign Up** on the site becomes a `customer` automatically. To promote a
customer to admin later:

```bash
php artisan tinker
>>> \App\Models\User::where('email', 'someone@example.com')->update(['role' => 'admin']);
```

## 5. How ordering + WhatsApp invoicing works

1. A logged-in customer clicks **Add to Cart** on any product on the storefront.
2. They review/adjust quantities on the **Cart** page and click **Place Order & Generate Bill**.
3. This creates an `Order` + itemized `OrderItem` rows and reduces product stock automatically.
4. The customer is taken straight to their printable bill (`My Orders` → `View Bill`).
5. The admin opens the order under **Admin Panel → Bills** and clicks through the
   workflow: **Confirm Order → Mark as Packed → Mark as Delivered & Send Invoice**.
6. The instant an order is marked **Delivered**, the app calls Twilio's WhatsApp API
   and sends the itemized invoice straight to the customer's WhatsApp number — fully
   automatic, no manual step needed. Admin can also click **Resend Invoice on WhatsApp**
   at any time from the bill page.

### Setting up real WhatsApp sending (required for it to actually send)

WhatsApp sending needs a messaging provider — there's no way to send WhatsApp
messages "for free" straight from a server without one. This project is wired for
**Twilio's WhatsApp API**, the most common option:

1. Create a free account at https://www.twilio.com/whatsapp
2. Activate the WhatsApp Sandbox (instant, no approval wait) — Twilio gives you a
   sandbox number and a join code your test customers must send once via WhatsApp.
3. Copy your **Account SID**, **Auth Token**, and the sandbox **From** number into `.env`:
   ```
   TWILIO_SID=ACxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
   TWILIO_AUTH_TOKEN=your_auth_token
   TWILIO_WHATSAPP_FROM=whatsapp:+14155238886
   ```
4. Make sure customer phone numbers are saved in 10-digit Indian format (e.g.
   `9876543210`) — the app automatically prefixes `+91`. For other countries, ask
   customers to enter the full number with country code.
5. For production (no "join sandbox" step, and messages to any number), apply for
   a Twilio **WhatsApp Business Profile** — this requires business verification
   through Meta and takes a few days to be approved.

If Twilio isn't configured, marking an order "Delivered" still works — the app
just logs that the WhatsApp message couldn't be sent (visible in
`storage/logs/laravel.log`) instead of failing the request.

## 6. Notes

- Currency is displayed in ₹ (INR) throughout.
- The shop address in the footer/invoice is **Khanday Ray Ka Purwa, Binaur,
  Sachendi, Kanpur Nagar** — edit `resources/views/layouts/app.blade.php` and
  `resources/views/orders/show.blade.php` if it ever changes.
- Product images are uploaded to `storage/app/public/products`, served via the
  `storage:link` symlink from step 8.

## 7. Design

- Colors: raspberry pink (`#E0417B`), deep magenta (`#9C1F52`), violet (`#7B2CBF`),
  marigold gold (`#FFB200`), soft pink surface (`#FFE1EC`), cream paper (`#FFF8F3`)
- Fonts: **Cormorant Garamond** (headings, gradient brand name) + **Jost** (body)
- Signature elements: gradient hero, gradient buttons, a scalloped divider under
  the hero echoing bangle/jewellery motifs
