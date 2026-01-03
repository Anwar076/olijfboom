import mysql from 'mysql2/promise';
import { initDatabase, query } from './db.js';

const dbConfig = {
  host: process.env.DB_HOST || 'localhost',
  user: process.env.DB_USER || 'root',
  password: process.env.DB_PASSWORD || '',
  database: process.env.DB_NAME || 'olijfboom'
};

async function resetDatabase() {
  try {
    console.log('Resetting database...');
    
    // Connect to MySQL (without database)
    const connection = await mysql.createConnection({
      host: dbConfig.host,
      user: dbConfig.user,
      password: dbConfig.password
    });

    // Drop database if exists
    await connection.execute(`DROP DATABASE IF EXISTS \`${dbConfig.database}\``);
    console.log(`Database '${dbConfig.database}' dropped`);
    
    await connection.end();

    // Reinitialize database (creates new database and tables)
    await initDatabase();
    console.log('Database reset complete! All tables have been recreated.');
    
    process.exit(0);
  } catch (error) {
    console.error('Error resetting database:', error);
    process.exit(1);
  }
}

resetDatabase();

