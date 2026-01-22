# README Nathan

## Projectstructuur

```
/olijfboom
  /server         ← backend (Node.js/Express)
  /src            ← frontend (React/Vite)
  package.json    ← frontend config
  vite.config.ts  ← frontend config
  ...
```

---

## 1. Backend installeren en starten
**Pad:**  `c:\laragon\www\olijfboom\server`

**Commando’s:**
```sh
cd c:\laragon\www\olijfboom\server
npm install         # Installeer alle Node.js dependencies
npm run dev         # Start de backend op http://localhost:3001
```

---

## 2. Frontend installeren en starten
**Pad:**  `c:\laragon\www\olijfboom`

**Commando’s:**
```sh
cd c:\laragon\www\olijfboom
npm install         # Installeer alle frontend dependencies
npm run dev         # Start de Vite dev server op http://localhost:5173
```

---

## 3. Database instellen
- MySQL database `olijfboom` aanmaken.
- Tabellen worden automatisch aangemaakt door backend bij eerste run.
- Database-gegevens instellen via environment variables of `.env` bestand in `/server`:
  ```
  DB_HOST=localhost
  DB_USER=root
  DB_PASS=...
  DB_NAME=olijfboom
  ```

---

## 4. CORS oplossen
- In `server/server.js` wordt het `cors`-pakket gebruikt:
  ```js
  import cors from 'cors';
  app.use(cors());
  ```

---

## 5. Testdata toevoegen
- In MySQL een donatie toevoegen zodat de boom lichten toont:
  ```sql
  INSERT INTO donations (team_id, amount) VALUES (1, 10000);
  ```

---

## 6. Frontend API URL
- In `src/context/AuthContext.tsx` wordt de API URL bepaald:
  ```js
  const API_URL = import.meta.env.VITE_API_URL || 'http://localhost:3001';
  ```
- Lokaal werkt dit automatisch met `localhost:3001`.

---

## 7. Resultaat
- Frontend bereikbaar op: [http://localhost:5173](http://localhost:5173)
- Backend bereikbaar op: [http://localhost:3001](http://localhost:3001)
- Frontend communiceert met backend via API calls.

---

**Vragen? Vraag het Nathan of check deze README!**
