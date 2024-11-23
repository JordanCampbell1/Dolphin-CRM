-- Create the database
CREATE DATABASE dolphin_crm;

-- Use the database
USE dolphin_crm;

-- Create the Users table
CREATE TABLE Users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(255) NOT NULL,
    lastname VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    role VARCHAR(100) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Create the Contacts table
CREATE TABLE Contacts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100),
    firstname VARCHAR(255) NOT NULL,
    lastname VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    telephone VARCHAR(50),
    company VARCHAR(255),
    type ENUM('sales lead', 'support') NOT NULL,
    assigned_to INT,
    created_by INT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (assigned_to) REFERENCES Users(id),
    FOREIGN KEY (created_by) REFERENCES Users(id)
);

-- Create the Notes table
CREATE TABLE Notes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    contact_id INT NOT NULL,
    comment TEXT NOT NULL,
    created_by INT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (contact_id) REFERENCES Contacts(id),
    FOREIGN KEY (created_by) REFERENCES Users(id)
);
