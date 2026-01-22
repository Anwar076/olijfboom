# Setup Instructions - Olijfboom van Licht (Laravel)

## Quick Start (Local)

### 1. Install PHP dependencies
```bash
composer install
```

### 2. Install frontend dependencies
```bash
npm install
```

### 3. Configure environment
```bash
copy .env.example .env
php artisan key:generate
```

Update the database settings in `.env`:
- `DB_CONNECTION=mysql`
- `DB_DATABASE=olijfboom`
- `DB_USERNAME=root`
- `DB_PASSWORD=`
- `MOLLIE_KEY=your_mollie_test_or_live_key`

### 4. Run migrations
```bash
php artisan migrate
```

### 5. Start the app

**Terminal 1 - Laravel:**
```bash
php artisan serve
```

**Terminal 2 - Vite (assets):**
```bash
npm run dev
```

App runs on: `http://localhost:8000`

## Production Setup

### 1. Install dependencies
```bash
composer install --no-dev --optimize-autoloader
npm install
npm run build
```

### 2. Configure environment
```bash
copy .env.example .env
php artisan key:generate
```

Update `.env`:
- `APP_ENV=production`
- `APP_DEBUG=false`
- `APP_URL=https://your-domain.tld`
- `DB_CONNECTION=mysql`
- `DB_DATABASE=olijfboom`
- `DB_USERNAME=your_db_user`
- `DB_PASSWORD=your_db_password`
- `MOLLIE_KEY=your_mollie_live_key`

### 3. Run migrations
```bash
php artisan migrate --force
```

### 4. Optimize caches
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 5. Web server
- Point your web server document root to `public/`
- Ensure PHP-FPM is enabled
- Set correct permissions for `storage/` and `bootstrap/cache/`

## First Steps

1. **Create a Team:**
   - Open the homepage and click "Maak een team aan" or go to `/teams/new`
   - Fill in team details and admin account information
   - Submit the form

2. **Login:**
   - Use the admin credentials you just created
   - You will be redirected to the dashboard

3. **Manage Your Team:**
   - Generate an invite link
   - Add members manually
   - Assign sponsor levels to members

4. **Join via Invite:**
   - Open the invite link
   - Fill in your name and email
   - You will be added to the team

## Features

- Team creation with admin account
- Login/Logout
- Team dashboard
- Invite link generation
- Member management
- Sponsor level assignment
- Real-time statistics on homepage
- Olive tree visualization with lights

## Notes

- Mollie handles the payment flow; donations are counted after payment succeeds.
- Light details are fetched via `/api/lights/{index}`.

