CREATE DATABASE IF NOT EXISTS ecare;

USE ecare;

-- USERS TABLE
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'doctor', 'patient') NOT NULL,
    full_name VARCHAR(255) NOT NULL,
    email VARCHAR(150),
    phone VARCHAR(20),
    is_active BOOLEAN DEFAULT TRUE,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    last_login DATETIME
);

-- APPOINTMENTS TABLE
CREATE TABLE appointments (
    id INT PRIMARY KEY AUTO_INCREMENT,
    patient_id INT NOT NULL,
    doctor_id INT NOT NULL,
    scheduled_date DATETIME NOT NULL,
    reason TEXT,
    status ENUM('pending', 'approved_by_admin', 'approved_by_doctor', 'rejected') DEFAULT 'pending',
    FOREIGN KEY (patient_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (doctor_id) REFERENCES users(id) ON DELETE CASCADE
);

-- MEDICAL RECORDS TABLE
CREATE TABLE medical_records (
    id INT PRIMARY KEY AUTO_INCREMENT,
    patient_id INT NOT NULL,
    doctor_id INT NOT NULL,
    diagnosis TEXT,
    treatment TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (patient_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (doctor_id) REFERENCES users(id) ON DELETE CASCADE
);

-- PRESCRIPTIONS TABLE
CREATE TABLE prescriptions (
    id INT PRIMARY KEY AUTO_INCREMENT,
    record_id INT NOT NULL,
    medicine_name VARCHAR(255) NOT NULL,
    dosage VARCHAR(255),
    FOREIGN KEY (record_id) REFERENCES medical_records(id) ON DELETE CASCADE
);

-- BILLING TABLE
CREATE TABLE billing (
    id INT PRIMARY KEY AUTO_INCREMENT,
    patient_id INT NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    status ENUM('unpaid', 'paid') DEFAULT 'unpaid',
    description VARCHAR(255) NOT NULL,
    issued_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (patient_id) REFERENCES users(id) ON DELETE CASCADE
);

-- INVENTORY TABLE
CREATE TABLE inventory (
    id INT PRIMARY KEY AUTO_INCREMENT,
    item_name VARCHAR(255) NOT NULL,
    quantity INT DEFAULT 0,
    description TEXT,
    last_updated DATETIME DEFAULT CURRENT_TIMESTAMP
);
