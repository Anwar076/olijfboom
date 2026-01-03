import mysql from 'mysql2/promise';
import { query } from './db.js';

// Script to initialize database tables in production
// Use this when the database already exists (created via Plesk)

async function initProductionDatabase() {
  try {
    console.log('Initializing production database tables...');
    
    // Create tables (database should already exist)
    await query(`
      CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        email VARCHAR(255) UNIQUE NOT NULL,
        password_hash VARCHAR(255) NOT NULL,
        role VARCHAR(50) NOT NULL DEFAULT 'member',
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
      )
    `);

    await query(`
      CREATE TABLE IF NOT EXISTS teams (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        description TEXT,
        target_label VARCHAR(100) NOT NULL,
        target_amount DECIMAL(15, 2) NOT NULL,
        created_by_user_id INT NOT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (created_by_user_id) REFERENCES users(id) ON DELETE CASCADE
      )
    `);

    await query(`
      CREATE TABLE IF NOT EXISTS team_members (
        id INT AUTO_INCREMENT PRIMARY KEY,
        team_id INT NOT NULL,
        user_id INT NOT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (team_id) REFERENCES teams(id) ON DELETE CASCADE,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
        UNIQUE KEY unique_team_user (team_id, user_id)
      )
    `);

    await query(`
      CREATE TABLE IF NOT EXISTS donations (
        id INT AUTO_INCREMENT PRIMARY KEY,
        team_id INT NOT NULL,
        amount DECIMAL(15, 2) NOT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (team_id) REFERENCES teams(id) ON DELETE CASCADE
      )
    `);

    await query(`
      CREATE TABLE IF NOT EXISTS invites (
        id INT AUTO_INCREMENT PRIMARY KEY,
        team_id INT NOT NULL,
        token VARCHAR(255) UNIQUE NOT NULL,
        created_by_user_id INT NOT NULL,
        used_at DATETIME NULL,
        expires_at DATETIME NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (team_id) REFERENCES teams(id) ON DELETE CASCADE,
        FOREIGN KEY (created_by_user_id) REFERENCES users(id) ON DELETE CASCADE
      )
    `);

    console.log('Production database initialized successfully!');
    console.log('All tables created.');
    process.exit(0);
  } catch (error) {
    console.error('Error initializing production database:', error);
    process.exit(1);
  }
}

initProductionDatabase();

