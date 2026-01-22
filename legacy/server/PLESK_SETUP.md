+# Database Setup voor Plesk/Savvii

## Stap 1: MySQL Database Aanmaken in Plesk

1. **Login in Plesk**
2. Ga naar je domein/website
3. Ga naar **"Databases"** in het menu
4. Klik op **"Add Database"**
5. Vul in:
   - **Database name**: `olijfboom` (of een andere naam)
   - **Database user**: Laat Plesk automatisch een gebruiker aanmaken (of kies zelf)
   - **Password**: Genereer een sterk wachtwoord
6. Noteer de volgende gegevens:
   - Database naam
   - Database gebruiker
   - Database wachtwoord
   - Database host (meestal `localhost` of een specifieke host zoals `localhost:3306`)

## Stap 2: Database Credentials Configureren

Je hebt 3 opties om de database credentials in te stellen:

### Optie A: Environment Variables (AANBEVOLEN)

Maak een `.env` bestand aan in de `server` folder:

```env
DB_HOST=localhost
DB_USER=jouw_database_gebruiker
DB_PASSWORD=jouw_database_wachtwoord
DB_NAME=olijfboom
PORT=3001
```

**Voor Node.js op Plesk/Savvii:**
- Gebruik de environment variables in je Node.js applicatie configuratie
- Of pas de `.env` file aan via SSH/File Manager

### Optie B: Direct in db.js aanpassen

Pas `server/db.js` aan (niet aanbevolen voor productie, maar werkt wel):

```javascript
const dbConfig = {
  host: 'localhost',  // Of de host die Plesk geeft
  user: 'jouw_database_gebruiker',
  password: 'jouw_database_wachtwoord',
  database: 'olijfboom',
  waitForConnections: true,
  connectionLimit: 10,
  queueLimit: 0
};
```

### Optie C: Via Plesk Environment Variables

In Plesk kun je environment variables instellen:
1. Ga naar je Node.js applicatie
2. Zoek naar "Environment Variables" of ".env"
3. Voeg toe:
   - `DB_HOST`
   - `DB_USER`
   - `DB_PASSWORD`
   - `DB_NAME`

## Stap 3: Database Tabellen Aanmaken

**BELANGRIJK:** In productie kun je meestal GEEN `CREATE DATABASE` uitvoeren. De database moet al bestaan (via Plesk).

### Via SSH (AANBEVOLEN):

1. **SSH in je server:**
   ```bash
   ssh gebruiker@jouw-domein.nl
   ```

2. **Ga naar je project folder:**
   ```bash
   cd /path/to/your/project/server
   ```

3. **Voer het init script uit:**
   ```bash
   npm run init-db
   ```
   
   Of met yarn:
   ```bash
   yarn init-db
   ```

### Via Node.js Applicatie:

Als je Node.js applicatie al draait, worden de tabellen automatisch aangemaakt bij de eerste start (via `initDatabase()` in `server.js`).

**LET OP:** Als je geen `CREATE DATABASE` rechten hebt, gebruik dan `init-production-db.js` in plaats van `reset-db.js`.

## Stap 4: Server Starten

1. **Zorg dat alle dependencies geïnstalleerd zijn:**
   ```bash
   npm install
   ```

2. **Start de server:**
   ```bash
   npm start
   ```
   
   Of in Plesk: Start je Node.js applicatie via de Plesk interface.

## Troubleshooting

### "Access denied for user"
- Controleer database gebruikersnaam en wachtwoord
- Zorg dat de gebruiker rechten heeft op de database

### "Can't connect to MySQL server"
- Controleer `DB_HOST` (meestal `localhost`, soms `127.0.0.1`)
- Controleer of MySQL draait
- Sommige hosts gebruiken een andere poort (bijv. `3307` in plaats van `3306`)

### "Unknown database"
- Zorg dat de database bestaat in Plesk
- Controleer de database naam spelling
- Gebruik `init-production-db.js` in plaats van `reset-db.js`

### "Table already exists"
- Dit is geen probleem, de tabellen bestaan al
- Als je opnieuw wilt beginnen, verwijder dan de tabellen handmatig via phpMyAdmin in Plesk

## Database Tabellen

De volgende tabellen worden aangemaakt:
- `users` - Gebruikers (admins en team members)
- `teams` - Teams met doelen
- `team_members` - Team lidmaatschappen
- `donations` - Donaties
- `invites` - Uitnodigingen voor teams

## Veiligheid

- **Gebruik sterke wachtwoorden** voor de database
- **Gebruik `.env` bestanden** en voeg ze toe aan `.gitignore`
- **Backup regelmatig** via Plesk backup functie
- **Gebruik HTTPS** voor je website

