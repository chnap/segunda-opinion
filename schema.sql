-- Tabla de usuarios del panel clínico
CREATE TABLE IF NOT EXISTS backend_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('ADMIN', 'DOCTOR', 'ASSISTANT') DEFAULT 'DOCTOR',
    last_login TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla principal de Casos Clínicos (Workflow de Segunda Opinión)
CREATE TABLE IF NOT EXISTS clinical_cases (
    id VARCHAR(50) PRIMARY KEY,
    public_reference VARCHAR(50) NOT NULL UNIQUE,
    patient_name VARCHAR(150) NOT NULL,
    email VARCHAR(150) NOT NULL,
    phone VARCHAR(50) NOT NULL,
    patient_type ENUM('self', 'family') NOT NULL,
    diagnosis TEXT NOT NULL,
    reason TEXT NOT NULL,
    clinical_question TEXT NOT NULL,
    status VARCHAR(50) NOT NULL DEFAULT 'NEW_REQUEST',
    
    -- Vínculos DriCloud
    dricloud_patient_id VARCHAR(100) DEFAULT NULL,
    dricloud_service_id VARCHAR(100) DEFAULT NULL,
    dricloud_consultation_id VARCHAR(100) DEFAULT NULL,
    dricloud_status VARCHAR(50) DEFAULT 'PENDING',
    dricloud_form_sent_at TIMESTAMP NULL,
    dricloud_form_completed_at TIMESTAMP NULL,
    
    -- Estado SMS e Integración
    sms_status VARCHAR(50) DEFAULT 'PENDING',
    sms_sent_at TIMESTAMP NULL,
    sms_provider_message_id VARCHAR(150) DEFAULT NULL,
    sms_error TEXT DEFAULT NULL,
    
    rejection_reason TEXT DEFAULT NULL,
    notes TEXT DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabla de Checklist Documental
CREATE TABLE IF NOT EXISTS case_checklists (
    case_id VARCHAR(50) PRIMARY KEY,
    medical_report ENUM('PRESENT', 'MISSING', 'NOT_REQUIRED') DEFAULT 'MISSING',
    pathology ENUM('PRESENT', 'MISSING', 'NOT_REQUIRED') DEFAULT 'MISSING',
    imaging ENUM('PRESENT', 'MISSING', 'NOT_REQUIRED') DEFAULT 'MISSING',
    treatment ENUM('PRESENT', 'MISSING', 'NOT_REQUIRED') DEFAULT 'MISSING',
    labs ENUM('PRESENT', 'MISSING', 'NOT_REQUIRED') DEFAULT 'MISSING',
    genomics ENUM('PRESENT', 'MISSING', 'NOT_REQUIRED') DEFAULT 'NOT_REQUIRED',
    medication ENUM('PRESENT', 'MISSING', 'NOT_REQUIRED') DEFAULT 'MISSING',
    clinical_question ENUM('PRESENT', 'MISSING', 'NOT_REQUIRED') DEFAULT 'PRESENT',
    FOREIGN KEY (case_id) REFERENCES clinical_cases(id) ON DELETE CASCADE
);

-- Tabla de Auditoría e Historial de Eventos (Timeline)
CREATE TABLE IF NOT EXISTS case_events (
    id INT AUTO_INCREMENT PRIMARY KEY,
    case_id VARCHAR(50) NOT NULL,
    event_type VARCHAR(100) NOT NULL,
    actor VARCHAR(100) NOT NULL,
    metadata JSON DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (case_id) REFERENCES clinical_cases(id) ON DELETE CASCADE
);

-- Tabla de Logs de Integración (Errores DriCloud / SMS)
CREATE TABLE IF NOT EXISTS integration_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    case_id VARCHAR(50) DEFAULT NULL,
    service_name VARCHAR(50) NOT NULL,
    log_level ENUM('INFO', 'WARNING', 'ERROR') NOT NULL,
    message TEXT NOT NULL,
    payload JSON DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE DATABASE IF NOT EXISTS dricloud_integration;
USE dricloud_integration;

-- Tabla de pacientes (tanto solicitudes como pacientes integrados)
CREATE TABLE IF NOT EXISTS patients (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    telefono VARCHAR(20) NOT NULL,
    dricloud_estado VARCHAR(50) DEFAULT 'Pendiente',
    porcentaje_checklist INT DEFAULT 0,
    enlace_ficha VARCHAR(255) DEFAULT '#',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla para el checklist de documentación
CREATE TABLE IF NOT EXISTS checklist (
    id INT AUTO_INCREMENT PRIMARY KEY,
    patient_id INT,
    documento VARCHAR(150) NOT NULL,
    completado BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (patient_id) REFERENCES patients(id) ON DELETE CASCADE
);

-- Inserción de paciente imaginario que ya pasó por Dricloud (ID 1)
INSERT INTO patients (id, nombre, email, telefono, dricloud_estado, porcentaje_checklist, enlace_ficha) 
VALUES (1, 'Sofía Martínez', 'sofia.martinez@email.com', '+34600123456', 'Completado', 75, '#');

-- Inserción del checklist para el paciente imaginario
INSERT INTO checklist (patient_id, documento, completado) VALUES 
(1, 'Consentimiento Informado', 1),
(1, 'Historial Clínico Preliminar', 1),
(1, 'Pruebas Diagnósticas (Radiografía)', 1),
(1, 'Cuestionario de Salud Anual', 0);