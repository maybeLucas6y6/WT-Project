-- Drop tables if they already exist (for clean re-creation)
DROP TABLE IF EXISTS assets;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS favorite_assets;

-- Create users table
CREATE TABLE users (
    id SERIAL PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    phone_number VARCHAR(20),
    role VARCHAR(20) NOT NULL
);

-- Create assets table
CREATE TABLE assets (
    id SERIAL PRIMARY KEY,
    address TEXT NOT NULL,
    description TEXT,
    price NUMERIC(12, 2) NOT NULL,
    lat DECIMAL(9, 6),
    long DECIMAL(9, 6),
    user_id INTEGER NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE favorite_assets (
    id SERIAL PRIMARY KEY,
    user_id INT NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    asset_id INT NOT NULL REFERENCES assets(id) ON DELETE CASCADE
);

-- Table to store category types
CREATE TABLE categories (
    id SERIAL PRIMARY KEY,
    name TEXT UNIQUE NOT NULL
);

-- Join table to associate assets with multiple categories
CREATE TABLE asset_category (
    id SERIAL PRIMARY KEY,
    asset_id INT NOT NULL REFERENCES assets(id) ON DELETE CASCADE,
    category_id INT NOT NULL REFERENCES categories(id) ON DELETE CASCADE
);

