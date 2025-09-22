-- Adminer 4.8.1 MySQL 8.0.33-0ubuntu0.20.04.4 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `workers_addresses`;
CREATE TABLE `workers_addresses` (
  `id` int NOT NULL AUTO_INCREMENT,
  `application_id` int NOT NULL,
  `worker_id` int NOT NULL,
  `address` text,
  `city` char(100) DEFAULT NULL,
  `country` char(100) DEFAULT NULL,
  `post_code` char(20) DEFAULT NULL,
  `from_date` date DEFAULT NULL,
  `utility_bill` text,
  `bank_statement` text,
  `dnla` text,
  `details` text,
  `status` char(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL DEFAULT 'pending',
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;


DROP TABLE IF EXISTS `workers_basics`;
CREATE TABLE `workers_basics` (
  `id` int NOT NULL AUTO_INCREMENT,
  `application_id` int NOT NULL,
  `worker_id` int NOT NULL,
  `job_id` int NOT NULL,
  `title` char(10) NOT NULL,
  `first_name` char(100) NOT NULL,
  `last_name` char(100) NOT NULL,
  `gender` char(10) DEFAULT NULL,
  `marital_status` char(15) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `nationality_id` int NOT NULL,
  `phone` char(20) DEFAULT NULL,
  `alternative_phone` char(20) DEFAULT NULL,
  `email` char(100) NOT NULL,
  `ni_number` char(200) DEFAULT NULL,
  `next_of_kin_name` char(200) DEFAULT NULL,
  `kin_relationship_id` int DEFAULT NULL,
  `kin_phone` char(20) DEFAULT NULL,
  `holidays_entitlement` int NOT NULL,
  `worker_photo` text,
  `first_uk_entry` date DEFAULT NULL,
  `passport_expiry` date DEFAULT NULL,
  `passport_front` text,
  `passport_back` text,
  `visa_expiry` date DEFAULT NULL,
  `visa_type` char(100) DEFAULT NULL,
  `university_letter` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
  `need_uk_visa` char(10) DEFAULT NULL,
  `work_availability` char(100) DEFAULT NULL,
  `have_own_transport` char(10) DEFAULT NULL,
  `license_type` char(100) DEFAULT NULL,
  `joining_date` date DEFAULT NULL,
  `client_id` int NOT NULL,
  `client_start_date` date DEFAULT NULL,
  `client_end_date` date DEFAULT NULL,
  `registration_date` date DEFAULT NULL,
  `english_spoken_lavel` int NOT NULL,
  `english_written_lavel` int NOT NULL,
  `english_reading_lavel` int NOT NULL,
  `criminal_record_1` char(10) DEFAULT NULL,
  `criminal_record_2` char(10) DEFAULT NULL,
  `criminal_record_3` char(10) DEFAULT NULL,
  `unspent_convictions` text,
  `details` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
  `status` char(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL DEFAULT 'pending',
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;


DROP TABLE IF EXISTS `workers_documents`;
CREATE TABLE `workers_documents` (
  `id` int NOT NULL AUTO_INCREMENT,
  `application_id` int NOT NULL,
  `worker_id` int NOT NULL,
  `document_type_id` int NOT NULL,
  `document` text,
  `details` text,
  `status` char(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL DEFAULT 'pending',
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;


DROP TABLE IF EXISTS `workers_employments`;
CREATE TABLE `workers_employments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `application_id` int NOT NULL,
  `worker_id` int NOT NULL,
  `no_employment` int NOT NULL DEFAULT '0',
  `employment_position` text,
  `leaving_reason` text,
  `reference_name` char(200) DEFAULT NULL,
  `reference_address` char(200) DEFAULT NULL,
  `reference_phone` char(20) DEFAULT NULL,
  `reference_email` char(64) DEFAULT NULL,
  `from_date` date DEFAULT NULL,
  `to_date` date DEFAULT NULL,
  `biometric_front` text,
  `biometric_back` text,
  `details` text,
  `status` char(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL DEFAULT 'pending',
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;


DROP TABLE IF EXISTS `workers_employments_references`;
CREATE TABLE `workers_employments_references` (
  `id` int NOT NULL AUTO_INCREMENT,
  `application_id` int NOT NULL,
  `worker_id` int NOT NULL,
  `reference_name` char(200) DEFAULT NULL,
  `reference_phone` char(20) DEFAULT NULL,
  `details` text,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;


DROP TABLE IF EXISTS `workers_grievances`;
CREATE TABLE `workers_grievances` (
  `id` int NOT NULL AUTO_INCREMENT,
  `application_id` int NOT NULL,
  `worker_id` int NOT NULL,
  `user_id` int NOT NULL,
  `grievance_type_id` int NOT NULL,
  `grievance_date` date NOT NULL,
  `grievance_time` time NOT NULL,
  `comments` text NOT NULL,
  `details` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
  `status` char(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL DEFAULT 'pending',
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;


DROP TABLE IF EXISTS `workers_healths`;
CREATE TABLE `workers_healths` (
  `id` int NOT NULL AUTO_INCREMENT,
  `application_id` int NOT NULL,
  `worker_id` int NOT NULL,
  `heart_bp` char(10) NOT NULL,
  `asthma_bronchitis_shortness_breath` char(10) NOT NULL,
  `diabetes` char(10) NOT NULL,
  `epilepsy_fainting_attacks` char(10) NOT NULL,
  `migraine` char(10) NOT NULL,
  `severe_head_injury` char(10) NOT NULL,
  `back_problems` char(10) NOT NULL,
  `allergies` char(10) NOT NULL,
  `nut_allergy` char(10) NOT NULL,
  `heart_circulatory_diseases` char(10) NOT NULL,
  `stomach_intestinal_disorders` char(10) NOT NULL,
  `difficulty_sleeping` char(10) NOT NULL,
  `fractures_ligament_damage` char(10) NOT NULL,
  `physical_other_disability` char(10) NOT NULL,
  `psychiatric_mental_illness` char(10) NOT NULL,
  `hospitalised_last_2years` char(10) NOT NULL,
  `suffered_carrier_infectious_diseases` char(10) NOT NULL,
  `registered_disabled` char(10) NOT NULL,
  `tuberculosis` char(10) NOT NULL,
  `skin_trouble_dermatitis` char(10) NOT NULL,
  `indigestive_stomach_trouble` char(10) NOT NULL,
  `chronic_chest_disorders` char(10) NOT NULL,
  `strict_time_medication` char(10) NOT NULL,
  `night_unfitness` char(10) NOT NULL,
  `health_details` text,
  `medication_details` text,
  `disclosure` int DEFAULT NULL,
  `details` text,
  `status` char(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL DEFAULT 'pending',
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;


DROP TABLE IF EXISTS `workers_payrolls`;
CREATE TABLE `workers_payrolls` (
  `id` int NOT NULL AUTO_INCREMENT,
  `application_id` int NOT NULL,
  `worker_id` int NOT NULL,
  `account_holder` char(200) NOT NULL,
  `account_number` char(100) NOT NULL,
  `sort_code` char(100) NOT NULL,
  `bank_name` char(100) NOT NULL,
  `other_info` text,
  `primary` char(10) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `employee_statement` char(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `bank_letter` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
  `details` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
  `status` char(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL DEFAULT 'pending',
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;


DROP TABLE IF EXISTS `workers_policies`;
CREATE TABLE `workers_policies` (
  `id` int NOT NULL AUTO_INCREMENT,
  `application_id` int NOT NULL,
  `worker_id` int NOT NULL,
  `agreement1` int NOT NULL,
  `agreement2` int NOT NULL,
  `agreement3` int NOT NULL,
  `details` text,
  `status` char(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL DEFAULT 'pending',
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;


DROP TABLE IF EXISTS `workers_references`;
CREATE TABLE `workers_references` (
  `id` int NOT NULL AUTO_INCREMENT,
  `application_id` int NOT NULL,
  `worker_id` int NOT NULL,
  `referee_name` char(200) DEFAULT NULL,
  `referee_phone` char(20) DEFAULT NULL,
  `referee_email` char(64) DEFAULT NULL,
  `referee_profession` char(200) DEFAULT NULL,
  `referee_relationship_id` int NOT NULL,
  `referee_address` text,
  `know_last_5years` char(10) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `details` text,
  `status` char(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL DEFAULT 'pending',
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;


DROP TABLE IF EXISTS `workers_trainings`;
CREATE TABLE `workers_trainings` (
  `id` int NOT NULL AUTO_INCREMENT,
  `application_id` int NOT NULL,
  `worker_id` int NOT NULL,
  `no_training` int NOT NULL DEFAULT '0',
  `qualification` char(200) DEFAULT NULL,
  `institute` char(200) DEFAULT NULL,
  `award_date` date DEFAULT NULL,
  `course_length` char(100) DEFAULT NULL,
  `institute_contact_name` char(200) DEFAULT NULL,
  `institute_contact_phone` char(20) DEFAULT NULL,
  `institute_contact_email` char(100) DEFAULT NULL,
  `institute_address` text,
  `from_date` date DEFAULT NULL,
  `to_date` date DEFAULT NULL,
  `details` text,
  `status` char(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL DEFAULT 'pending',
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;


DROP TABLE IF EXISTS `applications`;
CREATE TABLE `applications` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `job_id` int NOT NULL,
  `client_id` int NOT NULL,
  `location` text,
  `details` text,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;


DROP TABLE IF EXISTS `attendance`;
CREATE TABLE `attendance` (
  `id` int NOT NULL AUTO_INCREMENT,
  `worker_id` int NOT NULL,
  `date` datetime DEFAULT NULL,
  `in_time` datetime DEFAULT NULL,
  `in_note` char(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `out_time` datetime DEFAULT NULL,
  `out_note` char(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `hours` float NOT NULL DEFAULT '0',
  `details` text,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;


DROP TABLE IF EXISTS `awarding_bodies`;
CREATE TABLE `awarding_bodies` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` char(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `details` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;


DROP TABLE IF EXISTS `clients`;
CREATE TABLE `clients` (
  `id` int NOT NULL AUTO_INCREMENT,
  `business_name` char(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `contact_person` char(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `email` char(64) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `phone` char(15) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `contract_start` date DEFAULT NULL,
  `contract_end` date DEFAULT NULL,
  `details` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;


DROP TABLE IF EXISTS `companies`;
CREATE TABLE `companies` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` char(100) NOT NULL,
  `address` char(200) DEFAULT NULL,
  `city` char(100) NOT NULL,
  `postal` char(20) NOT NULL,
  `phone` char(16) NOT NULL,
  `fax` char(16) NOT NULL,
  `email` char(64) NOT NULL,
  `website` char(200) NOT NULL,
  `logo` char(200) DEFAULT NULL,
  `user_id` int NOT NULL,
  `details` text,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;


DROP TABLE IF EXISTS `countries`;
CREATE TABLE `countries` (
  `id` int NOT NULL AUTO_INCREMENT,
  `value` char(255) DEFAULT NULL,
  `label` char(255) DEFAULT NULL,
  `details` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;


DROP TABLE IF EXISTS `document_types`;
CREATE TABLE `document_types` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` char(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `details` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;


DROP TABLE IF EXISTS `grievance_types`;
CREATE TABLE `grievance_types` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` char(255) NOT NULL,
  `details` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;


DROP TABLE IF EXISTS `holidays`;
CREATE TABLE `holidays` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` char(255) NOT NULL,
  `date` date NOT NULL,
  `details` text,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;


DROP TABLE IF EXISTS `jobs`;
CREATE TABLE `jobs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` char(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `details` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;


DROP TABLE IF EXISTS `leaves`;
CREATE TABLE `leaves` (
  `id` int NOT NULL AUTO_INCREMENT,
  `holiday_id` int NOT NULL,
  `worker_id` int NOT NULL,
  `message` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
  `comment` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
  `status` char(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL DEFAULT 'pending',
  `details` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;


DROP TABLE IF EXISTS `nationalities`;
CREATE TABLE `nationalities` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` char(255) NOT NULL,
  `details` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;


DROP TABLE IF EXISTS `notifications`;
CREATE TABLE `notifications` (
  `id` int NOT NULL AUTO_INCREMENT,
  `sender_id` int NOT NULL,
  `receiver_id` int NOT NULL,
  `receiver_type` char(16) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `content` text,
  `url` text,
  `status` char(10) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL DEFAULT 'unread',
  `details` text,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;


DROP TABLE IF EXISTS `relationships`;
CREATE TABLE `relationships` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` char(255) NOT NULL,
  `details` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;


DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` char(100) NOT NULL,
  `permissions` text,
  `details` text,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;


DROP TABLE IF EXISTS `skillsets`;
CREATE TABLE `skillsets` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` char(100) NOT NULL,
  `wage` float NOT NULL,
  `details` text,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;


DROP TABLE IF EXISTS `training_types`;
CREATE TABLE `training_types` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` char(255) NOT NULL,
  `details` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;


DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `first_name` char(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `last_name` char(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `full_name` char(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `image` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
  `email` char(64) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `username` char(64) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `password` char(64) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `phone` char(16) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `role_id` int NOT NULL,
  `details` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
  `tz_offset` int NOT NULL,
  `last_loggedin` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;


DROP TABLE IF EXISTS `workers`;
CREATE TABLE `workers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `job_id` int NOT NULL,
  `first_name` char(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `last_name` char(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `account_name` char(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `image` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
  `gender` char(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `dob` date DEFAULT NULL,
  `email` char(64) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `username` char(64) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `password` char(64) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `phone` char(16) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `details` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
  `status` char(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL DEFAULT 'pending',
  `tz_offset` int NOT NULL,
  `last_loggedin` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;


-- 2023-08-16 18:42:04
