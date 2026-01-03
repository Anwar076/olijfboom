import express from 'express';
import db from '../db.js';

const router = express.Router();

// Get global stats (public)
router.get('/', async (req, res) => {
  try {
    // Total raised from all donations
    const totalResult = await db.get(
      'SELECT COALESCE(SUM(amount), 0) as total FROM donations'
    );
    const totalRaised = parseFloat(totalResult.total) || 0;

    // Lights activated: 1 licht = €10.000 totaal bedrag
    const lightsActivated = Math.min(Math.floor(totalRaised / 10000), 100); // Cap at 100
    const totalLights = 100;
    const progressPercentage = (lightsActivated / totalLights) * 100;
    
    // Debug logging
    console.log('Stats calculation:', {
      totalRaised,
      lightsActivated,
      calculation: `${totalRaised} / 10000 = ${totalRaised / 10000}, floor = ${Math.floor(totalRaised / 10000)}`
    });
    
    // Count teams that reached their target (for reference)
    const teamsCompleted = await db.all(`
      SELECT t.id, t.target_amount, COALESCE(SUM(d.amount), 0) as team_total
      FROM teams t
      LEFT JOIN donations d ON t.id = d.team_id
      GROUP BY t.id, t.target_amount
      HAVING team_total >= t.target_amount
    `);

    // Count teams
    const teamsResult = await db.get('SELECT COUNT(*) as count FROM teams');
    const teamsCount = teamsResult.count || 0;

    // Count members
    const membersResult = await db.get('SELECT COUNT(*) as count FROM team_members');
    const membersCount = membersResult.count || 0;

    res.json({
      totalRaised,
      lightsActivated,
      totalLights,
      progressPercentage,
      teamsCount,
      membersCount,
      teamsCompleted: teamsCompleted.length
    });
  } catch (error) {
    console.error('Get stats error:', error);
    res.status(500).json({ error: 'Failed to get stats' });
  }
});

export default router;
