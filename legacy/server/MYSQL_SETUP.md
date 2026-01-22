# MySQL Database Setup

## Vereisten

- MySQL server geïnstalleerd en draaiend
- Database toegangsgegevens (host, user, password)

## Installatie

1. **Maak een database aan** (optioneel - wordt automatisch aangemaakt):
   ```sql
   CREATE DATABASE olijfboom;
   ```

2. **Configureer database instellingen:**

   Kopieer `server/.env.example` naar `server/.env` en pas aan:
   ```
   DB_HOST=localhost
   DB_USER=root
   DB_PASSWORD=jouw_wachtwoord
   DB_NAME=olijfboom
   ```

   Of pas de waarden aan in `server/db.js` direct.

3. **Start de server:**
   ```bash
   cd server
   npm install
   node server.js
   ```

   De tabellen worden automatisch aangemaakt bij de eerste start.

## Laragon gebruikers

Als je Laragon gebruikt, zijn de standaard instellingen:
- Host: `localhost`
- User: `root`
- Password: (meestal leeg)
- Database: `olijfboom` (wordt automatisch aangemaakt)

Je hoeft alleen de database naam aan te passen in `server/db.js` of via environment variabelen.

## Troubleshooting

**Connection refused:**
- Controleer of MySQL server draait
- Controleer host en poort (standaard 3306)

**Access denied:**
- Controleer gebruikersnaam en wachtwoord
- Zorg dat de gebruiker rechten heeft om databases aan te maken

**Database not found:**
- De database wordt automatisch aangemaakt, maar als dit niet werkt:
  - Maak handmatig aan: `CREATE DATABASE olijfboom;`
  - Of pas de database naam aan in de configuratie

