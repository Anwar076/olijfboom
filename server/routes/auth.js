import express from 'express';
import bcrypt from 'bcrypt';
import jwt from 'jsonwebtoken';
import db from '../db.js';
import { JWT_SECRET } from '../middleware/auth.js';

const router = express.Router();

// Register admin + create team
router.post('/register-admin', async (req, res) => {
  try {
    const { name, email, password, teamName, teamDescription, targetLabel, targetAmount } = req.body;

    if (!name || !email || !password || !teamName || !targetLabel || !targetAmount) {
      return res.status(400).json({ error: 'Missing required fields' });
    }

    // Check if email already exists
    const existingUser = await db.get('SELECT id FROM users WHERE email = ?', [email]);
    if (existingUser) {
      return res.status(400).json({ error: 'Email already registered' });
    }

    // Hash password
    const passwordHash = await bcrypt.hash(password, 10);

    // Create user
    const userResult = await db.run(
      'INSERT INTO users (name, email, password_hash, role) VALUES (?, ?, ?, ?)',
      [name, email, passwordHash, 'admin']
    );
    const userId = userResult.lastID;

    // Create team
    const teamResult = await db.run(
      'INSERT INTO teams (name, description, target_label, target_amount, created_by_user_id) VALUES (?, ?, ?, ?, ?)',
      [teamName, teamDescription || null, targetLabel, targetAmount, userId]
    );
    const teamId = teamResult.lastID;

    // Add user as team member
    await db.run(
      'INSERT INTO team_members (team_id, user_id) VALUES (?, ?)',
      [teamId, userId]
    );

    // Generate token
    const token = jwt.sign(
      { id: userId, email, role: 'admin', teamId },
      JWT_SECRET,
      { expiresIn: '7d' }
    );

    res.json({
      token,
      user: { id: userId, name, email, role: 'admin' },
      team: { id: teamId, name: teamName, targetLabel, targetAmount }
    });
  } catch (error) {
    console.error('Register error:', error);
    console.error('Error stack:', error.stack);
    res.status(500).json({ error: error.message || 'Failed to register' });
  }
});

// Login
router.post('/login', async (req, res) => {
  try {
    const { email, password } = req.body;

    if (!email || !password) {
      return res.status(400).json({ error: 'Email and password required' });
    }

    const user = await db.get('SELECT * FROM users WHERE email = ?', [email]);
    if (!user) {
      return res.status(401).json({ error: 'Invalid credentials' });
    }

    const validPassword = await bcrypt.compare(password, user.password_hash);
    if (!validPassword) {
      return res.status(401).json({ error: 'Invalid credentials' });
    }

    // Get user's team
    const teamMember = await db.get(
      'SELECT team_id FROM team_members WHERE user_id = ? LIMIT 1',
      [user.id]
    );

    const token = jwt.sign(
      {
        id: user.id,
        email: user.email,
        role: user.role,
        teamId: teamMember?.team_id
      },
      JWT_SECRET,
      { expiresIn: '7d' }
    );

    res.json({
      token,
      user: { id: user.id, name: user.name, email: user.email, role: user.role }
    });
  } catch (error) {
    console.error('Login error:', error);
    res.status(500).json({ error: 'Failed to login' });
  }
});

export default router;
