CREATE DATABASE IF NOT EXISTS magilas_gym_db;
USE magilas_gym_db;

CREATE TABLE IF NOT EXISTS membership_applications (
    application_id INT AUTO_INCREMENT PRIMARY KEY,
    fullname VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    photo_path VARCHAR(255) NOT NULL,
    role VARCHAR(50) DEFAULT 'member',
    status ENUM('pending', 'active', 'rejected') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
