import express from 'express';
import cors from 'cors';
import { initDatabase } from './db.js';
import authRoutes from './routes/auth.js';
import teamsRoutes from './routes/teams.js';
import invitesRoutes from './routes/invites.js';
import meRoutes from './routes/me.js';
import statsRoutes from './routes/stats.js';
import donationsRoutes from './routes/donations.js';
import lightsRoutes from './routes/lights.js';

const app = express();
const PORT = process.env.PORT || 3001;

// Middleware
app.use(cors());
app.use(express.json());

// Initialize database and start server
(async () => {
  try {
    await initDatabase();
    console.log('Database initialized');

    // Routes
    app.use('/api/auth', authRoutes);
    app.use('/api/teams', teamsRoutes);
    app.use('/api/invites', invitesRoutes);
    app.use('/api/me', meRoutes);
    app.use('/api/stats', statsRoutes);
    app.use('/api/donations', donationsRoutes);
    app.use('/api/lights', lightsRoutes);

    // Health check
    app.get('/api/health', (req, res) => {
      res.json({ status: 'ok' });
    });

    app.listen(PORT, () => {
      console.log(`Server running on http://localhost:${PORT}`);
    });
  } catch (error) {
    console.error('Failed to start server:', error);
    process.exit(1);
  }
})();

