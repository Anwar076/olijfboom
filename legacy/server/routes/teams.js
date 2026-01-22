import express from 'express';
import db from '../db.js';
import { authenticateToken, requireAdmin } from '../middleware/auth.js';
import crypto from 'crypto';

const router = express.Router({ mergeParams: true });

// Get all teams (public, for homepage) - with pagination support
router.get('/', async (req, res) => {
  try {
    const limit = parseInt(req.query.limit) || 100;
    const offset = parseInt(req.query.offset) || 0;

    const teams = await db.all(`
      SELECT 
        t.id, 
        t.name, 
        t.target_label,
        t.target_amount,
        COALESCE(SUM(d.amount), 0) as team_total
      FROM teams t
      LEFT JOIN donations d ON t.id = d.team_id
      GROUP BY t.id, t.name, t.target_label, t.target_amount
      ORDER BY team_total DESC
      LIMIT ${limit} OFFSET ${offset}
    `);

    const teamsWithStatus = teams.map(team => {
      const teamTotal = parseFloat(team.team_total) || 0;
      const targetAmount = parseFloat(team.target_amount) || 0;
      const lampStatus = teamTotal >= targetAmount;
      const progressRatio = targetAmount > 0 ? Math.min((teamTotal / targetAmount) * 100, 100) : 0;

      return {
        id: team.id,
        name: team.name,
        targetLabel: team.target_label,
        targetAmount: targetAmount,
        teamTotal: teamTotal,
        lampStatus: lampStatus,
        progressRatio: progressRatio
      };
    });

    res.json(teamsWithStatus);
  } catch (error) {
    console.error('Get all teams error:', error);
    console.error('Error stack:', error.stack);
    res.status(500).json({ error: 'Failed to get teams', details: error.message });
  }
});

// Get team details (public) - MUST come before /:id route
router.get('/:id/public', async (req, res) => {
  try {
    const teamId = req.params.id;
    console.log('GET /api/teams/:id/public - teamId:', teamId);
    const team = await db.get('SELECT id, name, description, target_label, target_amount FROM teams WHERE id = ?', [teamId]);
    
    if (!team) {
      return res.status(404).json({ error: 'Team not found' });
    }

    // Get members (names only, public view)
    const members = await db.all(
      `SELECT u.name
       FROM team_members tm
       JOIN users u ON tm.user_id = u.id
       WHERE tm.team_id = ?
       ORDER BY tm.created_at`,
      [teamId]
    );

    // Calculate total raised from donations
    const totalResult = await db.get(
      'SELECT COALESCE(SUM(amount), 0) as total FROM donations WHERE team_id = ?',
      [teamId]
    );
    const teamTotal = parseFloat(totalResult.total) || 0;
    const targetAmount = parseFloat(team.target_amount) || 0;
    const lampStatus = teamTotal >= targetAmount;
    const progressRatio = targetAmount > 0 ? Math.min((teamTotal / targetAmount) * 100, 100) : 0;

    res.json({
      id: team.id,
      name: team.name,
      description: team.description,
      targetLabel: team.target_label,
      targetAmount: targetAmount,
      teamTotal: teamTotal,
      lampStatus: lampStatus,
      progressRatio: progressRatio,
      members: members.map(m => m.name)
    });
  } catch (error) {
    console.error('Get team public error:', error);
    res.status(500).json({ error: 'Failed to get team' });
  }
});

// Get team details (admin dashboard)
router.get('/:id', authenticateToken, async (req, res) => {
  try {
    const teamId = req.params.id;
    const team = await db.get('SELECT * FROM teams WHERE id = ?', [teamId]);
    
    if (!team) {
      return res.status(404).json({ error: 'Team not found' });
    }

    // Get members (for admin view)
    const members = await db.all(
      `SELECT tm.id, u.id as user_id, u.name, u.email, u.role
       FROM team_members tm
       JOIN users u ON tm.user_id = u.id
       WHERE tm.team_id = ?
       ORDER BY tm.created_at`,
      [teamId]
    );

    // Calculate total raised from donations
    const totalResult = await db.get(
      'SELECT COALESCE(SUM(amount), 0) as total FROM donations WHERE team_id = ?',
      [teamId]
    );
    const teamTotal = parseFloat(totalResult.total) || 0;
    const targetAmount = parseFloat(team.target_amount) || 0;
    const lampStatus = teamTotal >= targetAmount;
    const progressRatio = targetAmount > 0 ? Math.min((teamTotal / targetAmount) * 100, 100) : 0;

    res.json({
      ...team,
      members,
      teamTotal: teamTotal,
      lampStatus: lampStatus,
      progressRatio: progressRatio
    });
  } catch (error) {
    console.error('Get team error:', error);
    res.status(500).json({ error: 'Failed to get team' });
  }
});

