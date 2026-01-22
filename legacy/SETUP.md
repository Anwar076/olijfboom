# Setup Instructions - Olijfboom van Licht MVP

## Quick Start

### 1. Install Frontend Dependencies
```bash
npm install
```

### 2. Install Backend Dependencies
```bash
cd server
npm install
cd ..
```

### 3. Start the Application

**Terminal 1 - Start Backend Server:**
```bash
cd server
npm run dev
```
Server runs on: `http://localhost:3001`

**Terminal 2 - Start Frontend:**
```bash
npm run dev
```
Frontend runs on: `http://localhost:5173`

### 4. Access the Application

Open your browser and navigate to: `http://localhost:5173`

## First Steps

1. **Create a Team:**
   - Click "Start een team" on the homepage
   - Fill in team details and admin account information
   - Submit the form

2. **Login:**
   - Use the admin credentials you just created
   - You'll be redirected to the dashboard

3. **Manage Your Team:**
   - Generate an invite link
   - Add members manually
   - Assign sponsor levels to members

4. **Join via Invite:**
   - Open the invite link in a new browser/incognito window
   - Fill in your name and password
   - You'll be added to the team

## Features

- ✅ Team creation with admin account
- ✅ Login/Logout
- ✅ Team dashboard
- ✅ Invite link generation
- ✅ Member management
- ✅ Sponsor level assignment
- ✅ Real-time statistics on homepage
- ✅ Olive tree visualization with lights

## Database

The SQLite database (`server/database.sqlite`) is automatically created on first server start. All tables are created automatically.

## Troubleshooting

**Port already in use:**
- Backend: Change PORT in `server/server.js` or use environment variable
- Frontend: Vite will automatically use the next available port

**Database errors:**
- Check MySQL is running
- Verify database credentials in `server/.env`
- Create database manually if needed: `CREATE DATABASE olijfboom;`
- Restart the server to recreate tables

**CORS errors:**
- Make sure backend is running on port 3001
- Check that `vite.config.ts` has the proxy configuration

## API Documentation

See `README.md` for API endpoint documentation.

