# Database Migration Notes

## Breaking Changes

The database schema has been updated to remove sponsor levels from donations and add target goals to teams.

### Schema Changes

1. **teams table**:
   - REMOVED: `sponsor_level` (VARCHAR)
   - ADDED: `target_label` (VARCHAR(100))
   - ADDED: `target_amount` (DECIMAL(15, 2))

2. **donations table**:
   - REMOVED: `sponsor_level` (VARCHAR)

### Migration Instructions

If you have an existing database, you have two options:

#### Option 1: Drop and Recreate (Recommended for Development)
```sql
DROP DATABASE olijfboom;
-- Then restart the server to auto-create the database with new schema
```

#### Option 2: Manual Migration (For Production)
```sql
-- Add new columns to teams
ALTER TABLE teams ADD COLUMN target_label VARCHAR(100);
ALTER TABLE teams ADD COLUMN target_amount DECIMAL(15, 2);

-- Migrate existing sponsor_level to target_label/target_amount
UPDATE teams SET 
  target_label = CASE 
    WHEN sponsor_level = 'Stam' THEN 'Stam'
    WHEN sponsor_level = 'Tak' THEN 'Tak'
    WHEN sponsor_level = 'Wortel' THEN 'Wortel'
    WHEN sponsor_level = 'Olijven' THEN 'Olijven'
    WHEN sponsor_level LIKE 'Bladeren%10%' THEN 'Blad'
    WHEN sponsor_level LIKE 'Bladeren%5%' THEN 'Blad'
    ELSE 'Blad'
  END,
  target_amount = CASE
    WHEN sponsor_level = 'Stam' THEN 200000
    WHEN sponsor_level = 'Tak' THEN 100000
    WHEN sponsor_level = 'Wortel' THEN 50000
    WHEN sponsor_level = 'Olijven' THEN 25000
    WHEN sponsor_level LIKE 'Bladeren%10%' THEN 10000
    WHEN sponsor_level LIKE 'Bladeren%5%' THEN 5000
    ELSE 5000
  END;

-- Remove sponsor_level column
ALTER TABLE teams DROP COLUMN sponsor_level;

-- Remove sponsor_level from donations
ALTER TABLE donations DROP COLUMN sponsor_level;
```

### Important Notes

- The new system uses **free-amount donations** (any amount >= €1)
- Teams have a **target goal** set at creation time
- Each team has one **lampje** that turns ON when target is reached
- Global tree lights = count of teams that reached their target (max 100)

