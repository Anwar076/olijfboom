import express from 'express';
import db from '../db.js';

const router = express.Router();

// Get light details: which teams contributed to a specific light
// Light index: 0-based (0 = first light, 99 = last light)
// Each light represents €10.000
router.get('/:lightIndex', async (req, res) => {
  try {
    const lightIndex = parseInt(req.params.lightIndex);
    
    if (isNaN(lightIndex) || lightIndex < 0 || lightIndex >= 100) {
      return res.status(400).json({ error: 'Invalid light index (0-99)' });
    }

    // Calculate the amount range for this light
    // Light 0 = €0 to €10.000
    // Light 1 = €10.000 to €20.000
    // etc.
    const lightStartAmount = lightIndex * 10000;
    const lightEndAmount = (lightIndex + 1) * 10000;

    // Get all donations with cumulative sum to find which donations contributed to this light
    // This is tricky - we need to track cumulative donations and see which ones fall in this range
    const allDonations = await db.all(`
      SELECT 
        d.id,
        d.team_id,
        d.amount,
        d.created_at,
        t.name as team_name
      FROM donations d
      JOIN teams t ON d.team_id = t.id
      ORDER BY d.created_at ASC, d.id ASC
    `);

    // Calculate cumulative total and find donations that contributed to this light
    let cumulativeTotal = 0;
    const contributingDonations = [];
    
    for (const donation of allDonations) {
      const donationAmount = parseFloat(donation.amount) || 0;
      const prevTotal = cumulativeTotal;
      cumulativeTotal += donationAmount;

      // Check if this donation contributed to this light
      if (prevTotal < lightEndAmount && cumulativeTotal > lightStartAmount) {
        const contributionStart = Math.max(prevTotal, lightStartAmount);
        const contributionEnd = Math.min(cumulativeTotal, lightEndAmount);
        const contributionAmount = contributionEnd - contributionStart;

        contributingDonations.push({
          teamId: donation.team_id,
          teamName: donation.team_name,
          amount: contributionAmount,
          donationDate: donation.created_at
        });
      }

      // Stop if we've passed this light range
      if (cumulativeTotal >= lightEndAmount) {
        break;
      }
    }

    // Group by team and sum amounts
    const teamContributions = {};
    
    for (const contribution of contributingDonations) {
      if (!teamContributions[contribution.teamId]) {
        teamContributions[contribution.teamId] = {
          teamName: contribution.teamName,
          totalAmount: 0,
          donations: []
        };
      }
      teamContributions[contribution.teamId].totalAmount += contribution.amount;
      teamContributions[contribution.teamId].donations.push(contribution);
    }

    const teams = Object.values(teamContributions).map(tc => ({
      teamName: tc.teamName,
      amount: Math.round(tc.totalAmount * 100) / 100
    }));

    res.json({
      lightIndex,
      lightNumber: lightIndex + 1,
      amountRange: {
        start: lightStartAmount,
        end: lightEndAmount
      },
      teams: teams
    });
  } catch (error) {
    console.error('Get light details error:', error);
    res.status(500).json({ error: 'Failed to get light details' });
  }
});

export default router;

