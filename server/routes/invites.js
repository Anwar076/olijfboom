import express from 'express';
import db from '../db.js';
import crypto from 'crypto';

const router = express.Router();

// Accept invite
router.post('/:token/accept', async (req, res) => {
  try {
    const { token } = req.params;
    const { name, email } = req.body;

    if (!name || !email) {
      return res.status(400).json({ error: 'Name and email required' });
    }

    // Get invite
    const invite = await db.get('SELECT * FROM invites WHERE token = ?', [token]);
    if (!invite) {
      return res.status(404).json({ error: 'Invalid invite token' });
    }

    if (invite.used_at) {
      return res.status(400).json({ error: 'Invite already used' });
    }

    if (invite.expires_at && new Date(invite.expires_at) < new Date()) {
      return res.status(400).json({ error: 'Invite expired' });
    }

    // Check if user exists with this email
    let user = await db.get('SELECT id FROM users WHERE email = ?', [email]);
    
    if (!user) {
      // Create new user (member, no password - cannot login)
      const bcrypt = (await import('bcrypt')).default;
      const tempHash = await bcrypt.hash(crypto.randomBytes(32).toString('hex'), 10);
      const userResult = await db.run(
        'INSERT INTO users (name, email, password_hash, role) VALUES (?, ?, ?, ?)',
        [name, email, tempHash, 'member']
      );
      user = { id: userResult.lastID };
    } else {
      // Update name if different
      await db.run('UPDATE users SET name = ? WHERE id = ?', [name, user.id]);
    }

    // Add to team if not already member
    const existingMember = await db.get(
      'SELECT id FROM team_members WHERE team_id = ? AND user_id = ?',
      [invite.team_id, user.id]
    );

    if (!existingMember) {
      await db.run(
        'INSERT INTO team_members (team_id, user_id) VALUES (?, ?)',
        [invite.team_id, user.id]
      );
    }

    // Mark invite as used
    await db.run('UPDATE invites SET used_at = NOW() WHERE token = ?', [token]);

    res.json({
      success: true,
      message: 'Je bent toegevoegd aan het team!'
    });
  } catch (error) {
    console.error('Accept invite error:', error);
    res.status(500).json({ error: 'Failed to accept invite' });
  }
});

// Get invite info (public)
router.get('/:token', async (req, res) => {
  try {
    const { token } = req.params;
    const invite = await db.get(
      `SELECT i.*, t.name as team_name
       FROM invites i
       JOIN teams t ON i.team_id = t.id
       WHERE i.token = ?`,
      [token]
    );

    if (!invite) {
      return res.status(404).json({ error: 'Invalid invite token' });
    }

    res.json({
      token: invite.token,
      teamName: invite.team_name,
      used: !!invite.used_at,
      expired: invite.expires_at ? new Date(invite.expires_at) < new Date() : false
    });
  } catch (error) {
    console.error('Get invite error:', error);
    res.status(500).json({ error: 'Failed to get invite' });
  }
});

export default router;
