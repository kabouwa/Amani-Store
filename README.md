# Amani Store

<p align="center"> <img src="https://raw.githubusercontent.com/kabouwa/Amani-Store/main/public/images/logo/amani-h.png" alt="Amani Store" width="500"> </p>

A real e-commerce project — **Amani Store** — built with Laravel 13 using server-side rendering (Blade). The admin panel is the main focus so far and is fully functional; the public-facing storefront is still in progress.

## Status

- ✅ **Admin panel** — built out and functional (auth, dashboard, categories, products, customers, orders, pickups, shipments, user management)
- 🚧 **Public storefront** — in progress (home, category listing, product listing/detail, checkout flow exist as a first pass)

## Stack

- **Backend:** Laravel 13 (PHP 8.3)
- **Views:** Blade (SSR), component-based (`x-` components)
- **Styling:** Tailwind CSS 4, with a custom `amani` brand color (`#7A1220`)
- **JS:** jQuery, Select2 (searchable selects), Font Awesome + Bootstrap Icons
- **Fonts:** Playfair Display
- **Build tool:** Vite

## Admin Panel Features

- **Authentication** — email + password, followed by an **email OTP verification step** (10-minute expiry, hashed OTP stored in session)
- **Dashboard** — KPIs overview
- **Categories** — CRUD with soft deletes (deleting a category cascades to its products)
- **Products** — creation form with drag-and-drop image upload, multiple images with a "primary image" flag, auto-generated slug from title, active/inactive toggle, per-product sales stats (`sales_count`, `total_sales`)
- **Customers** — table view, soft deletes (cascades to their order)
- **Orders** — detail page (3-column layout), soft deletes (cascades to order items), **policy-protected**: an order can't be edited or deleted once it's picked up
- **Pickups** — pickup scheduling/management
- **Shipments** — integrated with the **Sendit** delivery API (bearer token auth, token cached for 50 minutes) to create/cancel shipments
- **User management** — admin users can only update/delete their **own** account (enforced via policy)
- **UI details** — collapsible sidebar with localStorage persistence, dark/light mode, French-language interface (`lang/fr/*`)

## Data Model

- **Category** → has many **Products**
- **Product** → belongs to Category, has many **ProductImages** (one marked primary), has many **OrderItems**; slug auto-generated on save
- **Customer** → has one **Order**
- **Order** → belongs to Customer, has many **OrderItems**; identified by `order_code` (route-bound by `code`); tracks `shipping_agency`, `status`, `is_picked`, `sendit_code`
- **OrderItem** → belongs to Order and Product; computes `profit` and `total` per line
- **User** (admin) → slug auto-generated from name; login by slug route

Deleted images are moved to a `products/trash/` folder rather than hard-deleted from disk.

## Project Structure

```
app/
  Http/Controllers/
    Admin/          # Admin panel controllers (Auth, Dashboard, Category, Customer, Order, Pickup, Product, ProductImages, Shipment, User)
    *.php           # Public-facing controllers (Product, Category, Order, PublicController)
  Http/Requests/     # Form validation (Order, Product, User)
  Mail/              # AuthOtpMail
  Models/            # Category, Customer, Order, OrderItem, Product, ProductImages, User
  Policies/          # OrderPolicy, UserPolicy
  Services/          # SenditService, SenditDeliveriesService, SenditPickupService

resources/
  views/admin/       # Admin Blade views (login, dashboard, categories, customers, products, orders, pickups, users)
  views/             # Public Blade views (products, categories, orders, home)
  views/components/  # Shared components (layouts, alert, modals, product-card, toolbars, order/pickup status badges)
  js/admin/          # Admin JS modules (categories, layout, otp, pickups, product-images)
  js/public/         # Public-facing JS
  css/admin/         # Admin-specific styles

routes/web.php       # admin.* routes (prefixed /admin, auth-protected) + public routes
```

## Setup

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
composer run dev
```

`composer run dev` runs the Laravel server, queue listener, log viewer (`pail`), and Vite concurrently.

## Notes

This is a real, ongoing project — not a tutorial or throwaway build. Admin side is solid; the public storefront (browsing/checkout experience customers actually see) is the current focus going forward.
