-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 30, 2026 at 10:41 AM
-- Server version: 8.4.10-0ubuntu0.26.04.1
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_oncologia`
--

-- --------------------------------------------------------

--
-- Table structure for table `backend_users`
--

CREATE TABLE `backend_users` (
  `id` int NOT NULL,
  `username` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `role` varchar(50) COLLATE utf8mb4_general_ci DEFAULT 'admin',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `backend_users`
--

INSERT INTO `backend_users` (`id`, `username`, `email`, `password_hash`, `role`, `created_at`) VALUES
(1, NULL, 'juanhaba@gmail.com', '$2y$10$C3rs0XC1BQleNRIqQ7viCu4rFTkXdfkU2.Z3D6ohhokY3LqJxOzxq', 'admin', '2026-08-11 20:00:32'),
(2, 'admin', 'nachonon9@gmail.com', '$2y$12$M1ynBHz6Bh5h1qDObNWg.ef2.tfPJXZAr5ZOCmCxKaS/67feE32fK', 'admin', '2026-08-12 10:01:37');

-- --------------------------------------------------------

--
-- Table structure for table `cases`
--

CREATE TABLE `cases` (
  `id` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `patient_name` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `phone` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `status` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `diagnosis` text COLLATE utf8mb4_general_ci,
  `clinical_question` text COLLATE utf8mb4_general_ci,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `case_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `priority` varchar(50) COLLATE utf8mb4_general_ci DEFAULT 'NORMAL'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cases`
--

INSERT INTO `cases` (`id`, `patient_name`, `email`, `phone`, `status`, `diagnosis`, `clinical_question`, `created_at`, `updated_at`, `case_data`, `priority`) VALUES
('ONC-8197', 's', 'iom01@lasallecordoba.es', 's', 'NEW_REQUEST', 's', 's', '2026-08-30 10:39:35', '2026-08-30 10:39:35', '{\"action\":\"submit_request\",\"fullName\":\"s\",\"email\":\"iom01@lasallecordoba.es\",\"phone\":\"s\",\"diagnosis\":\"s\",\"reason\":\"s\",\"question\":\"s\"}', 'ALTA'),
('ONCO-8005', 'Francisco Javier Blázquez', 'francisco.blazquez@example.com', '+34655667788', 'CLOSED', 'Adenocarcinoma gástrico estadio III', 'Evaluación de pauta perioperatoria FLOT.', '2026-07-29 20:17:03', '2026-08-08 20:17:03', '{\"id\":\"ONCO-8005\",\"patientName\":\"Francisco Javier Blázquez\",\"email\":\"francisco.blazquez@example.com\",\"phone\":\"+34655667788\",\"status\":\"CLOSED\",\"diagnosis\":\"Adenocarcinoma gástrico estadio III\",\"clinical_question\":\"Evaluación de pauta perioperatoria FLOT.\",\"createdAt\":\"2026-07-29T20:17:03+02:00\",\"updatedAt\":\"2026-08-08T20:17:03+02:00\",\"checklist\":{\"medicalReport\":\"PRESENT\",\"pathology\":\"PRESENT\",\"imaging\":\"PRESENT\",\"treatment\":\"PRESENT\",\"labs\":\"PRESENT\",\"genomics\":\"NOT_REQUIRED\",\"medication\":\"PRESENT\",\"clinical_question\":\"PRESENT\"},\"dricloud\":{\"formUrl\":\"https:\\/\\/app.dricloud.com\\/forms\\/ext\\/sec-op\\/demo-francisco-blazquez-3390\",\"patientId\":\"DC-5512\"},\"events\":[{\"type\":\"NEW_REQUEST\",\"at\":\"2026-07-29T20:17:03+02:00\",\"actor\":\"Paciente (Web Pública)\"},{\"type\":\"CLOSED\",\"at\":\"2026-08-08T20:17:03+02:00\",\"actor\":\"Dr. Juan De la Haba\"}]}', 'NORMAL'),
('ONCO-8010', 'Ana Belén Pastor', 'anabelen.pastor@example.com', '+34644556677', 'REPORT_DELIVERED', 'Linfoma Hodgkin clásico esclerosis nodular', 'Segunda opinión sobre esquema de quimioterapia ABVD vs escalado.', '2026-08-05 20:17:03', '2026-08-11 20:17:03', '{\"id\":\"ONCO-8010\",\"patientName\":\"Ana Belén Pastor\",\"email\":\"anabelen.pastor@example.com\",\"phone\":\"+34644556677\",\"status\":\"REPORT_DELIVERED\",\"diagnosis\":\"Linfoma Hodgkin clásico esclerosis nodular\",\"clinical_question\":\"Segunda opinión sobre esquema de quimioterapia ABVD vs escalado.\",\"createdAt\":\"2026-08-05T20:17:03+02:00\",\"updatedAt\":\"2026-08-11T20:17:03+02:00\",\"checklist\":{\"medicalReport\":\"PRESENT\",\"pathology\":\"PRESENT\",\"imaging\":\"PRESENT\",\"treatment\":\"PRESENT\",\"labs\":\"PRESENT\",\"genomics\":\"NOT_REQUIRED\",\"medication\":\"PRESENT\",\"clinical_question\":\"PRESENT\"},\"dricloud\":{\"formUrl\":\"https:\\/\\/app.dricloud.com\\/forms\\/ext\\/sec-op\\/demo-anabelen-pastor-5521\",\"patientId\":\"DC-6620\"},\"events\":[{\"type\":\"NEW_REQUEST\",\"at\":\"2026-08-05T20:17:03+02:00\",\"actor\":\"Paciente (Web Pública)\"},{\"type\":\"ACCEPTED\",\"at\":\"2026-08-06T20:17:03+02:00\",\"actor\":\"Dr. Juan De la Haba\"},{\"type\":\"REPORT_DELIVERED\",\"at\":\"2026-08-11T20:17:03+02:00\",\"actor\":\"Dr. Juan De la Haba\"}]}', 'NORMAL'),
('ONCO-8015', 'José Luis Navarro', 'joseluis.navarro@example.com', '+34633445566', 'READY_FOR_CONSULTATION', 'Carcinoma de próstata localizado de riesgo intermedio-alto', 'Comparativa entre braquiterapia y prostatectomía radical robótica con preservación neurovascular.', '2026-08-09 20:17:03', '2026-08-12 20:17:03', '{\"id\":\"ONCO-8015\",\"patientName\":\"José Luis Navarro\",\"email\":\"joseluis.navarro@example.com\",\"phone\":\"+34633445566\",\"status\":\"READY_FOR_CONSULTATION\",\"diagnosis\":\"Carcinoma de próstata localizado de riesgo intermedio-alto\",\"clinical_question\":\"Comparativa entre braquiterapia y prostatectomía radical robótica con preservación neurovascular.\",\"createdAt\":\"2026-08-09T20:17:03+02:00\",\"updatedAt\":\"2026-08-12T20:17:03+02:00\",\"checklist\":{\"medicalReport\":\"PRESENT\",\"pathology\":\"PRESENT\",\"imaging\":\"PRESENT\",\"treatment\":\"NOT_REQUIRED\",\"labs\":\"PRESENT\",\"genomics\":\"NOT_REQUIRED\",\"medication\":\"PRESENT\",\"clinical_question\":\"PRESENT\"},\"dricloud\":{\"formUrl\":\"https:\\/\\/app.dricloud.com\\/forms\\/ext\\/sec-op\\/demo-joseluis-navarro-1102\",\"patientId\":\"DC-7734\"},\"events\":[{\"type\":\"NEW_REQUEST\",\"at\":\"2026-08-09T20:17:03+02:00\",\"actor\":\"Paciente (Web Pública)\"},{\"type\":\"ACCEPTED\",\"at\":\"2026-08-10T20:17:03+02:00\",\"actor\":\"Dr. Juan De la Haba\"},{\"type\":\"DRICLOUD_RETURNED\",\"at\":\"2026-08-11T20:17:03+02:00\",\"actor\":\"DriCloud API\"},{\"type\":\"READY_FOR_CONSULTATION\",\"at\":\"2026-08-12T20:17:03+02:00\",\"actor\":\"Dr. Juan De la Haba\"}]}', 'NORMAL'),
('ONCO-8018', 'María Dolores Sánchez', 'mdolores.sanchez@example.com', '+34622334455', 'DOCUMENTATION_PENDING', 'Melanoma cutáneo maligno lentiginoso acral', 'Revisión de márgenes quirúrgicos y necesidad de biopsia de ganglio centinela ampliada.', '2026-08-11 20:17:03', '2026-08-13 16:17:03', '{\"id\":\"ONCO-8018\",\"patientName\":\"María Dolores Sánchez\",\"email\":\"mdolores.sanchez@example.com\",\"phone\":\"+34622334455\",\"status\":\"DOCUMENTATION_PENDING\",\"diagnosis\":\"Melanoma cutáneo maligno lentiginoso acral\",\"clinical_question\":\"Revisión de márgenes quirúrgicos y necesidad de biopsia de ganglio centinela ampliada.\",\"createdAt\":\"2026-08-11T20:17:03+02:00\",\"updatedAt\":\"2026-08-13T16:17:03+02:00\",\"checklist\":{\"medicalReport\":\"PRESENT\",\"pathology\":\"PRESENT\",\"imaging\":\"PRESENT\",\"treatment\":\"NOT_REQUIRED\",\"labs\":\"MISSING\",\"genomics\":\"MISSING\",\"medication\":\"PRESENT\",\"clinical_question\":\"PRESENT\"},\"dricloud\":{\"formUrl\":\"https:\\/\\/app.dricloud.com\\/forms\\/ext\\/sec-op\\/demo-dolores-sanchez-4411\",\"patientId\":\"DC-8842\"},\"events\":[{\"type\":\"NEW_REQUEST\",\"at\":\"2026-08-11T20:17:03+02:00\",\"actor\":\"Paciente (Web Pública)\"},{\"type\":\"ACCEPTED\",\"at\":\"2026-08-12T20:17:03+02:00\",\"actor\":\"Dr. Juan De la Haba\"},{\"type\":\"DRICLOUD_RETURNED\",\"at\":\"2026-08-13T16:17:03+02:00\",\"actor\":\"DriCloud API (Webhook \\/ Formulario Rellenado)\"}]}', 'NORMAL'),
('ONCO-8020', 'Antonio Gómez Ruiz', 'antonio.gomez@example.com', '+34611223344', 'DRICLOUD_PENDING', 'Adenocarcinoma de pulmón estadificación T2N1M0', 'Valoración sobre opciones de inmunoterapia combinada tras progresión local.', '2026-08-12 20:17:03', '2026-08-13 02:17:03', '{\"id\":\"ONCO-8020\",\"patientName\":\"Antonio Gómez Ruiz\",\"email\":\"antonio.gomez@example.com\",\"phone\":\"+34611223344\",\"status\":\"DRICLOUD_PENDING\",\"diagnosis\":\"Adenocarcinoma de pulmón estadificación T2N1M0\",\"clinical_question\":\"Valoración sobre opciones de inmunoterapia combinada tras progresión local.\",\"createdAt\":\"2026-08-12T20:17:03+02:00\",\"updatedAt\":\"2026-08-13T02:17:03+02:00\",\"checklist\":{\"medicalReport\":\"MISSING\",\"pathology\":\"MISSING\",\"imaging\":\"MISSING\",\"treatment\":\"MISSING\",\"labs\":\"MISSING\",\"genomics\":\"MISSING\",\"medication\":\"MISSING\",\"clinical_question\":\"PRESENT\"},\"dricloud\":{\"formUrl\":\"https:\\/\\/app.dricloud.com\\/forms\\/ext\\/sec-op\\/demo-antonio-gomez-9812\",\"patientId\":\"DC-9921\"},\"events\":[{\"type\":\"NEW_REQUEST\",\"at\":\"2026-08-12T20:17:03+02:00\",\"actor\":\"Paciente (Web Pública)\"},{\"type\":\"ACCEPTED\",\"at\":\"2026-08-13T02:17:03+02:00\",\"actor\":\"Dr. Juan De la Haba\"}]}', 'NORMAL'),
('ONCO-8021', 'Carmen Martínez López', 'carmen.martinez@example.com', '+34600112233', 'NEW_REQUEST', 'Carcinoma ductal infiltrante de mama estadio IIA', '¿Es aconsejable tratamiento de hormonoterapia adyuvante prolongado o quimioterapia previa a la cirugía conservadora?', '2026-08-13 18:17:03', '2026-08-17 12:17:18', '{\"id\":\"ONCO-8021\",\"patientName\":\"Carmen Martínez López\",\"email\":\"carmen.martinez@example.com\",\"phone\":\"+34600112233\",\"status\":\"NEW_REQUEST\",\"diagnosis\":\"Carcinoma ductal infiltrante de mama estadio IIA\",\"clinical_question\":\"¿Es aconsejable tratamiento de hormonoterapia adyuvante prolongado o quimioterapia previa a la cirugía conservadora?\",\"createdAt\":\"2026-08-13T18:17:03+02:00\",\"updatedAt\":\"2026-08-17T12:17:18+02:00\",\"checklist\":{\"medicalReport\":\"MISSING\",\"pathology\":\"MISSING\",\"imaging\":\"MISSING\",\"treatment\":\"NOT_REQUIRED\",\"labs\":\"MISSING\",\"genomics\":\"NOT_REQUIRED\",\"medication\":\"MISSING\",\"clinical_question\":\"PRESENT\",\"pruebas_imagen\":\"PRESENT\",\"anatomia_patologica\":\"MISSING\"},\"dricloud\":{\"formUrl\":null,\"patientId\":null},\"events\":[{\"type\":\"NEW_REQUEST\",\"at\":\"2026-08-13T18:17:03+02:00\",\"actor\":\"Paciente (Web Pública)\"}]}', 'NORMAL');

-- --------------------------------------------------------

--
-- Table structure for table `case_checklists`
--

CREATE TABLE `case_checklists` (
  `case_id` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `medical_report` varchar(50) COLLATE utf8mb4_general_ci DEFAULT 'MISSING',
  `pathology` varchar(50) COLLATE utf8mb4_general_ci DEFAULT 'MISSING',
  `imaging` varchar(50) COLLATE utf8mb4_general_ci DEFAULT 'MISSING',
  `treatment` varchar(50) COLLATE utf8mb4_general_ci DEFAULT 'MISSING',
  `labs` varchar(50) COLLATE utf8mb4_general_ci DEFAULT 'MISSING',
  `genomics` varchar(50) COLLATE utf8mb4_general_ci DEFAULT 'NOT_REQUIRED',
  `medication` varchar(50) COLLATE utf8mb4_general_ci DEFAULT 'MISSING',
  `clinical_question` varchar(50) COLLATE utf8mb4_general_ci DEFAULT 'PRESENT'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `case_checklists`
--

INSERT INTO `case_checklists` (`case_id`, `medical_report`, `pathology`, `imaging`, `treatment`, `labs`, `genomics`, `medication`, `clinical_question`) VALUES
('CASE-42994', 'MISSING', 'MISSING', 'MISSING', 'MISSING', 'MISSING', 'NOT_REQUIRED', 'MISSING', 'PRESENT'),
('CASE-DEMO-1', 'MISSING', 'MISSING', 'MISSING', 'MISSING', 'MISSING', 'NOT_REQUIRED', 'MISSING', 'PRESENT');

-- --------------------------------------------------------

--
-- Table structure for table `case_events`
--

CREATE TABLE `case_events` (
  `id` int NOT NULL,
  `case_id` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `event_type` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `actor` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `metadata` text COLLATE utf8mb4_general_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `case_events`
--

INSERT INTO `case_events` (`id`, `case_id`, `event_type`, `actor`, `metadata`, `created_at`) VALUES
(1, 'CASE-DEMO-1', 'REQUEST_SUBMITTED', 'Paciente (Carmen Gómez)', 'null', '2026-08-13 09:38:59'),
(3, 'CASE-42994', 'SOLICITUD_CREADA', 'Nacho Ortega', NULL, '2026-08-13 09:47:17');

-- --------------------------------------------------------

--
-- Table structure for table `clinical_cases`
--

CREATE TABLE `clinical_cases` (
  `id` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `public_reference` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `patient_name` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `phone` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `patient_type` varchar(50) COLLATE utf8mb4_general_ci DEFAULT 'self',
  `diagnosis` text COLLATE utf8mb4_general_ci NOT NULL,
  `reason` text COLLATE utf8mb4_general_ci NOT NULL,
  `clinical_question` text COLLATE utf8mb4_general_ci NOT NULL,
  `status` varchar(50) COLLATE utf8mb4_general_ci DEFAULT 'NEW_REQUEST',
  `dricloud_patient_id` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `dricloud_form_sent_at` datetime DEFAULT NULL,
  `dricloud_form_completed_at` datetime DEFAULT NULL,
  `sms_status` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `sms_sent_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `priority` varchar(50) COLLATE utf8mb4_general_ci DEFAULT 'NORMAL'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `clinical_cases`
