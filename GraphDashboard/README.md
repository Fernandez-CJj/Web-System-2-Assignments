# GraphDashboard

GraphDashboard is a Laravel sales analytics assignment built with Laravel Breeze, Blade, Tailwind CSS, Vite, and Chart.js. The app includes authentication, seeded sales data, KPI cards, a monthly revenue/orders chart, a channel mix chart, and a regional revenue table.

## Features

- Login and registration through Laravel Breeze
- Seeded demo analyst account
- Monthly sales performance chart with revenue and order volume
- Doughnut chart for revenue by channel
- Regional breakdown sorted by revenue
- Feature test coverage for the dashboard route and chart view

## Demo Login

- Email: `test@example.com`
- Password: `password`

## Setup

1. Install PHP dependencies:

```bash
composer install
```

2. Install JavaScript dependencies:

```bash
npm install
```

3. Create and configure the environment file:

```bash
cp .env.example .env
php artisan key:generate
```

4. Create the MySQL database configured in `.env`:

```sql
CREATE DATABASE graphdashboard;
```

5. Run migrations and seed the demo data:

```bash
php artisan migrate --seed
```

6. Build the frontend assets:

```bash
npm run build
```

7. Start the local server:

```bash
php artisan serve
```

Open `http://127.0.0.1:8000`, log in with the demo credentials, and visit `/dashboard`.

## Development

Use Vite while working on the frontend:

```bash
npm run dev
```

Run the automated tests:

```bash
php artisan test
```

The dashboard feature test is in `tests/Feature/DashboardChartTest.php`.
