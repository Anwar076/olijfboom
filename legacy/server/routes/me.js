import express from 'express';
import db from '../db.js';
import { authenticateToken } from '../middleware/auth.js';

const router = express.Router();

// Get current user info
router.get('/', authenticateToken, async (req, res) => {
  try {
    const user = await db.get('SELECT id, name, email, role FROM users WHERE id = ?', [req.user.id]);
    
    if (!user) {
      return res.status(404).json({ error: 'User not found' });
    }

    // Get user's team
    const teamMember = await db.get(
      `SELECT tm.team_id, t.name as team_name, t.target_label, t.target_amount
       FROM team_members tm
       JOIN teams t ON tm.team_id = t.id
       WHERE tm.user_id = ?
       LIMIT 1`,
      [req.user.id]
    );

    res.json({
      ...user,
      team: teamMember ? {
        id: teamMember.team_id,
        name: teamMember.team_name,
        targetLabel: teamMember.target_label,
        targetAmount: teamMember.target_amount
      } : null
    });
  } catch (error) {
    console.error('Get me error:', error);
    res.status(500).json({ error: 'Failed to get user info' });
  }
});

export default router;
