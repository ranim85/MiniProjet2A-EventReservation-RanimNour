CREATE DATABASE IF NOT EXISTS minievent CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE minievent;

CREATE TABLE IF NOT EXISTS events (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  description TEXT,
  date DATETIME,
  location VARCHAR(255),
  seats INT DEFAULT 0,
  image VARCHAR(255),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS reservations (
  id INT AUTO_INCREMENT PRIMARY KEY,
  event_id INT NOT NULL,
  name VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL,
  phone VARCHAR(50),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS admin (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(100) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL
);

-- Insérer un admin par défaut (mot de passe: admin123 hashé avec bcrypt)
INSERT INTO admin (username, password_hash)
 VALUES (
    'admin', 
    '$2y$10$wH1hH6k8rK1dGz1J8w8nQe2J7m4F6Qn5MZ8E5n3k2yJ0cK9zBqU2K'
    );