// Create invite (admin only)
router.post('/:id/invites', authenticateToken, requireAdmin, async (req, res) => {
  try {
    const teamId = req.params.id;
    
    // Verify user is admin of this team
    const team = await db.get('SELECT created_by_user_id FROM teams WHERE id = ?', [teamId]);
    if (!team || team.created_by_user_id !== req.user.id) {
      return res.status(403).json({ error: 'Not authorized for this team' });
    }

    // Generate token
    const token = crypto.randomBytes(32).toString('hex');

    await db.run(
      'INSERT INTO invites (team_id, token, created_by_user_id, expires_at) VALUES (?, ?, ?, DATE_ADD(NOW(), INTERVAL 30 DAY))',
      [teamId, token, req.user.id]
    );

    const inviteUrl = `http://localhost:5173/invite/${token}`;

    res.json({ token, inviteUrl });
  } catch (error) {
    console.error('Create invite error:', error);
    res.status(500).json({ error: 'Failed to create invite' });
  }
});

// Add member manually (admin only)
router.post('/:id/members', authenticateToken, requireAdmin, async (req, res) => {
  try {
    const teamId = req.params.id;
    const { name, email } = req.body;

    if (!name || !email) {
      return res.status(400).json({ error: 'Name and email required' });
    }

    // Verify user is admin of this team
    const team = await db.get('SELECT created_by_user_id FROM teams WHERE id = ?', [teamId]);
    if (!team || team.created_by_user_id !== req.user.id) {
      return res.status(403).json({ error: 'Not authorized for this team' });
    }

    // Check if user exists, if not create one
    let user = await db.get('SELECT id FROM users WHERE email = ?', [email]);
    
    if (!user) {
      const bcrypt = (await import('bcrypt')).default;
      const tempHash = await bcrypt.hash(crypto.randomBytes(16).toString('hex'), 10);
      const result = await db.run(
        'INSERT INTO users (name, email, password_hash, role) VALUES (?, ?, ?, ?)',
        [name, email, tempHash, 'member']
      );
      user = { id: result.lastID };
    }

    // Check if already member
    const existing = await db.get(
      'SELECT id FROM team_members WHERE team_id = ? AND user_id = ?',
      [teamId, user.id]
    );
    if (existing) {
      return res.status(400).json({ error: 'User is already a member' });
    }

    // Add to team
    await db.run(
      'INSERT INTO team_members (team_id, user_id) VALUES (?, ?)',
      [teamId, user.id]
    );

    const member = await db.get(
      `SELECT tm.id, u.id as user_id, u.name, u.email, u.role
       FROM team_members tm
       JOIN users u ON tm.user_id = u.id
       WHERE tm.team_id = ? AND tm.user_id = ?`,
      [teamId, user.id]
    );

    res.json(member);
  } catch (error) {
    console.error('Add member error:', error);
    res.status(500).json({ error: 'Failed to add member' });
  }
});

// Delete member (admin only)
router.delete('/:id/members/:memberId', authenticateToken, requireAdmin, async (req, res) => {
  try {
    const { id: teamId, memberId } = req.params;

    // Verify user is admin of this team
    const team = await db.get('SELECT created_by_user_id FROM teams WHERE id = ?', [teamId]);
    if (!team || team.created_by_user_id !== req.user.id) {
      return res.status(403).json({ error: 'Not authorized for this team' });
    }

    await db.run('DELETE FROM team_members WHERE id = ?', [memberId]);

    res.json({ success: true });
  } catch (error) {
    console.error('Delete member error:', error);
    res.status(500).json({ error: 'Failed to delete member' });
  }
});

export default router;
