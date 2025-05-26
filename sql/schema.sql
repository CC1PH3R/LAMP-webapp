-- Judges Table
CREATE TABLE IF NOT EXISTS judges (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) UNIQUE NOT NULL,
  display_name VARCHAR(100) NOT NULL
);

-- Sample Data 
INSERT INTO judges (username, display_name) VALUES
('judge1', 'Judge Sarah'),
('judge2', 'Judge Mike');

-- Users Table
CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(100) UNIQUE
);

-- Sample Data
INSERT INTO users (name, email) VALUES
('Alice Johnson', 'alice@example.com'),
('Bob Smith', 'bob@example.com');

-- Scores Table
CREATE TABLE IF NOT EXISTS scores (
  id INT AUTO_INCREMENT PRIMARY KEY,
  judge_id INT NOT NULL,
  user_id INT NOT NULL,
  points INT NOT NULL CHECK (points BETWEEN 1 AND 100),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (judge_id) REFERENCES judges(id) ON DELETE CASCADE,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Indexes for faster querying
CREATE INDEX idx_judge ON scores(judge_id);
CREATE INDEX idx_user ON scores(user_id);