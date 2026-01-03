import express from 'express';
import db from '../db.js';

const router = express.Router();

// Create donation (public)
router.post('/', async (req, res) => {
  try {
    const { teamId, amount } = req.body;

    if (!teamId || !amount) {
      return res.status(400).json({ error: 'Team and amount required' });
    }

    const donationAmount = parseFloat(amount);
    if (isNaN(donationAmount) || donationAmount < 1) {
      return res.status(400).json({ error: 'Amount must be at least €1' });
    }

    // Verify team exists
    const team = await db.get('SELECT id FROM teams WHERE id = ?', [teamId]);
    if (!team) {
      return res.status(404).json({ error: 'Team not found' });
    }

    await db.run(
      'INSERT INTO donations (team_id, amount) VALUES (?, ?)',
      [teamId, donationAmount]
    );

    res.json({ success: true });
  } catch (error) {
    console.error('Create donation error:', error);
    res.status(500).json({ error: 'Failed to create donation' });
  }
});

export default router;
