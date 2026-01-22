# Setup Instructions - Olijfboom van Licht (Laravel)

## Quick Start

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

- The donation flow is a placeholder; it stores a donation record and shows a confirmation.
- Light details are fetched via `/api/lights/{index}`.

