-- Create database
CREATE DATABASE IF NOT EXISTS klickmybaby;
USE klickmybaby;

-- Create reviews table
CREATE TABLE IF NOT EXISTS reviews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    rating INT NOT NULL,
    review TEXT NOT NULL,
    status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create contacts table
CREATE TABLE IF NOT EXISTS contacts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    subject VARCHAR(200) NOT NULL,
    message TEXT NOT NULL,
    is_read BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert some sample reviews
INSERT INTO reviews (name, rating, review, status) VALUES
('Ravi Kumar', 5, 'Outstanding service! The newborn photoshoot was simply amazing. Highly recommend!', 'approved'),
('Ananya Reddy', 4, 'Great experience, but the session was a bit long. Overall, I\'m satisfied with the results.', 'approved'),
('Arvind Sharma', 3, 'Very professional and friendly staff. The photos were beautifully captured, and the experience was memorable!', 'approved'),
('Priya Iyer', 4, 'Fantastic photoshoot for my newborn! The photographers were so patient and creative.', 'approved');