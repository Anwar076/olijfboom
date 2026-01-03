# Olijfboom van Licht

Een premium one-page website voor de donatiecampagne van het Islamitisch Centrum Barendrecht, uitgebreid met team functionaliteit en authenticatie.

## Technologie

**Frontend:**
- React 18
- TypeScript
- TailwindCSS
- React Router
- Vite

**Backend:**
- Express.js
- MySQL
- JWT Authentication
- bcrypt

## Installatie

### 1. Frontend Dependencies

```bash
npm install
```

### 2. Backend Dependencies

```bash
cd server
npm install
```

## Gebruik

### Development (Twee terminals nodig)

**Terminal 1 - Backend Server:**
```bash
cd server
npm run dev
```
De server draait op `http://localhost:3001`

**Terminal 2 - Frontend:**
```bash
npm run dev
```
De website is beschikbaar op `http://localhost:5173`

### Production Build

**Frontend:**
```bash
npm run build
```

**Backend:**
```bash
cd server
npm start
```

## Functionaliteit

- ✅ Homepage met olijfboom visualisatie
- ✅ Team aanmaken met beheerder account
- ✅ Inloggen als beheerder of lid
- ✅ Dashboard voor teambeheer
- ✅ Uitnodigingslinks genereren
- ✅ Leden toevoegen en beheren
- ✅ Sponsor niveau toewijzen per lid
- ✅ Real-time statistieken op homepage

## Database

De applicatie gebruikt MySQL. Zorg ervoor dat MySQL is geïnstalleerd en draait.

**Database Setup:**

1. Maak een MySQL database aan (of gebruik een bestaande):
   ```sql
   CREATE DATABASE olijfboom;
   ```

2. Configureer database instellingen in `server/.env` (kopieer `.env.example` naar `.env`):
   ```
   DB_HOST=localhost
   DB_USER=root
   DB_PASSWORD=your_password
   DB_NAME=olijfboom
   ```

3. De tabellen worden automatisch aangemaakt bij de eerste start van de server.

## API Endpoints

- `POST /api/auth/register-admin` - Team + admin aanmaken
- `POST /api/auth/login` - Inloggen
- `GET /api/me` - Huidige gebruiker info
- `GET /api/teams` - Alle teams (public)
- `GET /api/teams/:id` - Team details
- `POST /api/teams/:id/invites` - Uitnodiging genereren (admin)
- `POST /api/invites/:token/accept` - Uitnodiging accepteren
- `POST /api/teams/:id/members` - Lid toevoegen (admin)
- `PATCH /api/teams/:id/members/:memberId` - Bijdrage updaten
- `DELETE /api/teams/:id/members/:memberId` - Lid verwijderen (admin)
- `GET /api/stats` - Globale statistieken (public)
