import mysql from 'mysql2/promise';

const dbConfig = {
  host: process.env.DB_HOST || 'localhost',
  user: process.env.DB_USER || 'root',
  password: process.env.DB_PASSWORD || '',
  database: process.env.DB_NAME || 'olijfboom'
};

async function migrate() {
  let connection;
  
  try {
    // Connect to MySQL
    connection = await mysql.createConnection({
      host: dbConfig.host,
      user: dbConfig.user,
      password: dbConfig.password,
      multipleStatements: true
    });

    await connection.query(`USE \`${dbConfig.database}\``);

    // Check if target_label column exists
    const [columns] = await connection.query(`
      SELECT COLUMN_NAME 
      FROM INFORMATION_SCHEMA.COLUMNS 
      WHERE TABLE_SCHEMA = ? AND TABLE_NAME = 'teams' AND COLUMN_NAME = 'target_label'
    `, [dbConfig.database]);

    if (columns.length === 0) {
      console.log('Migrating database schema...');
      
      // Add new columns
      await connection.query(`
        ALTER TABLE teams 
        ADD COLUMN target_label VARCHAR(100) DEFAULT 'Blad',
        ADD COLUMN target_amount DECIMAL(15, 2) DEFAULT 5000
      `);

      // Migrate existing data
      await connection.query(`
        UPDATE teams SET 
          target_label = CASE 
            WHEN sponsor_level = 'Stam' THEN 'Stam'
            WHEN sponsor_level = 'Tak' THEN 'Tak'
            WHEN sponsor_level = 'Wortel' THEN 'Wortel'
            WHEN sponsor_level = 'Olijven' THEN 'Olijf'
            WHEN sponsor_level LIKE '%10%' THEN 'Blad'
            WHEN sponsor_level LIKE '%5%' THEN 'Blad'
            ELSE 'Blad'
          END,
          target_amount = CASE
            WHEN sponsor_level = 'Stam' THEN 200000
            WHEN sponsor_level = 'Tak' THEN 100000
            WHEN sponsor_level = 'Wortel' THEN 50000
            WHEN sponsor_level = 'Olijven' THEN 25000
            WHEN sponsor_level LIKE '%10%' THEN 10000
            WHEN sponsor_level LIKE '%5%' THEN 5000
            ELSE 5000
          END
      `);

      // Remove old column
      await connection.query(`ALTER TABLE teams DROP COLUMN sponsor_level`);

      console.log('Migration completed!');
    } else {
      console.log('Database already migrated (target_label exists)');
    }

    // Check donations table
    const [donationColumns] = await connection.query(`
      SELECT COLUMN_NAME 
      FROM INFORMATION_SCHEMA.COLUMNS 
      WHERE TABLE_SCHEMA = ? AND TABLE_NAME = 'donations' AND COLUMN_NAME = 'sponsor_level'
    `, [dbConfig.database]);

    if (donationColumns.length > 0) {
      console.log('Removing sponsor_level from donations table...');
      await connection.query(`ALTER TABLE donations DROP COLUMN sponsor_level`);
      console.log('Donations table migrated!');
    }

    console.log('Database migration complete!');
    
  } catch (error) {
    console.error('Migration error:', error);
    process.exit(1);
  } finally {
    if (connection) {
      await connection.end();
    }
  }
}

migrate();

