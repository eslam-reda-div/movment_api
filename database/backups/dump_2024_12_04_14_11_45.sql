-- MySQL dump 10.13  Distrib 8.0.30, for Win64 (x86_64)
--
-- Host: localhost    Database: movement
-- ------------------------------------------------------
-- Server version	11.4.2-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `activity_log`
--

DROP TABLE IF EXISTS `activity_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `activity_log` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `log_name` varchar(255) DEFAULT NULL,
  `description` text NOT NULL,
  `subject_type` varchar(255) DEFAULT NULL,
  `event` varchar(255) DEFAULT NULL,
  `subject_id` bigint(20) unsigned DEFAULT NULL,
  `causer_type` varchar(255) DEFAULT NULL,
  `causer_id` bigint(20) unsigned DEFAULT NULL,
  `properties` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`properties`)),
  `batch_uuid` char(36) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `subject` (`subject_type`,`subject_id`),
  KEY `causer` (`causer_type`,`causer_id`),
  KEY `activity_log_log_name_index` (`log_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `activity_log`
--

LOCK TABLES `activity_log` WRITE;
/*!40000 ALTER TABLE `activity_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `activity_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admin_password_reset_tokens`
--

DROP TABLE IF EXISTS `admin_password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `admin_password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_password_reset_tokens`
--

LOCK TABLES `admin_password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `admin_password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `admin_password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admins`
--

DROP TABLE IF EXISTS `admins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `admins` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `notes` text DEFAULT NULL,
  `phone_number` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `avatar_url` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `theme` varchar(255) DEFAULT 'sunset',
  `theme_color` varchar(255) DEFAULT 'blue',
  PRIMARY KEY (`id`),
  UNIQUE KEY `admins_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admins`
--

LOCK TABLES `admins` WRITE;
/*!40000 ALTER TABLE `admins` DISABLE KEYS */;
INSERT INTO `admins` (`id`, `name`, `notes`, `phone_number`, `email`, `avatar_url`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `theme`, `theme_color`) VALUES (1,'Admin',NULL,NULL,'admin@admin.com',NULL,'2024-12-03 20:05:59','$2y$12$D16Gzmk9QLmfM9V4.NAbPOeBx9rdaI3aKk46iRdWW5V7EWBlt5MRu','1pDmSyOIvw','2024-12-03 20:05:59','2024-12-03 20:05:59','sunset','blue');
/*!40000 ALTER TABLE `admins` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `banners`
--

DROP TABLE IF EXISTS `banners`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `banners` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`data`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `banners`
--

LOCK TABLES `banners` WRITE;
/*!40000 ALTER TABLE `banners` DISABLE KEYS */;
/*!40000 ALTER TABLE `banners` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `buses`
--

DROP TABLE IF EXISTS `buses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `buses` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `number` varchar(255) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `notes` text DEFAULT NULL,
  `seats_count` int(11) NOT NULL DEFAULT 0,
  `latitude` varchar(255) DEFAULT NULL,
  `longitude` varchar(255) DEFAULT NULL,
  `company_id` bigint(20) unsigned DEFAULT NULL,
  `driver_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `buses_uuid_unique` (`uuid`),
  KEY `buses_company_id_foreign` (`company_id`),
  KEY `buses_driver_id_foreign` (`driver_id`),
  CONSTRAINT `buses_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  CONSTRAINT `buses_driver_id_foreign` FOREIGN KEY (`driver_id`) REFERENCES `drivers` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `buses`
--

LOCK TABLES `buses` WRITE;
/*!40000 ALTER TABLE `buses` DISABLE KEYS */;
INSERT INTO `buses` (`id`, `uuid`, `name`, `number`, `image_url`, `is_active`, `notes`, `seats_count`, `latitude`, `longitude`, `company_id`, `driver_id`, `created_at`, `updated_at`) VALUES (1,'f342e0a8-c786-4a08-9695-d80171048424','saepe mollitia','BUS-1001',NULL,1,'Nihil vitae modi quidem laboriosam non.',17,'31.040186','31.362358',1,1,'2024-12-03 20:06:01','2024-12-03 20:06:02'),(2,'19510546-a7c0-44ed-9246-aef398434f5a','magnam pariatur','BUS-2571',NULL,1,'Iusto laudantium incidunt quibusdam.',47,'31.04581','31.359613',1,2,'2024-12-03 20:06:01','2024-12-03 20:06:02'),(3,'a1563311-16ae-4176-b34b-718bd1337c70','veniam tempore','BUS-8951',NULL,1,'Ad nobis perspiciatis sint.',47,'31.036202','31.36296',1,NULL,'2024-12-03 20:06:01','2024-12-03 20:06:01'),(4,'543a8b42-7040-4de8-b0f2-5ea50599ef64','rerum nihil','BUS-8377',NULL,1,'Vel explicabo odio nisi non.',30,'31.054941','31.351233',2,3,'2024-12-03 20:06:01','2024-12-03 20:06:02'),(5,'49a47b03-3494-4ab8-b7be-5ccf4dc2d7f9','facere ut','BUS-2206',NULL,1,'Quia quia voluptas corrupti.',27,'31.039427','31.36801',2,4,'2024-12-03 20:06:01','2024-12-03 20:06:02'),(6,'27b231bb-5ec4-49e9-a266-8dd1140d0e0e','quibusdam aperiam','BUS-1868',NULL,1,'Veniam earum illum eum.',28,'31.044238','31.378092',2,NULL,'2024-12-03 20:06:01','2024-12-03 20:06:01'),(7,'666fa801-173c-43a7-a0e4-da66c92ee95a','enim placeat','BUS-6753',NULL,0,'Aut et enim beatae fugit voluptatibus.',30,'31.0353','31.384366',3,5,'2024-12-03 20:06:01','2024-12-03 20:06:03'),(8,'d1a7273a-e012-4fac-94f3-10e703994278','quo consequatur','BUS-5454',NULL,1,'Eum laborum velit deserunt nam nemo.',26,'31.048813','31.383924',3,6,'2024-12-03 20:06:01','2024-12-03 20:06:03'),(9,'1510442e-348d-481b-b3e9-ee20f1a91c2c','eius similique','BUS-7275',NULL,1,'Explicabo quasi qui aliquid tempore.',42,'31.031277','31.371705',3,NULL,'2024-12-03 20:06:01','2024-12-03 20:06:01'),(10,'8c8b728c-1d7d-4982-a12f-7c1a1ce0031d','animi iste','BUS-9026',NULL,1,'Delectus id voluptatem eveniet et.',30,'31.03231','31.378646',NULL,NULL,'2024-12-03 20:06:04','2024-12-03 20:06:04'),(11,'ee42d3a1-2651-4659-a496-c38871a91b0a','quos sapiente','BUS-9317',NULL,1,'Aut ab illum adipisci quis.',43,'31.055456','31.384643',NULL,NULL,'2024-12-03 20:06:04','2024-12-03 20:06:04'),(12,'29b3af91-c309-4089-9efb-da8935580476','exercitationem eum','BUS-3417',NULL,1,'Incidunt quo vitae harum atque.',35,'31.047786','31.384279',NULL,NULL,'2024-12-03 20:06:04','2024-12-03 20:06:04');
/*!40000 ALTER TABLE `buses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `companies`
--

DROP TABLE IF EXISTS `companies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `companies` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `notes` text DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `bus_limit` bigint(20) NOT NULL DEFAULT 1,
  `phone_number` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `avatar_url` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `theme` varchar(255) DEFAULT 'sunset',
  `theme_color` varchar(255) DEFAULT 'blue',
  PRIMARY KEY (`id`),
  UNIQUE KEY `companies_email_unique` (`email`),
  UNIQUE KEY `companies_phone_number_unique` (`phone_number`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `companies`
--

LOCK TABLES `companies` WRITE;
/*!40000 ALTER TABLE `companies` DISABLE KEYS */;
INSERT INTO `companies` (`id`, `name`, `notes`, `address`, `bus_limit`, `phone_number`, `email`, `avatar_url`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `theme`, `theme_color`) VALUES (1,'معرض زين العابدين','Possimus impedit sed ut velit.','1957 طريق هشام عز الدين عمارة رقم 24\nالتجمع الخامس',5,'(850) 539-8252','abc@transport.com',NULL,NULL,'$2y$12$lnd9IUdeZ6GSCE9D0BgdqeMKoZG/LhbFPkH/3h0L372siqGvd/e7a','i8xu5u4ps3','2024-12-03 20:06:00','2024-12-03 20:06:00','sunset','blue'),(2,'شركة الكفراوي  ش.م.م','Culpa ipsa aliquam aut id.','2325 شارع ناديا عبد الرحمن\nالعباسية',5,'440.326.7350','city@express.com',NULL,NULL,'$2y$12$ip7p05XVpICtmwD3EcGlveL0m5yYUqGgoqECPOYy/LTPfXuvwv0Qy','pQYnwYb6G2','2024-12-03 20:06:00','2024-12-03 20:06:00','sunset','blue'),(3,'أكاديمية السعيد للخدمات الدولية','Autem iusto aliquam aut non quam atque.','87707 ممر تالة عبد الكريم عمارة رقم 03\nباب اللوق',5,'302-591-9930','metro@lines.com',NULL,NULL,'$2y$12$qsdfAUVGgy/ITGOcz5Q2i.c/a7g4IbNNYqPHN5wPv7pDfIlWOb1su','L2C2y3xNei','2024-12-03 20:06:00','2024-12-03 20:06:00','sunset','blue');
/*!40000 ALTER TABLE `companies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `company_password_reset_tokens`
--

DROP TABLE IF EXISTS `company_password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `company_password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `company_password_reset_tokens`
--

LOCK TABLES `company_password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `company_password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `company_password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `destinations`
--

DROP TABLE IF EXISTS `destinations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `destinations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `notes` text DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `location` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`location`)),
  `domain_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `destinations_domain_id_foreign` (`domain_id`),
  CONSTRAINT `destinations_domain_id_foreign` FOREIGN KEY (`domain_id`) REFERENCES `domains` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `destinations`
--

LOCK TABLES `destinations` WRITE;
/*!40000 ALTER TABLE `destinations` DISABLE KEYS */;
INSERT INTO `destinations` (`id`, `name`, `notes`, `is_active`, `location`, `domain_id`, `created_at`, `updated_at`) VALUES (1,'السيدة زينب','Ut commodi tempora natus iste.',0,'{\"lat\":27.007999,\"lng\":33.240114}',1,'2024-12-03 20:06:04','2024-12-03 20:06:04'),(2,'هارون','Illum molestias voluptas non.',1,'{\"lat\":27.007999,\"lng\":33.240114}',1,'2024-12-03 20:06:04','2024-12-03 20:06:04'),(3,'الكيت كات','Laborum est est sequi maxime.',1,'{\"lat\":27.007999,\"lng\":33.240114}',1,'2024-12-03 20:06:04','2024-12-03 20:06:04'),(4,'ألف مسكن','Qui expedita quisquam eum placeat est.',1,'{\"lat\":27.007999,\"lng\":33.240114}',1,'2024-12-03 20:06:04','2024-12-03 20:06:04'),(5,'عبده باشا','Est autem aut aut sit quo.',1,'{\"lat\":34.51467,\"lng\":31.66024}',2,'2024-12-03 20:06:04','2024-12-03 20:06:04'),(6,'الشيخ زايد','Dolore magni eum ut molestiae.',1,'{\"lat\":34.51467,\"lng\":31.66024}',2,'2024-12-03 20:06:04','2024-12-03 20:06:04'),(7,'المقطم','Assumenda quia est ad cumque.',0,'{\"lat\":34.51467,\"lng\":31.66024}',2,'2024-12-03 20:06:04','2024-12-03 20:06:04'),(8,'ألف مسكن','Tempora quis aliquam quasi reiciendis.',1,'{\"lat\":34.51467,\"lng\":31.66024}',2,'2024-12-03 20:06:04','2024-12-03 20:06:04'),(9,'الزهراء','Nobis et sit unde officia vero.',1,'{\"lat\":28.527425,\"lng\":35.583823}',3,'2024-12-03 20:06:04','2024-12-03 20:06:04'),(10,'ألف مسكن','Nihil iste nesciunt sit.',0,'{\"lat\":28.527425,\"lng\":35.583823}',3,'2024-12-03 20:06:04','2024-12-03 20:06:04'),(11,'التجمع الاول','Sed vero ab beatae et.',1,'{\"lat\":28.527425,\"lng\":35.583823}',3,'2024-12-03 20:06:04','2024-12-03 20:06:04'),(12,'كوتسيكا','Similique ullam beatae officia fuga.',1,'{\"lat\":28.527425,\"lng\":35.583823}',3,'2024-12-03 20:06:04','2024-12-03 20:06:04'),(13,'الحسين','Et quia culpa accusamus dignissimos ut.',1,'{\"lat\":32.315643,\"lng\":40.572312}',4,'2024-12-03 20:06:04','2024-12-03 20:06:04'),(14,'المنيل','Adipisci officiis est quis occaecati.',0,'{\"lat\":32.315643,\"lng\":40.572312}',4,'2024-12-03 20:06:04','2024-12-03 20:06:04'),(15,'الجزيرة','Ipsa et deserunt reiciendis a.',1,'{\"lat\":32.315643,\"lng\":40.572312}',4,'2024-12-03 20:06:04','2024-12-03 20:06:04'),(16,'العباسية','Sunt quis minus hic expedita aut.',1,'{\"lat\":32.315643,\"lng\":40.572312}',4,'2024-12-03 20:06:04','2024-12-03 20:06:04');
/*!40000 ALTER TABLE `destinations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `domains`
--

DROP TABLE IF EXISTS `domains`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `domains` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `domains`
--

LOCK TABLES `domains` WRITE;
/*!40000 ALTER TABLE `domains` DISABLE KEYS */;
INSERT INTO `domains` (`id`, `name`, `is_active`, `notes`, `created_at`, `updated_at`) VALUES (1,'ثكنات المعادي',1,'Soluta odit quis sit minima esse.','2024-12-03 20:06:04','2024-12-03 20:06:04'),(2,'حدائق القبة',1,'Et eius fugiat qui aut maiores autem.','2024-12-03 20:06:04','2024-12-03 20:06:04'),(3,'المنيب',1,'Ut et nobis eum explicabo.','2024-12-03 20:06:04','2024-12-03 20:06:04'),(4,'عين شمس',0,'Rem quos aut quo.','2024-12-03 20:06:04','2024-12-03 20:06:04');
/*!40000 ALTER TABLE `domains` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `driver_password_reset_tokens`
--

DROP TABLE IF EXISTS `driver_password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `driver_password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `driver_password_reset_tokens`
--

LOCK TABLES `driver_password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `driver_password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `driver_password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `drivers`
--

DROP TABLE IF EXISTS `drivers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `drivers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `phone_number` varchar(255) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `avatar_url` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `home_address` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `company_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `drivers_uuid_unique` (`uuid`),
  UNIQUE KEY `drivers_phone_number_unique` (`phone_number`),
  KEY `drivers_company_id_foreign` (`company_id`),
  CONSTRAINT `drivers_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `drivers`
--

LOCK TABLES `drivers` WRITE;
/*!40000 ALTER TABLE `drivers` DISABLE KEYS */;
INSERT INTO `drivers` (`id`, `uuid`, `name`, `phone_number`, `notes`, `avatar_url`, `password`, `home_address`, `remember_token`, `company_id`, `created_at`, `updated_at`) VALUES (1,'c5725be6-0377-37aa-880f-26d79d25c091','د. تمارا السايس','1-445-334-7382','Et voluptatem quia non ut.',NULL,'$2y$12$F2xX1T2iHaDtKoqhP/vTN.Bfh/pBXoqWP52qhfDsmWjBDphfK6uDi','5382 ممر سليم صدام\nالكيت كات',NULL,1,'2024-12-03 20:06:02','2024-12-03 20:06:02'),(2,'9afcd341-20e5-3c1d-9d83-da0d19c354e3','مسعد السايس','+1 (845) 936-8899','Aut repudiandae quis est.',NULL,'$2y$12$IC2pwdhcvrvvlBm9pm/PEuhQWXgffQJceAGUe2hKtqkGjYgaxMhlW','97 طريق زيدان عبد المطلب شقة رقم. 77\nالرحاب',NULL,1,'2024-12-03 20:06:02','2024-12-03 20:06:02'),(3,'be9fd2f1-2972-38c6-8fe2-561019614c56','الدكتورة أمنة عبد الحليم','1-678-536-1477','Quia iste enim autem atque.',NULL,'$2y$12$9ZpHirkHOa.nTt/z2mvktulrlf49n3jfibsc12ifz59b5sELYQ/dC','20467 ممر حنين شافع شقة رقم. 99\nزهراء المعادي',NULL,2,'2024-12-03 20:06:02','2024-12-03 20:06:02'),(4,'185dc5e8-f8de-3e7a-bdb2-37b0ac2a1741','أسماء عبد الرزاق','380.692.2290','Ut quasi ducimus delectus ea dolor vel.',NULL,'$2y$12$uZOvs/RNMRiwEA8CX2VU6.7vYikUOOrb1PsNvq/TYWzqdkOOJmGn2','87134 شارع سليمان عبد الله عمارة رقم 25\nالمنيل',NULL,2,'2024-12-03 20:06:02','2024-12-03 20:06:02'),(5,'814f9507-9b7b-3cf5-920a-a0e190b1defc','المهندسة إنعام عبد المعطي','+1-469-365-0663','Accusamus qui dolor nostrum natus.',NULL,'$2y$12$kzLrftWCodcdnQMa4NOzmuZZBkU9kSSjVUyXdq3iaitdd.H9IadN2','5214 ممر عالية عبد الحميد\nالرحاب',NULL,3,'2024-12-03 20:06:03','2024-12-03 20:06:03'),(6,'8b3a4fb1-3e73-34b6-8c45-78239a832b6b','د. رضوان عبد اللطيف','+17167784728','Dolores et aliquam in voluptatem.',NULL,'$2y$12$X7wd4frklL0FbiGrrsffQ.9okZOTckjPxIbaa/DUF39ayWFf1MUC.','6232 ممر ثريا عبد الكريم\nالمرج',NULL,3,'2024-12-03 20:06:03','2024-12-03 20:06:03'),(7,'8073150b-b395-3bb0-bd84-1c8914e55d6b','أ.د فرح مهران','+1-947-933-0240','Iure nemo molestiae impedit animi.',NULL,'$2y$12$X0Szd23ay9cX5nUDVDBuvu2CrFlcJlYMf2vetB4J4pFYcO1r0CmFi','63 ممر ميس عبد المهيمن عمارة رقم 87\nحدائق القبة',NULL,1,'2024-12-03 20:06:03','2024-12-03 20:06:03'),(8,'57a6cab9-b1b1-3fc3-8988-de368fd60cbb','المهندس فوزي غالب','1-732-871-7452','Aspernatur error quaerat voluptas.',NULL,'$2y$12$/.FWKdMOkhJRQhXH9VF7G.o8lpFXxytbRyAQ8zUhUw.eCMMzToGHK','42576 ممر هايدي عبد الهادي\nشبرا',NULL,2,'2024-12-03 20:06:03','2024-12-03 20:06:03'),(9,'9801a4d1-809b-3f0a-b8c3-d516d45db799','أ. ليان عبد القادر','380.416.4131','Ut eius quae consequatur dolor ut.',NULL,'$2y$12$C7VRCnuMbs/bPQHFuVfGtuhDJV62r2fYAYU2MIknIycBghf1uoBe.','81 شارع رهف عبد الحميد عمارة رقم 04\nشبرا',NULL,3,'2024-12-03 20:06:04','2024-12-03 20:06:04'),(10,'9f4792d3-cbd8-3d5f-a8f6-989859250c49','الآنسة نورا عبد اللطيف','1-337-575-8018','Optio recusandae neque quis.',NULL,'$2y$12$lm93xjTv6mSsU7nbhfDypOfBgAaFBsiO78xFiqY9crxoCbXCkpUxa','3349 طريق أكثم جبر عمارة رقم 44\nالكيت كات',NULL,NULL,'2024-12-03 20:06:04','2024-12-03 20:06:04'),(11,'415cff56-498b-3cef-93f7-956cd02d5e66','الآنسة ميان عبد الجليل','1-872-371-4951','Aut et alias aut fuga.',NULL,'$2y$12$QlBf03HT4QK8OWNkOXeSM.eIba8yIcwXJ99vKoXXUKijQ067KjwLi','69194 شارع غيث عبد الباسط\nالعباسية',NULL,NULL,'2024-12-03 20:06:04','2024-12-03 20:06:04'),(12,'b32a62c0-8847-3f82-add1-910e936ed936','م. فايزة نجيب','+14322094128','Non et ducimus ipsum et.',NULL,'$2y$12$1iKb6/egDKfpOTU4DLkJE.LROr29GOI28NBkml8SVkzaQotTq8Ida','22 شارع كمال عز الدين\nالأزبكية',NULL,NULL,'2024-12-03 20:06:04','2024-12-03 20:06:04');
/*!40000 ALTER TABLE `drivers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `exports`
--

DROP TABLE IF EXISTS `exports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `exports` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `completed_at` timestamp NULL DEFAULT NULL,
  `file_disk` varchar(255) NOT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `exporter` varchar(255) NOT NULL,
  `processed_rows` int(10) unsigned NOT NULL DEFAULT 0,
  `total_rows` int(10) unsigned NOT NULL,
  `successful_rows` int(10) unsigned NOT NULL DEFAULT 0,
  `user_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `exports_user_id_foreign` (`user_id`),
  CONSTRAINT `exports_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `admins` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `exports`
--

LOCK TABLES `exports` WRITE;
/*!40000 ALTER TABLE `exports` DISABLE KEYS */;
/*!40000 ALTER TABLE `exports` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_import_rows`
--

DROP TABLE IF EXISTS `failed_import_rows`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_import_rows` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`data`)),
  `import_id` bigint(20) unsigned NOT NULL,
  `validation_error` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `failed_import_rows_import_id_foreign` (`import_id`),
  CONSTRAINT `failed_import_rows_import_id_foreign` FOREIGN KEY (`import_id`) REFERENCES `imports` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_import_rows`
--

LOCK TABLES `failed_import_rows` WRITE;
/*!40000 ALTER TABLE `failed_import_rows` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_import_rows` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `health_check_result_history_items`
--

DROP TABLE IF EXISTS `health_check_result_history_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `health_check_result_history_items` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `check_name` varchar(255) NOT NULL,
  `check_label` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `notification_message` text DEFAULT NULL,
  `short_summary` varchar(255) DEFAULT NULL,
  `meta` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`meta`)),
  `ended_at` timestamp NOT NULL,
  `batch` char(36) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `health_check_result_history_items_created_at_index` (`created_at`),
  KEY `health_check_result_history_items_batch_index` (`batch`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `health_check_result_history_items`
--

LOCK TABLES `health_check_result_history_items` WRITE;
/*!40000 ALTER TABLE `health_check_result_history_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `health_check_result_history_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `imports`
--

DROP TABLE IF EXISTS `imports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `imports` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `completed_at` timestamp NULL DEFAULT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `importer` varchar(255) NOT NULL,
  `processed_rows` int(10) unsigned NOT NULL DEFAULT 0,
  `total_rows` int(10) unsigned NOT NULL,
  `successful_rows` int(10) unsigned NOT NULL DEFAULT 0,
  `user_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `imports_user_id_foreign` (`user_id`),
  CONSTRAINT `imports_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `admins` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `imports`
--

LOCK TABLES `imports` WRITE;
/*!40000 ALTER TABLE `imports` DISABLE KEYS */;
/*!40000 ALTER TABLE `imports` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mailweb_email_attachments`
--

DROP TABLE IF EXISTS `mailweb_email_attachments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mailweb_email_attachments` (
  `id` char(36) NOT NULL,
  `mailweb_email_id` char(36) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `mailweb_email_attachments_mailweb_email_id_foreign` (`mailweb_email_id`),
  CONSTRAINT `mailweb_email_attachments_mailweb_email_id_foreign` FOREIGN KEY (`mailweb_email_id`) REFERENCES `mailweb_emails` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mailweb_email_attachments`
--

LOCK TABLES `mailweb_email_attachments` WRITE;
/*!40000 ALTER TABLE `mailweb_email_attachments` DISABLE KEYS */;
/*!40000 ALTER TABLE `mailweb_email_attachments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mailweb_emails`
--

DROP TABLE IF EXISTS `mailweb_emails`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mailweb_emails` (
  `id` char(36) NOT NULL,
  `from` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`from`)),
  `to` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`to`)),
  `cc` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`cc`)),
  `bcc` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`bcc`)),
  `subject` varchar(255) DEFAULT NULL,
  `body_html` longtext DEFAULT NULL,
  `body_text` longtext DEFAULT NULL,
  `read` tinyint(1) NOT NULL DEFAULT 0,
  `share_enabled` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mailweb_emails`
--

LOCK TABLES `mailweb_emails` WRITE;
/*!40000 ALTER TABLE `mailweb_emails` DISABLE KEYS */;
/*!40000 ALTER TABLE `mailweb_emails` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mailweb_emails_archived`
--

DROP TABLE IF EXISTS `mailweb_emails_archived`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mailweb_emails_archived` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `email` longtext DEFAULT NULL,
  `read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mailweb_emails_archived`
--

LOCK TABLES `mailweb_emails_archived` WRITE;
/*!40000 ALTER TABLE `mailweb_emails_archived` DISABLE KEYS */;
/*!40000 ALTER TABLE `mailweb_emails_archived` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (1,'0000_00_00_000000_create_mail_web_table',1),(2,'0000_00_00_000001_alter_for_new_mail_web',1),(3,'0000_00_00_000002_add_mail_web_attachment_table',1),(4,'0000_11_22_184512_create_admins_table',1),(5,'0000_11_22_184513_create_companies_table',1),(6,'0000_11_22_184513_create_drivers_table',1),(7,'0001_01_01_000000_create_users_table',1),(8,'0001_01_01_000001_create_cache_table',1),(9,'0001_01_01_000002_create_jobs_table',1),(10,'2022_12_14_083707_create_settings_table',1),(11,'2024_03_21_101408_create_permission_tables',1),(12,'2024_03_21_101458_add_themes_settings_to_users_table',1),(13,'2024_03_21_103139_create_activity_log_table',1),(14,'2024_03_21_103140_add_event_column_to_activity_log_table',1),(15,'2024_03_21_103141_add_batch_uuid_column_to_activity_log_table',1),(16,'2024_06_26_185928_mail_settings',1),(17,'2024_11_23_174108_create_buses_table',1),(18,'2024_11_29_114935_create_domains_table',1),(19,'2024_11_29_132132_create_destinations_table',1),(20,'2024_11_29_181416_create_personal_access_tokens_table',1),(21,'2024_11_30_073931_create_paths_table',1),(22,'2024_11_30_092454_create_trips_table',1),(23,'2024_12_01_111028_create_pulse_tables',1),(24,'2024_12_01_114801_create_health_tables',1),(25,'2024_12_01_125506_sites_settings',1),(26,'2024_12_01_125519_pwa_settings',1),(27,'2024_12_02_185646_create_banner_table',1),(28,'2024_12_03_184900_create_notifications_table',1),(29,'2024_12_03_184914_create_imports_table',1),(30,'2024_12_03_184915_create_exports_table',1),(31,'2024_12_03_184916_create_failed_import_rows_table',1),(32,'2022_09_11_223298_create_types_table',2),(33,'2023_02_13_134607_create_types_metas_table',2),(34,'2023_02_13_143941_create_typables_table',2),(35,'2023_06_13_143941_drop_unique_key_from_types_table',2),(36,'2024_07_18_150031_create_notes_table',2),(37,'2024_07_18_150035_create_note_metas_table',2),(38,'2024_09_11_143941_update_types_table',2);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_permissions`
--

DROP TABLE IF EXISTS `model_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_permissions`
--

LOCK TABLES `model_has_permissions` WRITE;
/*!40000 ALTER TABLE `model_has_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `model_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_roles`
--

DROP TABLE IF EXISTS `model_has_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_roles`
--

LOCK TABLES `model_has_roles` WRITE;
/*!40000 ALTER TABLE `model_has_roles` DISABLE KEYS */;
INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES (1,'App\\Models\\Admin',1);
/*!40000 ALTER TABLE `model_has_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `note_metas`
--

DROP TABLE IF EXISTS `note_metas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `note_metas` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `model_id` bigint(20) unsigned DEFAULT NULL,
  `model_type` varchar(255) DEFAULT NULL,
  `note_id` bigint(20) unsigned NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`value`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `note_metas_note_id_foreign` (`note_id`),
  KEY `note_metas_key_index` (`key`),
  CONSTRAINT `note_metas_note_id_foreign` FOREIGN KEY (`note_id`) REFERENCES `notes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `note_metas`
--

LOCK TABLES `note_metas` WRITE;
/*!40000 ALTER TABLE `note_metas` DISABLE KEYS */;
/*!40000 ALTER TABLE `note_metas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notes`
--

DROP TABLE IF EXISTS `notes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `notes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `group` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT 'pending',
  `model_id` bigint(20) unsigned DEFAULT NULL,
  `model_type` varchar(255) DEFAULT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `user_type` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `body` text DEFAULT NULL,
  `background` varchar(255) DEFAULT '#F4F39E',
  `border` varchar(255) DEFAULT '#DEE184',
  `color` varchar(255) DEFAULT '#47576B',
  `checklist` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`checklist`)),
  `icon` varchar(255) DEFAULT NULL,
  `font_size` varchar(255) DEFAULT '1em',
  `font` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `time` time DEFAULT NULL,
  `is_public` tinyint(1) DEFAULT 0,
  `is_pined` tinyint(1) DEFAULT 0,
  `order` int(11) DEFAULT 0,
  `place_in` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notes_group_index` (`group`),
  KEY `notes_status_index` (`status`),
  KEY `notes_title_index` (`title`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notes`
--

LOCK TABLES `notes` WRITE;
/*!40000 ALTER TABLE `notes` DISABLE KEYS */;
/*!40000 ALTER TABLE `notes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `notifications` (
  `id` char(36) NOT NULL,
  `type` varchar(255) NOT NULL,
  `notifiable_type` varchar(255) NOT NULL,
  `notifiable_id` bigint(20) unsigned NOT NULL,
  `data` text NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notifications`
--

LOCK TABLES `notifications` WRITE;
/*!40000 ALTER TABLE `notifications` DISABLE KEYS */;
/*!40000 ALTER TABLE `notifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `paths`
--

DROP TABLE IF EXISTS `paths`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `paths` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `domain_id` bigint(20) unsigned DEFAULT NULL,
  `company_id` bigint(20) unsigned DEFAULT NULL,
  `from` bigint(20) unsigned DEFAULT NULL,
  `stops` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`stops`)),
  `to` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `paths_uuid_unique` (`uuid`),
  KEY `paths_domain_id_foreign` (`domain_id`),
  KEY `paths_company_id_foreign` (`company_id`),
  KEY `paths_from_foreign` (`from`),
  KEY `paths_to_foreign` (`to`),
  CONSTRAINT `paths_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  CONSTRAINT `paths_domain_id_foreign` FOREIGN KEY (`domain_id`) REFERENCES `domains` (`id`) ON DELETE CASCADE,
  CONSTRAINT `paths_from_foreign` FOREIGN KEY (`from`) REFERENCES `destinations` (`id`) ON DELETE CASCADE,
  CONSTRAINT `paths_to_foreign` FOREIGN KEY (`to`) REFERENCES `destinations` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `paths`
--

LOCK TABLES `paths` WRITE;
/*!40000 ALTER TABLE `paths` DISABLE KEYS */;
INSERT INTO `paths` (`id`, `uuid`, `name`, `notes`, `domain_id`, `company_id`, `from`, `stops`, `to`, `created_at`, `updated_at`) VALUES (1,'978055f3-a6a5-42b9-a35c-4ae05ddab4f3','الكيت كات','Sed quia ut quos nihil aliquam est vel.',1,1,4,'[]',1,'2024-12-03 20:06:05','2024-12-03 20:06:05'),(2,'02c2c1a7-e8f5-40fe-9f89-10a63c9e142e','مدينة نصر','Fuga expedita maiores molestiae.',1,1,1,'[{\"destination_id\":3}]',4,'2024-12-03 20:06:05','2024-12-03 20:06:05'),(3,'edcd57d1-9797-46c1-847a-b30948a09b73','السيدة زينب','Sed beatae omnis debitis esse labore.',1,1,4,'[{\"destination_id\":4},{\"destination_id\":4}]',2,'2024-12-03 20:06:05','2024-12-03 20:06:05'),(4,'8a89d561-d1a2-4f83-97d8-4bd3f64daeaa','العاشر من رمضان','Ea aspernatur non natus amet.',1,1,2,'[{\"destination_id\":1},{\"destination_id\":1},{\"destination_id\":4}]',1,'2024-12-03 20:06:05','2024-12-03 20:06:05'),(5,'572b69e6-e9af-4771-8f03-dfe65de16dd2','الرحاب','Et et corrupti placeat ea.',1,1,1,'[{\"destination_id\":4},{\"destination_id\":1},{\"destination_id\":1},{\"destination_id\":3}]',2,'2024-12-03 20:06:05','2024-12-03 20:06:05'),(6,'114effb6-8fd7-496a-a095-f87961c7092d','العباسية','Nulla inventore voluptatem rerum.',4,2,13,'[]',14,'2024-12-03 20:06:05','2024-12-03 20:06:05'),(7,'ca2810ff-6521-43b7-99fe-dc389781acaa','المطار','Qui quisquam iusto non rem.',4,2,13,'[{\"destination_id\":15}]',14,'2024-12-03 20:06:05','2024-12-03 20:06:05'),(8,'705452b1-ca92-4ee5-8503-521fec3499be','الجيش','Sint eligendi qui omnis.',4,2,15,'[{\"destination_id\":16},{\"destination_id\":14}]',15,'2024-12-03 20:06:05','2024-12-03 20:06:05'),(9,'c760144d-f517-4405-9900-70421d994a2b','الكيت كات','Placeat corporis similique error.',4,2,14,'[{\"destination_id\":16},{\"destination_id\":15},{\"destination_id\":16}]',16,'2024-12-03 20:06:05','2024-12-03 20:06:05'),(10,'7f05d4e7-453a-4993-9d39-5735d854969c','قباء','Asperiores officia qui unde.',4,2,16,'[{\"destination_id\":13},{\"destination_id\":16},{\"destination_id\":14},{\"destination_id\":15}]',16,'2024-12-03 20:06:05','2024-12-03 20:06:05'),(11,'260f70ef-4cdd-4bea-9ccf-0e82eec3026e','حدائق المعادي','Unde voluptatem et id minima.',1,3,3,'[]',2,'2024-12-03 20:06:05','2024-12-03 20:06:05'),(12,'c5a56fa6-4d6f-4abb-bc7f-9b13a2c11561','المرج','Ut possimus eum et vitae accusantium.',1,3,1,'[{\"destination_id\":4}]',3,'2024-12-03 20:06:05','2024-12-03 20:06:05'),(13,'dfa0c271-1c75-4f6f-8c22-8f72d2b61991','عبده باشا','Ratione autem a reiciendis eius est.',1,3,2,'[{\"destination_id\":2},{\"destination_id\":3}]',3,'2024-12-03 20:06:05','2024-12-03 20:06:05'),(14,'9fc0f7d8-f2b0-48c4-a096-210a66f1a1ad','المنيل','Quia iure qui aut dolor.',1,3,1,'[{\"destination_id\":2},{\"destination_id\":4},{\"destination_id\":1}]',3,'2024-12-03 20:06:05','2024-12-03 20:06:05'),(15,'fb95b948-6eb8-4c35-9cc2-dab5704440ea','إمبابة','Ipsum error aperiam sunt ad.',1,3,1,'[{\"destination_id\":1},{\"destination_id\":3},{\"destination_id\":4},{\"destination_id\":2}]',1,'2024-12-03 20:06:05','2024-12-03 20:06:05');
/*!40000 ALTER TABLE `paths` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `permissions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=83 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (1,'view_activity','admin','2024-12-03 20:05:57','2024-12-03 20:05:57'),(2,'view_any_activity','admin','2024-12-03 20:05:57','2024-12-03 20:05:57'),(3,'create_activity','admin','2024-12-03 20:05:57','2024-12-03 20:05:57'),(4,'update_activity','admin','2024-12-03 20:05:57','2024-12-03 20:05:57'),(5,'delete_activity','admin','2024-12-03 20:05:57','2024-12-03 20:05:57'),(6,'delete_any_activity','admin','2024-12-03 20:05:57','2024-12-03 20:05:57'),(7,'view_admin','admin','2024-12-03 20:05:57','2024-12-03 20:05:57'),(8,'view_any_admin','admin','2024-12-03 20:05:57','2024-12-03 20:05:57'),(9,'create_admin','admin','2024-12-03 20:05:57','2024-12-03 20:05:57'),(10,'update_admin','admin','2024-12-03 20:05:57','2024-12-03 20:05:57'),(11,'delete_admin','admin','2024-12-03 20:05:57','2024-12-03 20:05:57'),(12,'delete_any_admin','admin','2024-12-03 20:05:57','2024-12-03 20:05:57'),(13,'view_bus','admin','2024-12-03 20:05:57','2024-12-03 20:05:57'),(14,'view_any_bus','admin','2024-12-03 20:05:57','2024-12-03 20:05:57'),(15,'create_bus','admin','2024-12-03 20:05:57','2024-12-03 20:05:57'),(16,'update_bus','admin','2024-12-03 20:05:57','2024-12-03 20:05:57'),(17,'delete_bus','admin','2024-12-03 20:05:57','2024-12-03 20:05:57'),(18,'delete_any_bus','admin','2024-12-03 20:05:57','2024-12-03 20:05:57'),(19,'view_company','admin','2024-12-03 20:05:58','2024-12-03 20:05:58'),(20,'view_any_company','admin','2024-12-03 20:05:58','2024-12-03 20:05:58'),(21,'create_company','admin','2024-12-03 20:05:58','2024-12-03 20:05:58'),(22,'update_company','admin','2024-12-03 20:05:58','2024-12-03 20:05:58'),(23,'delete_company','admin','2024-12-03 20:05:58','2024-12-03 20:05:58'),(24,'delete_any_company','admin','2024-12-03 20:05:58','2024-12-03 20:05:58'),(25,'view_destination','admin','2024-12-03 20:05:58','2024-12-03 20:05:58'),(26,'view_any_destination','admin','2024-12-03 20:05:58','2024-12-03 20:05:58'),(27,'create_destination','admin','2024-12-03 20:05:58','2024-12-03 20:05:58'),(28,'update_destination','admin','2024-12-03 20:05:58','2024-12-03 20:05:58'),(29,'delete_destination','admin','2024-12-03 20:05:58','2024-12-03 20:05:58'),(30,'delete_any_destination','admin','2024-12-03 20:05:58','2024-12-03 20:05:58'),(31,'view_domain','admin','2024-12-03 20:05:58','2024-12-03 20:05:58'),(32,'view_any_domain','admin','2024-12-03 20:05:58','2024-12-03 20:05:58'),(33,'create_domain','admin','2024-12-03 20:05:58','2024-12-03 20:05:58'),(34,'update_domain','admin','2024-12-03 20:05:58','2024-12-03 20:05:58'),(35,'delete_domain','admin','2024-12-03 20:05:58','2024-12-03 20:05:58'),(36,'delete_any_domain','admin','2024-12-03 20:05:58','2024-12-03 20:05:58'),(37,'view_driver','admin','2024-12-03 20:05:58','2024-12-03 20:05:58'),(38,'view_any_driver','admin','2024-12-03 20:05:58','2024-12-03 20:05:58'),(39,'create_driver','admin','2024-12-03 20:05:58','2024-12-03 20:05:58'),(40,'update_driver','admin','2024-12-03 20:05:58','2024-12-03 20:05:58'),(41,'delete_driver','admin','2024-12-03 20:05:58','2024-12-03 20:05:58'),(42,'delete_any_driver','admin','2024-12-03 20:05:58','2024-12-03 20:05:58'),(43,'view_path','admin','2024-12-03 20:05:58','2024-12-03 20:05:58'),(44,'view_any_path','admin','2024-12-03 20:05:58','2024-12-03 20:05:58'),(45,'create_path','admin','2024-12-03 20:05:58','2024-12-03 20:05:58'),(46,'update_path','admin','2024-12-03 20:05:58','2024-12-03 20:05:58'),(47,'delete_path','admin','2024-12-03 20:05:58','2024-12-03 20:05:58'),(48,'delete_any_path','admin','2024-12-03 20:05:58','2024-12-03 20:05:58'),(49,'view_role','admin','2024-12-03 20:05:58','2024-12-03 20:05:58'),(50,'view_any_role','admin','2024-12-03 20:05:58','2024-12-03 20:05:58'),(51,'create_role','admin','2024-12-03 20:05:58','2024-12-03 20:05:58'),(52,'update_role','admin','2024-12-03 20:05:58','2024-12-03 20:05:58'),(53,'delete_role','admin','2024-12-03 20:05:58','2024-12-03 20:05:58'),(54,'delete_any_role','admin','2024-12-03 20:05:58','2024-12-03 20:05:58'),(55,'view_trip','admin','2024-12-03 20:05:58','2024-12-03 20:05:58'),(56,'view_any_trip','admin','2024-12-03 20:05:58','2024-12-03 20:05:58'),(57,'create_trip','admin','2024-12-03 20:05:58','2024-12-03 20:05:58'),(58,'update_trip','admin','2024-12-03 20:05:58','2024-12-03 20:05:58'),(59,'delete_trip','admin','2024-12-03 20:05:58','2024-12-03 20:05:58'),(60,'delete_any_trip','admin','2024-12-03 20:05:58','2024-12-03 20:05:58'),(61,'page_CustomDashboard','admin','2024-12-03 20:05:58','2024-12-03 20:05:58'),(62,'page_HealthCheckResults','admin','2024-12-03 20:05:58','2024-12-03 20:05:58'),(63,'page_ManageMail','admin','2024-12-03 20:05:58','2024-12-03 20:05:58'),(64,'page_ViewEnv','admin','2024-12-03 20:05:58','2024-12-03 20:05:58'),(65,'page_BannerManagerPage','admin','2024-12-03 20:05:58','2024-12-03 20:05:58'),(66,'page_Themes','admin','2024-12-03 20:05:58','2024-12-03 20:05:58'),(67,'widget_OverlookWidget','admin','2024-12-03 20:05:58','2024-12-03 20:05:58'),(68,'widget_ServerStorageWidget','admin','2024-12-03 20:05:58','2024-12-03 20:05:58'),(69,'widget_PulseCache','admin','2024-12-03 20:05:58','2024-12-03 20:05:58'),(70,'widget_PulseExceptions','admin','2024-12-03 20:05:58','2024-12-03 20:05:58'),(71,'widget_PulseUsage','admin','2024-12-03 20:05:58','2024-12-03 20:05:58'),(72,'widget_PulseQueues','admin','2024-12-03 20:05:58','2024-12-03 20:05:58'),(73,'widget_PulseSlowQueries','admin','2024-12-03 20:05:58','2024-12-03 20:05:58'),(74,'widget_LatestAccessLogs','admin','2024-12-03 20:05:58','2024-12-03 20:05:58'),(75,'view_note','admin','2024-12-04 12:03:28','2024-12-04 12:03:28'),(76,'view_any_note','admin','2024-12-04 12:03:28','2024-12-04 12:03:28'),(77,'create_note','admin','2024-12-04 12:03:28','2024-12-04 12:03:28'),(78,'update_note','admin','2024-12-04 12:03:28','2024-12-04 12:03:28'),(79,'delete_note','admin','2024-12-04 12:03:28','2024-12-04 12:03:28'),(80,'delete_any_note','admin','2024-12-04 12:03:28','2024-12-04 12:03:28'),(81,'page_NotesGroups','admin','2024-12-04 12:03:28','2024-12-04 12:03:28'),(82,'page_NotesStatus','admin','2024-12-04 12:03:28','2024-12-04 12:03:28');
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pulse_aggregates`
--

DROP TABLE IF EXISTS `pulse_aggregates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pulse_aggregates` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `bucket` int(10) unsigned NOT NULL,
  `period` mediumint(8) unsigned NOT NULL,
  `type` varchar(255) NOT NULL,
  `key` mediumtext NOT NULL,
  `key_hash` binary(16) GENERATED ALWAYS AS (unhex(md5(`key`))) VIRTUAL,
  `aggregate` varchar(255) NOT NULL,
  `value` decimal(20,2) NOT NULL,
  `count` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pulse_aggregates_bucket_period_type_aggregate_key_hash_unique` (`bucket`,`period`,`type`,`aggregate`,`key_hash`),
  KEY `pulse_aggregates_period_bucket_index` (`period`,`bucket`),
  KEY `pulse_aggregates_type_index` (`type`),
  KEY `pulse_aggregates_period_type_aggregate_bucket_index` (`period`,`type`,`aggregate`,`bucket`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pulse_aggregates`
--

LOCK TABLES `pulse_aggregates` WRITE;
/*!40000 ALTER TABLE `pulse_aggregates` DISABLE KEYS */;
/*!40000 ALTER TABLE `pulse_aggregates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pulse_entries`
--

DROP TABLE IF EXISTS `pulse_entries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pulse_entries` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `timestamp` int(10) unsigned NOT NULL,
  `type` varchar(255) NOT NULL,
  `key` mediumtext NOT NULL,
  `key_hash` binary(16) GENERATED ALWAYS AS (unhex(md5(`key`))) VIRTUAL,
  `value` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pulse_entries_timestamp_index` (`timestamp`),
  KEY `pulse_entries_type_index` (`type`),
  KEY `pulse_entries_key_hash_index` (`key_hash`),
  KEY `pulse_entries_timestamp_type_key_hash_value_index` (`timestamp`,`type`,`key_hash`,`value`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pulse_entries`
--

LOCK TABLES `pulse_entries` WRITE;
/*!40000 ALTER TABLE `pulse_entries` DISABLE KEYS */;
/*!40000 ALTER TABLE `pulse_entries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pulse_values`
--

DROP TABLE IF EXISTS `pulse_values`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pulse_values` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `timestamp` int(10) unsigned NOT NULL,
  `type` varchar(255) NOT NULL,
  `key` mediumtext NOT NULL,
  `key_hash` binary(16) GENERATED ALWAYS AS (unhex(md5(`key`))) VIRTUAL,
  `value` mediumtext NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pulse_values_type_key_hash_unique` (`type`,`key_hash`),
  KEY `pulse_values_timestamp_index` (`timestamp`),
  KEY `pulse_values_type_index` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pulse_values`
--

LOCK TABLES `pulse_values` WRITE;
/*!40000 ALTER TABLE `pulse_values` DISABLE KEYS */;
/*!40000 ALTER TABLE `pulse_values` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role_has_permissions`
--

DROP TABLE IF EXISTS `role_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) unsigned NOT NULL,
  `role_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_has_permissions`
--

LOCK TABLES `role_has_permissions` WRITE;
/*!40000 ALTER TABLE `role_has_permissions` DISABLE KEYS */;
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES (1,1),(2,1),(3,1),(4,1),(5,1),(6,1),(7,1),(8,1),(9,1),(10,1),(11,1),(12,1),(13,1),(14,1),(15,1),(16,1),(17,1),(18,1),(19,1),(20,1),(21,1),(22,1),(23,1),(24,1),(25,1),(26,1),(27,1),(28,1),(29,1),(30,1),(31,1),(32,1),(33,1),(34,1),(35,1),(36,1),(37,1),(38,1),(39,1),(40,1),(41,1),(42,1),(43,1),(44,1),(45,1),(46,1),(47,1),(48,1),(49,1),(50,1),(51,1),(52,1),(53,1),(54,1),(55,1),(56,1),(57,1),(58,1),(59,1),(60,1),(61,1),(62,1),(63,1),(64,1),(65,1),(66,1),(67,1),(68,1),(69,1),(70,1),(71,1),(72,1),(73,1),(74,1),(75,1),(76,1),(77,1),(78,1),(79,1),(80,1),(81,1),(82,1);
/*!40000 ALTER TABLE `role_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (1,'super_admin','admin','2024-12-03 20:05:57','2024-12-03 20:05:57');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `user_type` varchar(255) DEFAULT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `user_type`, `last_activity`) VALUES ('C4FTJdRoid2iOLysl1JtzhsOEbc8WKeaSmcGhsnR',1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36','ZXlKcGRpSTZJa3QzYzJaRmMyOW9ZazR2VXk5cFdWQnVVakVyYkdjOVBTSXNJblpoYkhWbElqb2lWR0ZDUm1abGNXdzJabkZWVkdseWREZzFhVXRQTW01SFdtOTJjVXh5TW1aUE5tdEJOamN4VTBRMFNXNTBWekZHSzJKV2JsTlhkVzVESzFsNVkyeFNjeTh4ZG5scFlXcFRUblZQUVU1dVJsWnpWR2x1TURWMlJHRk1UbkZZVTJkSGJqUjRaVzgwY2sxclpIbzVSamhWU1dSNWVXeEdOazh4WnpGMkx6Sk1jV281UmtSUmVqSnJTSGh3VjFaMk4zTlFPV1oyT0V4bVpGZDNPV1ZSVGxOdVMyWlJWbGt2WTFSeVNtdHRSMUF6V21ka2QwZEJWMVpTTVVkSk9FSk9WM2xuVEhOdmRIb3JOR1poUzBKQ1pucE5WMHR0ZEc1cWRWWlFhemcxWlc1YWFWZGpXVTltYW1ac1RsUXpZbm8xU3pkalZUTnFNM2d5TlZCTU9IUnhPR2t2UkZGaFpqaDRaVTk0VWtNNWFYSmhNeXQ0Ym1WV2VHOUxPVmxKT1M5M1MwSmthVFY1UWtwNGEzbFRVMk5JV1hKT2QyUldWV3RzUVc5UFVsRnZSVVV6VFdwR2QwTXJSMmc0WVZaNGFqVkxhM1p1TjJkWllrZFRaR2RUVW5BMFpGZE1la2RPZWt0S05HdHJhbGhJUzNCNGF6VmFTRUkzUlVkV2Jtd3lURmxPY0RORVVEaDRZWGxZWVhrNGN6aFJVVzExUmxSWU1qQTNZVXB3TWpSRlQwb3hSVFk1VTI1cUx6SnZWMVpJTjBwUE4zQTNkWFI1ZGpCUGRrSmhTbTlLU25wV2NXNHpUMmh3ZEZwTU1DOXhlVzkwYjNOcFdHSnhPRk5MTVZJNU1qTkRSVEpRZEdaVGFXVnVaWGRKWVVKcFdIWTBVSEJ1ZFNzck9FMXJlbVZRTm5oVmNVUlZZM1o2WTFob2JHcENZMlJVWmpaRU5EQXhlV2RGUXpCa1kybGlVV0ZhSzB4T2FsZG1lblpwZERWTlBTSXNJbTFoWXlJNkltSTRPRGxqTW1GbVlqRTVNVEl4T1RabFpXUXpNekU0WldRNU5UZzJOR1ZsTXpnNE5EWmlNakE1WldVNE1EY3paR1ZtWTJJeVltRmpNRFF5WmpVNU16UWlMQ0owWVdjaU9pSWlmUT09',NULL,1733314304);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `settings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `group` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `locked` tinyint(1) NOT NULL DEFAULT 0,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`payload`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `settings_group_name_unique` (`group`,`name`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings`
--

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` (`id`, `group`, `name`, `locked`, `payload`, `created_at`, `updated_at`) VALUES (1,'mail','from_address',0,'\"eslam@gmail.com\"','2024-12-03 20:05:56','2024-12-03 20:05:56'),(2,'mail','from_name',0,'\"eslam\"','2024-12-03 20:05:56','2024-12-03 20:05:56'),(3,'mail','driver',0,'\"log\"','2024-12-03 20:05:56','2024-12-03 20:05:56'),(4,'mail','host',0,'null','2024-12-03 20:05:56','2024-12-03 20:05:56'),(5,'mail','port',0,'587','2024-12-03 20:05:56','2024-12-03 20:05:56'),(6,'mail','encryption',0,'\"tls\"','2024-12-03 20:05:56','2024-12-03 20:05:56'),(7,'mail','username',0,'null','2024-12-03 20:05:56','2024-12-03 20:05:56'),(8,'mail','password',0,'null','2024-12-03 20:05:56','2024-12-03 20:05:56'),(9,'mail','timeout',0,'null','2024-12-03 20:05:56','2024-12-03 20:05:56'),(10,'mail','local_domain',0,'null','2024-12-03 20:05:56','2024-12-03 20:05:56'),(11,'sites','site_name',0,'\"3x1\"','2024-12-03 20:05:57','2024-12-03 20:05:57'),(12,'sites','site_description',0,'\"Creative Solutions\"','2024-12-03 20:05:57','2024-12-03 20:05:57'),(13,'sites','site_keywords',0,'\"Graphics, Marketing, Programming\"','2024-12-03 20:05:57','2024-12-03 20:05:57'),(14,'sites','site_profile',0,'\"\"','2024-12-03 20:05:57','2024-12-03 20:05:57'),(15,'sites','site_logo',0,'\"\"','2024-12-03 20:05:57','2024-12-03 20:05:57'),(16,'sites','site_author',0,'\"Fady Mondy\"','2024-12-03 20:05:57','2024-12-03 20:05:57'),(17,'sites','site_address',0,'\"Cairo, Egypt\"','2024-12-03 20:05:57','2024-12-03 20:05:57'),(18,'sites','site_email',0,'\"info@3x1.io\"','2024-12-03 20:05:57','2024-12-03 20:05:57'),(19,'sites','site_phone',0,'\"+201207860084\"','2024-12-03 20:05:57','2024-12-03 20:05:57'),(20,'sites','site_phone_code',0,'\"+2\"','2024-12-03 20:05:57','2024-12-03 20:05:57'),(21,'sites','site_location',0,'\"Egypt\"','2024-12-03 20:05:57','2024-12-03 20:05:57'),(22,'sites','site_currency',0,'\"EGP\"','2024-12-03 20:05:57','2024-12-03 20:05:57'),(23,'sites','site_language',0,'\"English\"','2024-12-03 20:05:57','2024-12-03 20:05:57'),(24,'sites','site_social',0,'[]','2024-12-03 20:05:57','2024-12-03 20:05:57'),(25,'pwa','pwa_app_name',0,'\"TomatoPHP\"','2024-12-03 20:05:57','2024-12-03 20:05:57'),(26,'pwa','pwa_short_name',0,'\"Tomato\"','2024-12-03 20:05:57','2024-12-03 20:05:57'),(27,'pwa','pwa_start_url',0,'\"\\/\"','2024-12-03 20:05:57','2024-12-03 20:05:57'),(28,'pwa','pwa_background_color',0,'\"#ffffff\"','2024-12-03 20:05:57','2024-12-03 20:05:57'),(29,'pwa','pwa_theme_color',0,'\"#000000\"','2024-12-03 20:05:57','2024-12-03 20:05:57'),(30,'pwa','pwa_display',0,'\"standalone\"','2024-12-03 20:05:57','2024-12-03 20:05:57'),(31,'pwa','pwa_orientation',0,'\"any\"','2024-12-03 20:05:57','2024-12-03 20:05:57'),(32,'pwa','pwa_status_bar',0,'\"#000000\"','2024-12-03 20:05:57','2024-12-03 20:05:57'),(33,'pwa','pwa_icons_72x72',0,'\"\"','2024-12-03 20:05:57','2024-12-03 20:05:57'),(34,'pwa','pwa_icons_96x96',0,'\"\"','2024-12-03 20:05:57','2024-12-03 20:05:57'),(35,'pwa','pwa_icons_128x128',0,'\"\"','2024-12-03 20:05:57','2024-12-03 20:05:57'),(36,'pwa','pwa_icons_144x144',0,'\"\"','2024-12-03 20:05:57','2024-12-03 20:05:57'),(37,'pwa','pwa_icons_152x152',0,'\"\"','2024-12-03 20:05:57','2024-12-03 20:05:57'),(38,'pwa','pwa_icons_192x192',0,'\"\"','2024-12-03 20:05:57','2024-12-03 20:05:57'),(39,'pwa','pwa_icons_384x384',0,'\"\"','2024-12-03 20:05:57','2024-12-03 20:05:57'),(40,'pwa','pwa_icons_512x512',0,'\"\"','2024-12-03 20:05:57','2024-12-03 20:05:57'),(41,'pwa','pwa_splash_640x1136',0,'\"\"','2024-12-03 20:05:57','2024-12-03 20:05:57'),(42,'pwa','pwa_splash_750x1334',0,'\"\"','2024-12-03 20:05:57','2024-12-03 20:05:57'),(43,'pwa','pwa_splash_828x1792',0,'\"\"','2024-12-03 20:05:57','2024-12-03 20:05:57'),(44,'pwa','pwa_splash_1125x2436',0,'\"\"','2024-12-03 20:05:57','2024-12-03 20:05:57'),(45,'pwa','pwa_splash_1242x2208',0,'\"\"','2024-12-03 20:05:57','2024-12-03 20:05:57'),(46,'pwa','pwa_splash_1242x2688',0,'\"\"','2024-12-03 20:05:57','2024-12-03 20:05:57'),(47,'pwa','pwa_splash_1536x2048',0,'\"\"','2024-12-03 20:05:57','2024-12-03 20:05:57'),(48,'pwa','pwa_splash_1668x2224',0,'\"\"','2024-12-03 20:05:57','2024-12-03 20:05:57'),(49,'pwa','pwa_splash_1668x2388',0,'\"\"','2024-12-03 20:05:57','2024-12-03 20:05:57'),(50,'pwa','pwa_splash_2048x2732',0,'\"\"','2024-12-03 20:05:57','2024-12-03 20:05:57'),(51,'pwa','pwa_shortcuts',0,'[]','2024-12-03 20:05:57','2024-12-03 20:05:57');
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trips`
--

DROP TABLE IF EXISTS `trips`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `trips` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `company_id` bigint(20) unsigned DEFAULT NULL,
  `driver_id` bigint(20) unsigned DEFAULT NULL,
  `path_id` bigint(20) unsigned DEFAULT NULL,
  `status` enum('scheduled','in_progress','completed') NOT NULL DEFAULT 'scheduled',
  `start_at_day` timestamp NULL DEFAULT NULL,
  `start_at_time` time DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `trips_uuid_unique` (`uuid`),
  KEY `trips_company_id_foreign` (`company_id`),
  KEY `trips_driver_id_foreign` (`driver_id`),
  KEY `trips_path_id_foreign` (`path_id`),
  CONSTRAINT `trips_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  CONSTRAINT `trips_driver_id_foreign` FOREIGN KEY (`driver_id`) REFERENCES `drivers` (`id`) ON DELETE CASCADE,
  CONSTRAINT `trips_path_id_foreign` FOREIGN KEY (`path_id`) REFERENCES `paths` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `trips`
--

LOCK TABLES `trips` WRITE;
/*!40000 ALTER TABLE `trips` DISABLE KEYS */;
INSERT INTO `trips` (`id`, `uuid`, `notes`, `company_id`, `driver_id`, `path_id`, `status`, `start_at_day`, `start_at_time`, `created_at`, `updated_at`) VALUES (1,'89e49ec7-e03e-42b7-986e-0201aa284f10','Trip #1 for path: الكيت كات',1,2,1,'scheduled','2024-12-30 20:06:05','09:39:00','2024-12-03 20:06:05','2024-12-03 20:06:05'),(2,'ba40c708-567e-42da-8f77-24e1dd4a5ae9','Trip #2 for path: الكيت كات',1,2,1,'scheduled','2024-12-12 20:06:05','11:32:00','2024-12-03 20:06:05','2024-12-03 20:06:05'),(3,'58667594-702f-4cd8-930b-b04251977505','Trip #1 for path: مدينة نصر',1,2,2,'scheduled','2024-12-04 20:06:05','09:32:00','2024-12-03 20:06:05','2024-12-03 20:06:05'),(4,'2dd53b3a-d7ce-4382-9ccd-06b4a881974c','Trip #2 for path: مدينة نصر',1,1,2,'scheduled','2024-12-09 20:06:05','13:09:00','2024-12-03 20:06:05','2024-12-03 20:06:05'),(5,'4dcc6096-7984-4b8c-ae75-c9c7c60e9f44','Trip #1 for path: السيدة زينب',1,2,3,'scheduled','2024-12-26 20:06:05','06:25:00','2024-12-03 20:06:05','2024-12-03 20:06:05'),(6,'3a5df8fe-3837-43bb-a509-2c262520ae6e','Trip #2 for path: السيدة زينب',1,1,3,'scheduled','2024-12-08 20:06:05','07:10:00','2024-12-03 20:06:05','2024-12-03 20:06:05'),(7,'49f2ebae-7d40-48be-9e73-b42f4871ee01','Trip #1 for path: العاشر من رمضان',1,2,4,'scheduled','2024-12-08 20:06:05','16:39:00','2024-12-03 20:06:05','2024-12-03 20:06:05'),(8,'e6109c17-9b63-4643-96f4-ba887408609a','Trip #2 for path: العاشر من رمضان',1,2,4,'scheduled','2024-12-22 20:06:05','06:34:00','2024-12-03 20:06:05','2024-12-03 20:06:05'),(9,'01eef95b-7807-4c6f-b2df-28ce0db7486e','Trip #1 for path: الرحاب',1,2,5,'scheduled','2024-12-27 20:06:05','09:51:00','2024-12-03 20:06:05','2024-12-03 20:06:05'),(10,'6191a290-ae1d-431c-bda8-4a381ffa0081','Trip #2 for path: الرحاب',1,1,5,'scheduled','2024-12-22 20:06:05','15:15:00','2024-12-03 20:06:05','2024-12-03 20:06:05'),(11,'8342b6b6-9e7c-4a38-a64a-c19bf050310c','Trip #1 for path: العباسية',2,4,6,'scheduled','2024-12-22 20:06:05','20:03:00','2024-12-03 20:06:05','2024-12-03 20:06:05'),(12,'a9c88bb8-35b3-45a2-a812-dbe460732c5b','Trip #2 for path: العباسية',2,3,6,'scheduled','2024-12-13 20:06:05','19:55:00','2024-12-03 20:06:05','2024-12-03 20:06:05'),(13,'b36685d2-d30d-404b-ac3f-0934eb48a4b1','Trip #1 for path: المطار',2,3,7,'scheduled','2024-12-18 20:06:05','20:08:00','2024-12-03 20:06:05','2024-12-03 20:06:05'),(14,'4b066585-72b8-4483-bf9a-878cfdf3c3f2','Trip #2 for path: المطار',2,3,7,'scheduled','2024-12-16 20:06:05','09:33:00','2024-12-03 20:06:05','2024-12-03 20:06:05'),(15,'57765821-901a-487d-b102-3593e42eabf6','Trip #1 for path: الجيش',2,4,8,'scheduled','2024-12-18 20:06:05','15:47:00','2024-12-03 20:06:05','2024-12-03 20:06:05'),(16,'ffc4eb59-1c3d-4384-bc21-2fa49eed2df0','Trip #2 for path: الجيش',2,3,8,'scheduled','2024-12-25 20:06:05','10:21:00','2024-12-03 20:06:05','2024-12-03 20:06:05'),(17,'ef182269-c687-455f-a32e-3bc8c3d471d7','Trip #1 for path: الكيت كات',2,4,9,'scheduled','2024-12-08 20:06:05','10:16:00','2024-12-03 20:06:05','2024-12-03 20:06:05'),(18,'8f32d04f-3ba7-46ca-ace7-2c44052f0adb','Trip #2 for path: الكيت كات',2,4,9,'scheduled','2024-12-30 20:06:05','21:55:00','2024-12-03 20:06:05','2024-12-03 20:06:05'),(19,'66b1e0fc-8f10-4956-b579-a6103ea2e9e6','Trip #1 for path: قباء',2,3,10,'scheduled','2024-12-28 20:06:05','08:39:00','2024-12-03 20:06:05','2024-12-03 20:06:05'),(20,'51c26cb4-2ac6-490b-a79b-d15959264c46','Trip #2 for path: قباء',2,3,10,'scheduled','2024-12-19 20:06:05','22:39:00','2024-12-03 20:06:05','2024-12-03 20:06:05'),(21,'5cf4e1ee-5d7c-45f0-a350-7a008b4d1cc0','Trip #1 for path: حدائق المعادي',3,5,11,'scheduled','2024-12-27 20:06:05','08:55:00','2024-12-03 20:06:05','2024-12-03 20:06:05'),(22,'46f67b94-fbd9-4eaa-bc4e-b97aa90cb74b','Trip #2 for path: حدائق المعادي',3,5,11,'scheduled','2024-12-05 20:06:05','09:27:00','2024-12-03 20:06:05','2024-12-03 20:06:05'),(23,'6da5a1a5-1041-4083-a35a-bcc6ef22019b','Trip #1 for path: المرج',3,6,12,'scheduled','2024-12-06 20:06:05','10:15:00','2024-12-03 20:06:05','2024-12-03 20:06:05'),(24,'7004dcdc-6919-4a98-b9b0-08ef836039cc','Trip #2 for path: المرج',3,6,12,'scheduled','2024-12-19 20:06:05','14:30:00','2024-12-03 20:06:05','2024-12-03 20:06:05'),(25,'4c8d5307-979f-48b3-90d9-7fe05ce69379','Trip #1 for path: عبده باشا',3,5,13,'scheduled','2024-12-31 20:06:05','16:28:00','2024-12-03 20:06:05','2024-12-03 20:06:05'),(26,'a9faab5d-f65b-441d-aefb-597d7d09d3f3','Trip #2 for path: عبده باشا',3,6,13,'scheduled','2024-12-28 20:06:05','06:12:00','2024-12-03 20:06:05','2024-12-03 20:06:05'),(27,'0c622c85-e8d7-44c6-8ee3-6aa0770666af','Trip #1 for path: المنيل',3,5,14,'scheduled','2024-12-10 20:06:05','22:45:00','2024-12-03 20:06:05','2024-12-03 20:06:05'),(28,'ce7ff64e-10dd-409b-9f6a-dd3246fa967e','Trip #2 for path: المنيل',3,5,14,'scheduled','2024-12-30 20:06:05','22:40:00','2024-12-03 20:06:05','2024-12-03 20:06:05'),(29,'71bdf4cd-b056-497f-9131-829bf5f89234','Trip #1 for path: إمبابة',3,6,15,'scheduled','2024-12-06 20:06:05','08:46:00','2024-12-03 20:06:05','2024-12-03 20:06:05'),(30,'17dff817-5e10-4a62-abb0-0fbb633169f7','Trip #2 for path: إمبابة',3,5,15,'scheduled','2024-12-31 20:06:05','06:21:00','2024-12-03 20:06:05','2024-12-03 20:06:05');
/*!40000 ALTER TABLE `trips` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `typables`
--

DROP TABLE IF EXISTS `typables`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `typables` (
  `type_id` bigint(20) unsigned NOT NULL,
  `typables_id` bigint(20) unsigned NOT NULL,
  `typables_type` varchar(255) NOT NULL,
  KEY `typables_type_id_foreign` (`type_id`),
  CONSTRAINT `typables_type_id_foreign` FOREIGN KEY (`type_id`) REFERENCES `types` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `typables`
--

LOCK TABLES `typables` WRITE;
/*!40000 ALTER TABLE `typables` DISABLE KEYS */;
/*!40000 ALTER TABLE `typables` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `types`
--

DROP TABLE IF EXISTS `types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `types` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `order` int(11) NOT NULL DEFAULT 0,
  `parent_id` bigint(20) unsigned DEFAULT NULL,
  `model_type` varchar(255) DEFAULT NULL,
  `model_id` bigint(20) unsigned DEFAULT NULL,
  `for` varchar(255) DEFAULT 'posts',
  `type` varchar(255) DEFAULT 'category',
  `name` varchar(255) NOT NULL,
  `key` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `color` varchar(255) DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `is_activated` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `types_parent_id_foreign` (`parent_id`),
  CONSTRAINT `types_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `types` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `types`
--

LOCK TABLES `types` WRITE;
/*!40000 ALTER TABLE `types` DISABLE KEYS */;
/*!40000 ALTER TABLE `types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `types_metas`
--

DROP TABLE IF EXISTS `types_metas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `types_metas` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `model_id` bigint(20) unsigned DEFAULT NULL,
  `model_type` varchar(255) DEFAULT NULL,
  `type_id` bigint(20) unsigned NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`value`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `types_metas_type_id_foreign` (`type_id`),
  KEY `types_metas_key_index` (`key`),
  CONSTRAINT `types_metas_type_id_foreign` FOREIGN KEY (`type_id`) REFERENCES `types` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `types_metas`
--

LOCK TABLES `types_metas` WRITE;
/*!40000 ALTER TABLE `types_metas` DISABLE KEYS */;
/*!40000 ALTER TABLE `types_metas` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-12-04 14:11:47