--

INSERT INTO `clinical_cases` (`id`, `public_reference`, `patient_name`, `email`, `phone`, `patient_type`, `diagnosis`, `reason`, `clinical_question`, `status`, `dricloud_patient_id`, `dricloud_form_sent_at`, `dricloud_form_completed_at`, `sms_status`, `sms_sent_at`, `created_at`, `updated_at`, `priority`) VALUES
('CASE-42994', 'REF-83476', 'Nacho Ortega', 'nachonon9@gmail.com', '605629341', 'self', 'ss', 's', 's', 'NEW_REQUEST', NULL, NULL, NULL, NULL, NULL, '2026-08-13 09:47:17', '2026-08-13 09:47:17', 'NORMAL'),
('CASE-DEMO-1', 'REF-84920', 'Carmen Gómez Ruiz', 'carmen.gomez@example.com', '+34600112233', 'self', 'Adenocarcinoma de mama estadio II', 'Buscar segunda opinión sobre pauta de quimioterapia adyuvante.', '¿Es recomendable añadir inmunoterapia o mantener tratamiento estándar?', 'NEW_REQUEST', NULL, NULL, NULL, NULL, NULL, '2026-08-13 09:38:59', '2026-08-13 09:38:59', 'NORMAL');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `backend_users`
--
ALTER TABLE `backend_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `cases`
--
ALTER TABLE `cases`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `case_checklists`
--
ALTER TABLE `case_checklists`
  ADD PRIMARY KEY (`case_id`);

--
-- Indexes for table `case_events`
--
ALTER TABLE `case_events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `case_id` (`case_id`);

--
-- Indexes for table `clinical_cases`
--
ALTER TABLE `clinical_cases`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `backend_users`
--
ALTER TABLE `backend_users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `case_events`
--
ALTER TABLE `case_events`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `case_checklists`
--
ALTER TABLE `case_checklists`
  ADD CONSTRAINT `case_checklists_ibfk_1` FOREIGN KEY (`case_id`) REFERENCES `clinical_cases` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `case_events`
--
ALTER TABLE `case_events`
  ADD CONSTRAINT `case_events_ibfk_1` FOREIGN KEY (`case_id`) REFERENCES `clinical_cases` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
