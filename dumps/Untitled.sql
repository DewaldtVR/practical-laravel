CREATE DATABASE  IF NOT EXISTS `creditcardcurator` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `creditcardcurator`;
-- MySQL dump 10.13  Distrib 8.0.17, for macos10.14 (x86_64)
--
-- Host: 127.0.0.1    Database: creditcardcurator
-- ------------------------------------------------------
-- Server version	8.0.17

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `airline`
--

DROP TABLE IF EXISTS `airline`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `airline` (
  `airlineid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `airlinename` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`airlineid`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `airline`
--

LOCK TABLES `airline` WRITE;
/*!40000 ALTER TABLE `airline` DISABLE KEYS */;
INSERT INTO `airline` VALUES (1,'Delta SkyMiles'),(2,'American AAdvantage'),(3,'United MilagePlus'),(4,'Alaska Mileage Plan'),(5,'Singapore KrisFlyer'),(6,'Virgin Atlantic Flying Club'),(7,'Air France KLM - Flying Blue'),(8,'Avianca LifeMiles'),(9,'British Airways Avios'),(10,'Cathay Pacific Asia Miles'),(11,'Air Canada Aeroplan'),(12,'Any Airline');
/*!40000 ALTER TABLE `airline` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `airline_city`
--

DROP TABLE IF EXISTS `airline_city`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `airline_city` (
  `airlineid` int(10) unsigned NOT NULL,
  `cityid` int(10) unsigned NOT NULL,
  PRIMARY KEY (`airlineid`,`cityid`),
  KEY `fk_airline_city_airline1_idx` (`airlineid`),
  KEY `fk_airline_city_city1_idx` (`cityid`),
  CONSTRAINT `fk_airline_city_airline1_idx` FOREIGN KEY (`airlineid`) REFERENCES `airline` (`airlineid`),
  CONSTRAINT `fk_airline_city_city1_idx` FOREIGN KEY (`cityid`) REFERENCES `city` (`cityid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `airline_city`
--

LOCK TABLES `airline_city` WRITE;
/*!40000 ALTER TABLE `airline_city` DISABLE KEYS */;
/*!40000 ALTER TABLE `airline_city` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bank`
--

DROP TABLE IF EXISTS `bank`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bank` (
  `bankid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `bankname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bankcode` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logofileid` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`bankid`),
  KEY `fk_bank_file1_idx` (`logofileid`),
  CONSTRAINT `fk_bank_file1_idx` FOREIGN KEY (`logofileid`) REFERENCES `file` (`fileid`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bank`
--

LOCK TABLES `bank` WRITE;
/*!40000 ALTER TABLE `bank` DISABLE KEYS */;
INSERT INTO `bank` VALUES (1,'Chase',NULL,50),(2,'Bank of America',NULL,NULL),(3,'Wells Fargo',NULL,54),(5,'Citi Bank',NULL,55),(6,'US Bank',NULL,53),(7,'Discover Bank',NULL,52),(8,'Barclays Bank',NULL,48),(9,'Capital One',NULL,49);
/*!40000 ALTER TABLE `bank` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `city`
--

DROP TABLE IF EXISTS `city`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `city` (
  `cityid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cityname` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `countryid` int(10) unsigned NOT NULL,
  `travel` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`cityid`),
  KEY `fk_city_country1_idx` (`countryid`),
  CONSTRAINT `fk_city_country1_idx` FOREIGN KEY (`countryid`) REFERENCES `country` (`countryid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `city`
--

LOCK TABLES `city` WRITE;
/*!40000 ALTER TABLE `city` DISABLE KEYS */;
/*!40000 ALTER TABLE `city` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `component`
--

DROP TABLE IF EXISTS `component`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `component` (
  `componentid` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `description` varchar(150) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `done` tinyint(4) unsigned DEFAULT '0',
  `fileid` int(11) DEFAULT NULL,
  `number` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `enum` enum('basic','advanced') COLLATE utf8mb4_general_ci DEFAULT 'basic',
  `componenttypeid` int(10) unsigned DEFAULT NULL,
  `html` longtext COLLATE utf8mb4_general_ci,
  PRIMARY KEY (`componentid`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `component`
--

LOCK TABLES `component` WRITE;
/*!40000 ALTER TABLE `component` DISABLE KEYS */;
INSERT INTO `component` VALUES (12,'Rocket Framework','Laravel & VueJS',1,103,NULL,'2019-11-09 16:18:40','2019-11-09 16:18:40',NULL,'basic',2,'<h2><strong>Rocket Framework 1.0</strong></h2><p><br></p><p>This framework will ensure that systems get built in less time, making profits much higher that using custom built software solutions for the following reasons:</p><p><br></p><ul><li>Easy to use.</li><li>Easy to learn.</li><li>Great documentation.</li><li>Flexible components.</li></ul><p><br></p><p><span style=\"color: rgb(230, 0, 0);\">Make the right choice and focus on solutions, not development!</span></p><p><br></p>');
/*!40000 ALTER TABLE `component` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `componenttype`
--

DROP TABLE IF EXISTS `componenttype`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `componenttype` (
  `componenttypeid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(150) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`componenttypeid`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `componenttype`
--

LOCK TABLES `componenttype` WRITE;
/*!40000 ALTER TABLE `componenttype` DISABLE KEYS */;
INSERT INTO `componenttype` VALUES (1,'One'),(2,'Two'),(3,'Three'),(8,'Pietie se component');
/*!40000 ALTER TABLE `componenttype` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `country`
--

DROP TABLE IF EXISTS `country`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `country` (
  `countryid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `countryname` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logofileid` int(10) unsigned DEFAULT NULL,
  `regionid` int(10) unsigned NOT NULL,
  PRIMARY KEY (`countryid`),
  KEY `fk_country_file1_idx` (`logofileid`),
  KEY `fk_region_country1_idx` (`regionid`),
  CONSTRAINT `fk_country_file1_idx` FOREIGN KEY (`logofileid`) REFERENCES `file` (`fileid`),
  CONSTRAINT `fk_region_country1` FOREIGN KEY (`regionid`) REFERENCES `region` (`regionid`)
) ENGINE=InnoDB AUTO_INCREMENT=759 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `country`
--

LOCK TABLES `country` WRITE;
/*!40000 ALTER TABLE `country` DISABLE KEYS */;
INSERT INTO `country` VALUES (512,'Afghanistan',NULL,36),(513,'Åland Islands',NULL,37),(514,'Albania',NULL,38),(515,'Algeria',NULL,39),(516,'American Samoa',NULL,40),(517,'Andorra',NULL,38),(518,'Angola',NULL,41),(519,'Anguilla',NULL,42),(520,'Antigua and Barbuda',NULL,42),(521,'Argentina',NULL,43),(522,'Armenia',NULL,44),(523,'Aruba',NULL,42),(524,'Australia',NULL,45),(525,'Austria',NULL,46),(526,'Azerbaijan',NULL,44),(527,'Bahamas',NULL,42),(528,'Bahrain',NULL,44),(529,'Bangladesh',NULL,36),(530,'Barbados',NULL,42),(531,'Belarus',NULL,47),(532,'Belgium',NULL,46),(533,'Belize',NULL,48),(534,'Benin',NULL,49),(535,'Bermuda',NULL,50),(536,'Bhutan',NULL,36),(537,'Bolivia (Plurinational State of)',NULL,43),(538,'Bonaire, Sint Eustatius and Saba',NULL,42),(539,'Bosnia and Herzegovina',NULL,38),(540,'Botswana',NULL,51),(541,'Brazil',NULL,43),(542,'British Indian Ocean Territory',NULL,52),(543,'United States Minor Outlying Islands',NULL,50),(544,'Virgin Islands (British)',NULL,42),(545,'Virgin Islands (U.S.)',NULL,42),(546,'Brunei Darussalam',NULL,53),(547,'Bulgaria',NULL,47),(548,'Burkina Faso',NULL,49),(549,'Burundi',NULL,52),(550,'Cambodia',NULL,53),(551,'Cameroon',NULL,41),(552,'Canada',NULL,50),(553,'Cabo Verde',NULL,49),(554,'Cayman Islands',NULL,42),(555,'Central African Republic',NULL,41),(556,'Chad',NULL,41),(557,'Chile',NULL,43),(558,'China',NULL,54),(559,'Christmas Island',NULL,45),(560,'Cocos (Keeling) Islands',NULL,45),(561,'Colombia',NULL,43),(562,'Comoros',NULL,52),(563,'Congo',NULL,41),(564,'Congo (Democratic Republic of the)',NULL,41),(565,'Cook Islands',NULL,40),(566,'Costa Rica',NULL,48),(567,'Croatia',NULL,38),(568,'Cuba',NULL,42),(569,'Curaçao',NULL,42),(570,'Cyprus',NULL,38),(571,'Czech Republic',NULL,47),(572,'Denmark',NULL,37),(573,'Djibouti',NULL,52),(574,'Dominica',NULL,42),(575,'Dominican Republic',NULL,42),(576,'Ecuador',NULL,43),(577,'Egypt',NULL,39),(578,'El Salvador',NULL,48),(579,'Equatorial Guinea',NULL,41),(580,'Eritrea',NULL,52),(581,'Estonia',NULL,37),(582,'Ethiopia',NULL,52),(583,'Falkland Islands (Malvinas)',NULL,43),(584,'Faroe Islands',NULL,37),(585,'Fiji',NULL,55),(586,'Finland',NULL,37),(587,'France',NULL,46),(588,'French Guiana',NULL,43),(589,'French Polynesia',NULL,40),(590,'French Southern Territories',NULL,51),(591,'Gabon',NULL,41),(592,'Gambia',NULL,49),(593,'Georgia',NULL,44),(594,'Germany',NULL,46),(595,'Ghana',NULL,49),(596,'Gibraltar',NULL,38),(597,'Greece',NULL,38),(598,'Greenland',NULL,50),(599,'Grenada',NULL,42),(600,'Guadeloupe',NULL,42),(601,'Guam',NULL,56),(602,'Guatemala',NULL,48),(603,'Guernsey',NULL,37),(604,'Guinea',NULL,49),(605,'Guinea-Bissau',NULL,49),(606,'Guyana',NULL,43),(607,'Haiti',NULL,42),(608,'Holy See',NULL,38),(609,'Honduras',NULL,48),(610,'Hong Kong',NULL,54),(611,'Hungary',NULL,47),(612,'Iceland',NULL,37),(613,'India',NULL,36),(614,'Indonesia',NULL,53),(615,'Côte d\'Ivoire',NULL,49),(616,'Iran (Islamic Republic of)',NULL,36),(617,'Iraq',NULL,44),(618,'Ireland',NULL,37),(619,'Isle of Man',NULL,37),(620,'Israel',NULL,44),(621,'Italy',NULL,38),(622,'Jamaica',NULL,42),(623,'Japan',NULL,54),(624,'Jersey',NULL,37),(625,'Jordan',NULL,44),(626,'Kazakhstan',NULL,57),(627,'Kenya',NULL,52),(628,'Kiribati',NULL,56),(629,'Kuwait',NULL,44),(630,'Kyrgyzstan',NULL,57),(631,'Lao People\'s Democratic Republic',NULL,53),(632,'Latvia',NULL,37),(633,'Lebanon',NULL,44),(634,'Lesotho',NULL,51),(635,'Liberia',NULL,49),(636,'Libya',NULL,39),(637,'Liechtenstein',NULL,46),(638,'Lithuania',NULL,37),(639,'Luxembourg',NULL,46),(640,'Macao',NULL,54),(641,'Macedonia (the former Yugoslav Republic of)',NULL,38),(642,'Madagascar',NULL,52),(643,'Malawi',NULL,52),(644,'Malaysia',NULL,53),(645,'Maldives',NULL,36),(646,'Mali',NULL,49),(647,'Malta',NULL,38),(648,'Marshall Islands',NULL,56),(649,'Martinique',NULL,42),(650,'Mauritania',NULL,49),(651,'Mauritius',NULL,52),(652,'Mayotte',NULL,52),(653,'Mexico',NULL,48),(654,'Micronesia (Federated States of)',NULL,56),(655,'Moldova (Republic of)',NULL,47),(656,'Monaco',NULL,46),(657,'Mongolia',NULL,54),(658,'Montenegro',NULL,38),(659,'Montserrat',NULL,42),(660,'Morocco',NULL,39),(661,'Mozambique',NULL,52),(662,'Myanmar',NULL,53),(663,'Namibia',NULL,51),(664,'Nauru',NULL,56),(665,'Nepal',NULL,36),(666,'Netherlands',NULL,46),(667,'New Caledonia',NULL,55),(668,'New Zealand',NULL,45),(669,'Nicaragua',NULL,48),(670,'Niger',NULL,49),(671,'Nigeria',NULL,49),(672,'Niue',NULL,40),(673,'Norfolk Island',NULL,45),(674,'Korea (Democratic People\'s Republic of)',NULL,54),(675,'Northern Mariana Islands',NULL,56),(676,'Norway',NULL,37),(677,'Oman',NULL,44),(678,'Pakistan',NULL,36),(679,'Palau',NULL,56),(680,'Palestine, State of',NULL,44),(681,'Panama',NULL,48),(682,'Papua New Guinea',NULL,55),(683,'Paraguay',NULL,43),(684,'Peru',NULL,43),(685,'Philippines',NULL,53),(686,'Pitcairn',NULL,40),(687,'Poland',NULL,47),(688,'Portugal',NULL,38),(689,'Puerto Rico',NULL,42),(690,'Qatar',NULL,44),(691,'Republic of Kosovo',NULL,47),(692,'Réunion',NULL,52),(693,'Romania',NULL,47),(694,'Russian Federation',NULL,47),(695,'Rwanda',NULL,52),(696,'Saint Barthélemy',NULL,42),(697,'Saint Helena, Ascension and Tristan da Cunha',NULL,49),(698,'Saint Kitts and Nevis',NULL,42),(699,'Saint Lucia',NULL,42),(700,'Saint Martin (French part)',NULL,42),(701,'Saint Pierre and Miquelon',NULL,50),(702,'Saint Vincent and the Grenadines',NULL,42),(703,'Samoa',NULL,40),(704,'San Marino',NULL,38),(705,'Sao Tome and Principe',NULL,41),(706,'Saudi Arabia',NULL,44),(707,'Senegal',NULL,49),(708,'Serbia',NULL,38),(709,'Seychelles',NULL,52),(710,'Sierra Leone',NULL,49),(711,'Singapore',NULL,53),(712,'Sint Maarten (Dutch part)',NULL,42),(713,'Slovakia',NULL,47),(714,'Slovenia',NULL,38),(715,'Solomon Islands',NULL,55),(716,'Somalia',NULL,52),(717,'South Africa',NULL,51),(718,'South Georgia and the South Sandwich Islands',NULL,43),(719,'Korea (Republic of)',NULL,54),(720,'South Sudan',NULL,41),(721,'Spain',NULL,38),(722,'Sri Lanka',NULL,36),(723,'Sudan',NULL,39),(724,'Suriname',NULL,43),(725,'Svalbard and Jan Mayen',NULL,37),(726,'Swaziland',NULL,51),(727,'Sweden',NULL,37),(728,'Switzerland',NULL,46),(729,'Syrian Arab Republic',NULL,44),(730,'Taiwan',NULL,54),(731,'Tajikistan',NULL,57),(732,'Tanzania, United Republic of',NULL,52),(733,'Thailand',NULL,53),(734,'Timor-Leste',NULL,53),(735,'Togo',NULL,49),(736,'Tokelau',NULL,40),(737,'Tonga',NULL,40),(738,'Trinidad and Tobago',NULL,42),(739,'Tunisia',NULL,39),(740,'Turkey',NULL,44),(741,'Turkmenistan',NULL,57),(742,'Turks and Caicos Islands',NULL,42),(743,'Tuvalu',NULL,40),(744,'Uganda',NULL,52),(745,'Ukraine',NULL,47),(746,'United Arab Emirates',NULL,44),(747,'United Kingdom of Great Britain and Northern Ireland',NULL,37),(748,'United States of America',NULL,50),(749,'Uruguay',NULL,43),(750,'Uzbekistan',NULL,57),(751,'Vanuatu',NULL,55),(752,'Venezuela (Bolivarian Republic of)',NULL,43),(753,'Viet Nam',NULL,53),(754,'Wallis and Futuna',NULL,40),(755,'Western Sahara',NULL,39),(756,'Yemen',NULL,44),(757,'Zambia',NULL,52),(758,'Zimbabwe',NULL,52);
/*!40000 ALTER TABLE `country` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `creditcard`
--

DROP TABLE IF EXISTS `creditcard`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `creditcard` (
  `creditcardid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `creditcardname` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `businesscard` tinyint(4) DEFAULT '0',
  `annualfeewaived` tinyint(4) DEFAULT '0',
  `annualfee` decimal(6,2) DEFAULT '0.00',
  `bonus` int(11) DEFAULT '0',
  `cashperks` decimal(6,2) DEFAULT '0.00',
  `dayspendlimit` int(11) DEFAULT '0',
  `minspend` decimal(6,2) DEFAULT '0.00',
  `cashbonus` decimal(6,2) DEFAULT NULL,
  `signupbonus` decimal(6,2) DEFAULT NULL,
  `coverimagefileid` int(10) unsigned NOT NULL,
  `bankid` int(10) unsigned NOT NULL,
  `networkid` int(10) unsigned NOT NULL,
  PRIMARY KEY (`creditcardid`),
  KEY `fk_creditcard_bank1_idx` (`bankid`),
  KEY `fk_creditcard_file_idx` (`coverimagefileid`),
  KEY `fk_creditcard_network1_idx` (`networkid`),
  CONSTRAINT `fk_creditcard_bank1_idx` FOREIGN KEY (`bankid`) REFERENCES `bank` (`bankid`),
  CONSTRAINT `fk_creditcard_file_idx` FOREIGN KEY (`coverimagefileid`) REFERENCES `file` (`fileid`),
  CONSTRAINT `fk_creditcard_network1_idx` FOREIGN KEY (`networkid`) REFERENCES `network` (`networkid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `creditcard`
--

LOCK TABLES `creditcard` WRITE;
/*!40000 ALTER TABLE `creditcard` DISABLE KEYS */;
/*!40000 ALTER TABLE `creditcard` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `file`
--

DROP TABLE IF EXISTS `file`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `file` (
  `fileid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `private` tinyint(4) DEFAULT '0',
  `url` text COLLATE utf8mb4_unicode_ci,
  `originalfilename` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `thumbnail` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mimetype` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `filename` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `size` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`fileid`)
) ENGINE=InnoDB AUTO_INCREMENT=356 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `file`
--

LOCK TABLES `file` WRITE;
/*!40000 ALTER TABLE `file` DISABLE KEYS */;
INSERT INTO `file` VALUES (26,0,'https://genstone.s3.us-east-2.amazonaws.com/uploads/157298132821-212675_bank-of-america-logo-photo-bank-of-america.png','21-212675_bank-of-america-logo-photo-bank-of-america.png',NULL,'image/png','uploads/157298132821-212675_bank-of-america-logo-photo-bank-of-america.png','36056',NULL,'2019-11-05 17:15:32','2019-11-05 17:15:32'),(27,0,'https://genstone.s3.us-east-2.amazonaws.com/uploads/1572981342americanexpress%2Bbank%2Bexpress%2Blogo%2Bmedia%2Bicon-1320193175614199373.png','americanexpress+bank+express+logo+media+icon-1320193175614199373.png',NULL,'image/png','uploads/1572981342americanexpress+bank+express+logo+media+icon-1320193175614199373.png','31864',NULL,'2019-11-05 17:15:45','2019-11-05 17:15:45'),(28,0,'https://genstone.s3.us-east-2.amazonaws.com/uploads/1572981354logo.png','logo.png',NULL,'image/png','uploads/1572981354logo.png','55873',NULL,'2019-11-05 17:15:58','2019-11-05 17:15:58'),(32,0,'https://genstone.s3.us-east-2.amazonaws.com/uploads/157298237821-212675_bank-of-america-logo-photo-bank-of-america.png','21-212675_bank-of-america-logo-photo-bank-of-america.png',NULL,'image/png','uploads/157298237821-212675_bank-of-america-logo-photo-bank-of-america.png','36056',NULL,'2019-11-05 17:33:00','2019-11-05 17:33:00'),(33,0,'https://genstone.s3.us-east-2.amazonaws.com/uploads/1572982474%5Bfinal%5D%20logo.png','[final] logo.png',NULL,'image/png','uploads/1572982474[final] logo.png','51900',NULL,'2019-11-05 17:34:41','2019-11-05 17:34:41'),(34,0,'https://genstone.s3.us-east-2.amazonaws.com/uploads/1572983188%5Bfinal%5D%20logo.png','[final] logo.png',NULL,'image/png','uploads/1572983188[final] logo.png','51900',NULL,'2019-11-05 17:46:32','2019-11-05 17:46:32'),(35,0,'https://genstone.s3.us-east-2.amazonaws.com/uploads/1572983242%5Bfinal%5D%20logo.png','[final] logo.png',NULL,'image/png','uploads/1572983242[final] logo.png','51900',NULL,'2019-11-05 17:47:25','2019-11-05 17:47:25'),(36,0,'https://genstone.s3.us-east-2.amazonaws.com/uploads/1572983260%5Bfinal%5D%20logo.png','[final] logo.png',NULL,'image/png','uploads/1572983260[final] logo.png','51900',NULL,'2019-11-05 17:47:43','2019-11-05 17:47:43'),(37,0,'https://genstone.s3.us-east-2.amazonaws.com/uploads/1572983376%5Bfinal%5D%20logo.png','[final] logo.png',NULL,'image/png','uploads/1572983376[final] logo.png','51900',NULL,'2019-11-05 17:49:39','2019-11-05 17:49:39'),(38,0,'https://genstone.s3.us-east-2.amazonaws.com/uploads/1572983454%5Bfinal%5D%20logo.png','[final] logo.png',NULL,'image/png','uploads/1572983454[final] logo.png','51900',NULL,'2019-11-05 17:50:58','2019-11-05 17:50:58'),(39,0,'https://genstone.s3.us-east-2.amazonaws.com/uploads/1572983520%5Bfinal%5D%20logo.png','[final] logo.png',NULL,'image/png','uploads/1572983520[final] logo.png','51900',NULL,'2019-11-05 17:52:04','2019-11-05 17:52:04'),(41,0,'https://genstone.s3.us-east-2.amazonaws.com/uploads/1572983851%5Bfinal%5D%20logo.png','[final] logo.png',NULL,'image/png','uploads/1572983851[final] logo.png','51900',NULL,'2019-11-05 17:57:34','2019-11-05 17:57:34'),(42,0,'https://genstone.s3.us-east-2.amazonaws.com/uploads/1572983993%5Bfinal%5D%20logo.png','[final] logo.png',NULL,'image/png','uploads/1572983993[final] logo.png','51900',NULL,'2019-11-05 17:59:56','2019-11-05 17:59:56'),(43,0,'https://genstone.s3.us-east-2.amazonaws.com/uploads/157298409021-212675_bank-of-america-logo-photo-bank-of-america.png','21-212675_bank-of-america-logo-photo-bank-of-america.png',NULL,'image/png','uploads/157298409021-212675_bank-of-america-logo-photo-bank-of-america.png','36056',NULL,'2019-11-05 18:01:34','2019-11-05 18:01:34'),(44,0,'https://genstone.s3.us-east-2.amazonaws.com/uploads/1572984233%5Bfinal%5D%20logo.png','[final] logo.png',NULL,'image/png','uploads/1572984233[final] logo.png','51900',NULL,'2019-11-05 18:03:57','2019-11-05 18:03:57'),(46,0,'https://genstone.s3.us-east-2.amazonaws.com/uploads/157298427821-212675_bank-of-america-logo-photo-bank-of-america.png','21-212675_bank-of-america-logo-photo-bank-of-america.png',NULL,'image/png','uploads/157298427821-212675_bank-of-america-logo-photo-bank-of-america.png','36056',NULL,'2019-11-05 18:04:41','2019-11-05 18:04:41'),(48,0,'https://genstone.s3.us-east-2.amazonaws.com/uploads/1572984786Barclays-PLC.png','Barclays-PLC.png',NULL,'image/png','uploads/1572984786Barclays-PLC.png','9634',NULL,'2019-11-05 18:13:08','2019-11-05 18:13:08'),(49,0,'https://genstone.s3.us-east-2.amazonaws.com/uploads/1572984832unnamed.png','unnamed.png',NULL,'image/png','uploads/1572984832unnamed.png','25203',NULL,'2019-11-05 18:13:54','2019-11-05 18:13:54'),(50,0,'https://genstone.s3.us-east-2.amazonaws.com/uploads/1572984887chase-bank-thankyou-buildinghomesforheroes.png','chase-bank-thankyou-buildinghomesforheroes.png',NULL,'image/png','uploads/1572984887chase-bank-thankyou-buildinghomesforheroes.png','170147',NULL,'2019-11-05 18:14:53','2019-11-05 18:14:53'),(52,0,'https://genstone.s3.us-east-2.amazonaws.com/uploads/15729849725d9c8b3bda7ad.png','5d9c8b3bda7ad.png',NULL,'image/png','uploads/15729849725d9c8b3bda7ad.png','7505',NULL,'2019-11-05 18:16:14','2019-11-05 18:16:14'),(53,0,'https://genstone.s3.us-east-2.amazonaws.com/uploads/1572985000icon-384x384.png','icon-384x384.png',NULL,'image/png','uploads/1572985000icon-384x384.png','3045',NULL,'2019-11-05 18:16:42','2019-11-05 18:16:42'),(54,0,'https://genstone.s3.us-east-2.amazonaws.com/uploads/1572985045wells_fargo.png','wells_fargo.png',NULL,'image/png','uploads/1572985045wells_fargo.png','27459',NULL,'2019-11-05 18:17:28','2019-11-05 18:17:28'),(55,0,'https://genstone.s3.us-east-2.amazonaws.com/uploads/1572985098citibank.png','citibank.png',NULL,'image/png','uploads/1572985098citibank.png','17751',NULL,'2019-11-05 18:18:20','2019-11-05 18:18:20'),(56,0,'https://genstone.s3.us-east-2.amazonaws.com/uploads/1573017081flag-of-United-States-of-America.png','flag-of-United-States-of-America.png',NULL,'image/png','uploads/1573017081flag-of-United-States-of-America.png','990',NULL,'2019-11-06 03:11:22','2019-11-06 03:11:22'),(57,0,'https://genstone.s3.us-east-2.amazonaws.com/uploads/1573017197flag-of-South-Africa.png','flag-of-South-Africa.png',NULL,'image/png','uploads/1573017197flag-of-South-Africa.png','899',NULL,'2019-11-06 03:13:18','2019-11-06 03:13:18'),(58,0,'https://genstone.s3.us-east-2.amazonaws.com/uploads/1573063890Return%20Details%20to%20Update%20300619%20%282%29.csv','Return Details to Update 300619 (2).csv',NULL,'application/octet-stream','uploads/1573063890Return Details to Update 300619 (2).csv','4975431',NULL,'2019-11-06 16:12:05','2019-11-06 16:12:05'),(59,0,'https://genstone.s3.us-east-2.amazonaws.com/uploads/1573063938family-portrait.jpg','family-portrait.jpg',NULL,'image/jpeg','uploads/1573063938family-portrait.jpg','48267',NULL,'2019-11-06 16:12:21','2019-11-06 16:12:21'),(60,0,'https://genstone.s3.us-east-2.amazonaws.com/uploads/1573115417download.png','download.png',NULL,'image/png','uploads/1573115417download.png','2256',NULL,'2019-11-07 06:30:26','2019-11-07 06:30:26'),(62,0,'https://genstone.s3.us-east-2.amazonaws.com/uploads/1573126451Flag_of_Malaysia.svg','Flag_of_Malaysia.svg',NULL,'image/svg+xml','uploads/1573126451Flag_of_Malaysia.svg','683',NULL,'2019-11-07 09:34:17','2019-11-07 09:34:17'),(63,0,'https://genstone.s3.us-east-2.amazonaws.com/uploads/1573126534file.jpg','file.jpg',NULL,'image/jpeg','uploads/1573126534file.jpg','103651',NULL,'2019-11-07 09:35:47','2019-11-07 09:35:47'),(64,0,'https://genstone.s3.us-east-2.amazonaws.com/uploads/1573280585cn.png','cn.png',NULL,'image/png','uploads/1573280585cn.png','7043',NULL,'2019-11-09 04:23:08','2019-11-09 04:23:08'),(66,0,'https://genstone.s3.us-east-2.amazonaws.com/uploads/1573280729cn.png','cn.png',NULL,'image/png','uploads/1573280729cn.png','7043',NULL,'2019-11-09 04:25:32','2019-11-09 04:25:32'),(67,0,'https://genstone.s3.us-east-2.amazonaws.com/uploads/1573284598cn.png','cn.png',NULL,'image/png','uploads/1573284598cn.png','7043',NULL,'2019-11-09 05:29:59','2019-11-09 05:29:59'),(68,0,'https://genstone.s3.us-east-2.amazonaws.com/uploads/1573284720cn.png','cn.png',NULL,'image/png','uploads/1573284720cn.png','7043',NULL,'2019-11-09 05:32:04','2019-11-09 05:32:04'),(69,0,'https://genstone.s3.us-east-2.amazonaws.com/uploads/1573285104cn.png','cn.png',NULL,'image/png','uploads/1573285104cn.png','7043',NULL,'2019-11-09 05:38:26','2019-11-09 05:38:26'),(70,0,'https://genstone.s3.us-east-2.amazonaws.com/uploads/1573285204cn.png','cn.png',NULL,'image/png','uploads/1573285204cn.png','7043',NULL,'2019-11-09 05:40:07','2019-11-09 05:40:07'),(71,0,'https://genstone.s3.us-east-2.amazonaws.com/uploads/1573285347cn.png','cn.png',NULL,'image/png','uploads/1573285347cn.png','7043',NULL,'2019-11-09 05:42:29','2019-11-09 05:42:29'),(78,0,'https://genstone.s3.us-east-2.amazonaws.com/uploads/1573296260Flag_of_Barbados.gif','Flag_of_Barbados.gif',NULL,'image/gif','uploads/1573296260Flag_of_Barbados.gif','4255',NULL,'2019-11-09 08:44:21','2019-11-09 08:44:21'),(79,0,'https://genstone.s3.us-east-2.amazonaws.com/uploads/1573297572cn.png','cn.png',NULL,'image/png','uploads/1573297572cn.png','7043',NULL,'2019-11-09 09:06:14','2019-11-09 09:06:14'),(80,0,'https://genstone.s3.us-east-2.amazonaws.com/uploads/1573297798cn.png','cn.png',NULL,'image/png','uploads/1573297798cn.png','7043',NULL,'2019-11-09 09:10:00','2019-11-09 09:10:00'),(83,0,'https://genstone.s3.us-east-2.amazonaws.com/uploads/1573302329UNKG4003__33888.1460461096.1280.1280__50892.1480682060.1280.1280.png','UNKG4003__33888.1460461096.1280.1280__50892.1480682060.1280.1280.png','https://genstone.s3.us-east-2.amazonaws.com/uploads/1573302329UNKG4003__33888.1460461096.1280.1280__50892.1480682060.1280.1280.png','image/png','uploads/1573302329UNKG4003__33888.1460461096.1280.1280__50892.1480682060.1280.1280.png','54531',NULL,'2019-11-09 10:25:41','2019-11-09 10:25:41'),(84,0,'https://genstone.s3.us-east-2.amazonaws.com/uploads/1573302418annual-enterprise-survey-2018-financial-year-provisional-csv.csv','annual-enterprise-survey-2018-financial-year-provisional-csv.csv',NULL,'text/csv','uploads/1573302418annual-enterprise-survey-2018-financial-year-provisional-csv.csv','4376981',NULL,'2019-11-09 10:27:18','2019-11-09 10:27:18'),(86,0,'https://genstone.s3.us-east-2.amazonaws.com/uploads/1573302520UNKG4003__33888.1460461096.1280.1280__50892.1480682060.1280.1280.png','UNKG4003__33888.1460461096.1280.1280__50892.1480682060.1280.1280.png',NULL,'image/png','uploads/1573302520UNKG4003__33888.1460461096.1280.1280__50892.1480682060.1280.1280.png','54531',NULL,'2019-11-09 10:28:49','2019-11-09 10:28:49'),(87,0,'https://genstone.s3.us-east-2.amazonaws.com/uploads/1573304257UNKG4003__33888.1460461096.1280.1280__50892.1480682060.1280.1280.png','UNKG4003__33888.1460461096.1280.1280__50892.1480682060.1280.1280.png',NULL,'image/png','uploads/1573304257UNKG4003__33888.1460461096.1280.1280__50892.1480682060.1280.1280.png','54531',NULL,'2019-11-09 10:57:46','2019-11-09 10:57:46'),(88,0,'https://genstone.s3.us-east-2.amazonaws.com/uploads/1573304351UNKG4003__33888.1460461096.1280.1280__50892.1480682060.1280.1280.png','UNKG4003__33888.1460461096.1280.1280__50892.1480682060.1280.1280.png',NULL,'image/png','uploads/1573304351UNKG4003__33888.1460461096.1280.1280__50892.1480682060.1280.1280.png','54531',NULL,'2019-11-09 10:59:21','2019-11-09 10:59:21'),(89,0,'https://genstone.s3.us-east-2.amazonaws.com/uploads/1573304435UNKG4003__33888.1460461096.1280.1280__50892.1480682060.1280.1280.png','UNKG4003__33888.1460461096.1280.1280__50892.1480682060.1280.1280.png',NULL,'image/png','uploads/1573304435UNKG4003__33888.1460461096.1280.1280__50892.1480682060.1280.1280.png','54531',NULL,'2019-11-09 11:00:47','2019-11-09 11:00:47'),(90,0,'https://genstone.s3.us-east-2.amazonaws.com/uploads/1573304948cn.png','cn.png',NULL,'image/png','uploads/1573304948cn.png','7043',NULL,'2019-11-09 11:09:15','2019-11-09 11:09:15'),(91,0,'https://genstone.s3.us-east-2.amazonaws.com/uploads/1573305334UNKG4003__33888.1460461096.1280.1280__50892.1480682060.1280.1280.png','UNKG4003__33888.1460461096.1280.1280__50892.1480682060.1280.1280.png',NULL,'image/png','uploads/1573305334UNKG4003__33888.1460461096.1280.1280__50892.1480682060.1280.1280.png','54531',NULL,'2019-11-09 11:15:44','2019-11-09 11:15:44'),(92,0,'https://genstone.s3.us-east-2.amazonaws.com/uploads/1573305404UNKG4003__33888.1460461096.1280.1280__50892.1480682060.1280.1280.png','UNKG4003__33888.1460461096.1280.1280__50892.1480682060.1280.1280.png',NULL,'image/png','uploads/1573305404UNKG4003__33888.1460461096.1280.1280__50892.1480682060.1280.1280.png','54531',NULL,'2019-11-09 11:16:56','2019-11-09 11:16:56'),(93,0,'https://genstone.s3.us-east-2.amazonaws.com/uploads/1573306004UNKG4003__33888.1460461096.1280.1280__50892.1480682060.1280.1280.png','UNKG4003__33888.1460461096.1280.1280__50892.1480682060.1280.1280.png',NULL,'image/png','uploads/1573306004UNKG4003__33888.1460461096.1280.1280__50892.1480682060.1280.1280.png','54531',NULL,'2019-11-09 11:26:54','2019-11-09 11:26:54'),(94,0,'https://genstone.s3.us-east-2.amazonaws.com/uploads/1573308075Fuji-X-A7-sample-image-1.jpg','Fuji-X-A7-sample-image-1.jpg',NULL,'image/jpeg','uploads/1573308075Fuji-X-A7-sample-image-1.jpg','61641',NULL,'2019-11-09 12:01:25','2019-11-09 12:01:25'),(95,0,'https://genstone.s3.us-east-2.amazonaws.com/uploads/1573308377Fuji-X-A7-sample-image-1.jpg','Fuji-X-A7-sample-image-1.jpg',NULL,'image/jpeg','uploads/1573308377Fuji-X-A7-sample-image-1.jpg','61641',NULL,'2019-11-09 12:06:26','2019-11-09 12:06:26'),(96,0,'https://genstone.s3.us-east-2.amazonaws.com/uploads/1573309313Fuji-X-A7-sample-image-1.jpg','Fuji-X-A7-sample-image-1.jpg','https://genstone.s3.us-east-2.amazonaws.com/uploads/1573309313Fuji-X-A7-sample-image-1.jpg','image/jpeg','uploads/1573309313Fuji-X-A7-sample-image-1.jpg','61641',NULL,'2019-11-09 12:22:02','2019-11-09 12:22:02'),(97,0,'https://genstone.s3.us-east-2.amazonaws.com/uploads/1573310619Flag_of_Barbados.gif','Flag_of_Barbados.gif','https://genstone.s3.us-east-2.amazonaws.com/uploads/1573310619Flag_of_Barbados.gif','image/gif','uploads/1573310619Flag_of_Barbados.gif','4255',NULL,'2019-11-09 12:43:46','2019-11-09 12:43:46'),(100,0,'https://genstone.s3.us-east-2.amazonaws.com/uploads/1573321353Fuji-X-A7-sample-image-1.jpg','Fuji-X-A7-sample-image-1.jpg','https://genstone.s3.us-east-2.amazonaws.com/uploads/1573321353Fuji-X-A7-sample-image-1.jpg','image/jpeg','uploads/1573321353Fuji-X-A7-sample-image-1.jpg','61641',NULL,'2019-11-09 15:42:37','2019-11-09 15:42:37'),(101,0,'https://genstone.s3.us-east-2.amazonaws.com/uploads/1573322651Fuji-X-A7-sample-image-1.jpg','Fuji-X-A7-sample-image-1.jpg','https://genstone.s3.us-east-2.amazonaws.com/uploads/1573322651Fuji-X-A7-sample-image-1.jpg','image/jpeg','uploads/1573322651Fuji-X-A7-sample-image-1.jpg','61641',NULL,'2019-11-09 16:04:17','2019-11-09 16:04:17'),(102,0,'https://genstone.s3.us-east-2.amazonaws.com/uploads/1573322804aul_ms_master_policies.zip','aul_ms_master_policies.zip',NULL,'application/zip','uploads/1573322804aul_ms_master_policies.zip','567488',NULL,'2019-11-09 16:06:53','2019-11-09 16:06:53'),(103,0,'https://genstone.s3.us-east-2.amazonaws.com/uploads/1573323464rocket.png','rocket.png','https://genstone.s3.us-east-2.amazonaws.com/uploads/1573323464rocket.png','image/png','uploads/1573323464rocket.png','15130',NULL,'2019-11-09 16:17:47','2019-11-09 16:17:47'),(104,0,'https://genstone.s3.us-east-2.amazonaws.com/uploads/1573323846rocket.png','rocket.png','https://genstone.s3.us-east-2.amazonaws.com/uploads/1573323846rocket.png','image/png','uploads/1573323846rocket.png','15130',NULL,'2019-11-09 16:24:09','2019-11-09 16:24:09'),(105,0,'https://genstone.s3.us-east-2.amazonaws.com/uploads/1573324678Wallpaper-v4-2560x1440.jpg','Wallpaper-v4-2560x1440.jpg','https://genstone.s3.us-east-2.amazonaws.com/uploads/1573324678Wallpaper-v4-2560x1440.jpg','image/jpeg','uploads/1573324678Wallpaper-v4-2560x1440.jpg','3285636',NULL,'2019-11-09 16:38:32','2019-11-09 16:38:32'),(106,0,'https://genstone.s3.us-east-2.amazonaws.com/afg.svg','Afghanistan','https://genstone.s3.us-east-2.amazonaws.com/afg.svg','image/svg','afg.svg','0',NULL,'2019-11-11 18:56:43','2019-11-11 18:56:43'),(107,0,'https://genstone.s3.us-east-2.amazonaws.com/ala.svg','Åland Islands','https://genstone.s3.us-east-2.amazonaws.com/ala.svg','image/svg','ala.svg','0',NULL,'2019-11-11 18:56:44','2019-11-11 18:56:44'),(108,0,'https://genstone.s3.us-east-2.amazonaws.com/alb.svg','Albania','https://genstone.s3.us-east-2.amazonaws.com/alb.svg','image/svg','alb.svg','0',NULL,'2019-11-11 18:56:44','2019-11-11 18:56:44'),(109,0,'https://genstone.s3.us-east-2.amazonaws.com/dza.svg','Algeria','https://genstone.s3.us-east-2.amazonaws.com/dza.svg','image/svg','dza.svg','0',NULL,'2019-11-11 18:56:44','2019-11-11 18:56:44'),(110,0,'https://genstone.s3.us-east-2.amazonaws.com/asm.svg','American Samoa','https://genstone.s3.us-east-2.amazonaws.com/asm.svg','image/svg','asm.svg','0',NULL,'2019-11-11 18:56:45','2019-11-11 18:56:45'),(111,0,'https://genstone.s3.us-east-2.amazonaws.com/and.svg','Andorra','https://genstone.s3.us-east-2.amazonaws.com/and.svg','image/svg','and.svg','0',NULL,'2019-11-11 18:56:46','2019-11-11 18:56:46'),(112,0,'https://genstone.s3.us-east-2.amazonaws.com/ago.svg','Angola','https://genstone.s3.us-east-2.amazonaws.com/ago.svg','image/svg','ago.svg','0',NULL,'2019-11-11 18:56:46','2019-11-11 18:56:46'),(113,0,'https://genstone.s3.us-east-2.amazonaws.com/aia.svg','Anguilla','https://genstone.s3.us-east-2.amazonaws.com/aia.svg','image/svg','aia.svg','0',NULL,'2019-11-11 18:56:46','2019-11-11 18:56:46'),(114,0,'https://genstone.s3.us-east-2.amazonaws.com/ata.svg','Antarctica','https://genstone.s3.us-east-2.amazonaws.com/ata.svg','image/svg','ata.svg','0',NULL,'2019-11-11 18:56:47','2019-11-11 18:56:47'),(115,0,'https://genstone.s3.us-east-2.amazonaws.com/atg.svg','Antigua and Barbuda','https://genstone.s3.us-east-2.amazonaws.com/atg.svg','image/svg','atg.svg','0',NULL,'2019-11-11 18:56:47','2019-11-11 18:56:47'),(116,0,'https://genstone.s3.us-east-2.amazonaws.com/arg.svg','Argentina','https://genstone.s3.us-east-2.amazonaws.com/arg.svg','image/svg','arg.svg','0',NULL,'2019-11-11 18:56:47','2019-11-11 18:56:47'),(117,0,'https://genstone.s3.us-east-2.amazonaws.com/arm.svg','Armenia','https://genstone.s3.us-east-2.amazonaws.com/arm.svg','image/svg','arm.svg','0',NULL,'2019-11-11 18:56:48','2019-11-11 18:56:48'),(118,0,'https://genstone.s3.us-east-2.amazonaws.com/abw.svg','Aruba','https://genstone.s3.us-east-2.amazonaws.com/abw.svg','image/svg','abw.svg','0',NULL,'2019-11-11 18:56:48','2019-11-11 18:56:48'),(119,0,'https://genstone.s3.us-east-2.amazonaws.com/aus.svg','Australia','https://genstone.s3.us-east-2.amazonaws.com/aus.svg','image/svg','aus.svg','0',NULL,'2019-11-11 18:56:48','2019-11-11 18:56:48'),(120,0,'https://genstone.s3.us-east-2.amazonaws.com/aut.svg','Austria','https://genstone.s3.us-east-2.amazonaws.com/aut.svg','image/svg','aut.svg','0',NULL,'2019-11-11 18:56:49','2019-11-11 18:56:49'),(121,0,'https://genstone.s3.us-east-2.amazonaws.com/aze.svg','Azerbaijan','https://genstone.s3.us-east-2.amazonaws.com/aze.svg','image/svg','aze.svg','0',NULL,'2019-11-11 18:56:49','2019-11-11 18:56:49'),(122,0,'https://genstone.s3.us-east-2.amazonaws.com/bhs.svg','Bahamas','https://genstone.s3.us-east-2.amazonaws.com/bhs.svg','image/svg','bhs.svg','0',NULL,'2019-11-11 18:56:50','2019-11-11 18:56:50'),(123,0,'https://genstone.s3.us-east-2.amazonaws.com/bhr.svg','Bahrain','https://genstone.s3.us-east-2.amazonaws.com/bhr.svg','image/svg','bhr.svg','0',NULL,'2019-11-11 18:56:50','2019-11-11 18:56:50'),(124,0,'https://genstone.s3.us-east-2.amazonaws.com/bgd.svg','Bangladesh','https://genstone.s3.us-east-2.amazonaws.com/bgd.svg','image/svg','bgd.svg','0',NULL,'2019-11-11 18:56:50','2019-11-11 18:56:50'),(125,0,'https://genstone.s3.us-east-2.amazonaws.com/brb.svg','Barbados','https://genstone.s3.us-east-2.amazonaws.com/brb.svg','image/svg','brb.svg','0',NULL,'2019-11-11 18:56:51','2019-11-11 18:56:51'),(126,0,'https://genstone.s3.us-east-2.amazonaws.com/blr.svg','Belarus','https://genstone.s3.us-east-2.amazonaws.com/blr.svg','image/svg','blr.svg','0',NULL,'2019-11-11 18:56:51','2019-11-11 18:56:51'),(127,0,'https://genstone.s3.us-east-2.amazonaws.com/bel.svg','Belgium','https://genstone.s3.us-east-2.amazonaws.com/bel.svg','image/svg','bel.svg','0',NULL,'2019-11-11 18:56:51','2019-11-11 18:56:51'),(128,0,'https://genstone.s3.us-east-2.amazonaws.com/blz.svg','Belize','https://genstone.s3.us-east-2.amazonaws.com/blz.svg','image/svg','blz.svg','0',NULL,'2019-11-11 18:56:52','2019-11-11 18:56:52'),(129,0,'https://genstone.s3.us-east-2.amazonaws.com/ben.svg','Benin','https://genstone.s3.us-east-2.amazonaws.com/ben.svg','image/svg','ben.svg','0',NULL,'2019-11-11 18:56:52','2019-11-11 18:56:52'),(130,0,'https://genstone.s3.us-east-2.amazonaws.com/bmu.svg','Bermuda','https://genstone.s3.us-east-2.amazonaws.com/bmu.svg','image/svg','bmu.svg','0',NULL,'2019-11-11 18:56:53','2019-11-11 18:56:53'),(131,0,'https://genstone.s3.us-east-2.amazonaws.com/btn.svg','Bhutan','https://genstone.s3.us-east-2.amazonaws.com/btn.svg','image/svg','btn.svg','0',NULL,'2019-11-11 18:56:53','2019-11-11 18:56:53'),(132,0,'https://genstone.s3.us-east-2.amazonaws.com/bol.svg','Bolivia (Plurinational State of)','https://genstone.s3.us-east-2.amazonaws.com/bol.svg','image/svg','bol.svg','0',NULL,'2019-11-11 18:56:53','2019-11-11 18:56:53'),(133,0,'https://genstone.s3.us-east-2.amazonaws.com/bes.svg','Bonaire, Sint Eustatius and Saba','https://genstone.s3.us-east-2.amazonaws.com/bes.svg','image/svg','bes.svg','0',NULL,'2019-11-11 18:56:54','2019-11-11 18:56:54'),(134,0,'https://genstone.s3.us-east-2.amazonaws.com/bih.svg','Bosnia and Herzegovina','https://genstone.s3.us-east-2.amazonaws.com/bih.svg','image/svg','bih.svg','0',NULL,'2019-11-11 18:56:54','2019-11-11 18:56:54'),(135,0,'https://genstone.s3.us-east-2.amazonaws.com/bwa.svg','Botswana','https://genstone.s3.us-east-2.amazonaws.com/bwa.svg','image/svg','bwa.svg','0',NULL,'2019-11-11 18:56:55','2019-11-11 18:56:55'),(136,0,'https://genstone.s3.us-east-2.amazonaws.com/bvt.svg','Bouvet Island','https://genstone.s3.us-east-2.amazonaws.com/bvt.svg','image/svg','bvt.svg','0',NULL,'2019-11-11 18:56:55','2019-11-11 18:56:55'),(137,0,'https://genstone.s3.us-east-2.amazonaws.com/bra.svg','Brazil','https://genstone.s3.us-east-2.amazonaws.com/bra.svg','image/svg','bra.svg','0',NULL,'2019-11-11 18:56:56','2019-11-11 18:56:56'),(138,0,'https://genstone.s3.us-east-2.amazonaws.com/iot.svg','British Indian Ocean Territory','https://genstone.s3.us-east-2.amazonaws.com/iot.svg','image/svg','iot.svg','0',NULL,'2019-11-11 18:56:58','2019-11-11 18:56:58'),(139,0,'https://genstone.s3.us-east-2.amazonaws.com/umi.svg','United States Minor Outlying Islands','https://genstone.s3.us-east-2.amazonaws.com/umi.svg','image/svg','umi.svg','0',NULL,'2019-11-11 18:56:59','2019-11-11 18:56:59'),(140,0,'https://genstone.s3.us-east-2.amazonaws.com/vgb.svg','Virgin Islands (British)','https://genstone.s3.us-east-2.amazonaws.com/vgb.svg','image/svg','vgb.svg','0',NULL,'2019-11-11 18:56:59','2019-11-11 18:56:59'),(141,0,'https://genstone.s3.us-east-2.amazonaws.com/vir.svg','Virgin Islands (U.S.)','https://genstone.s3.us-east-2.amazonaws.com/vir.svg','image/svg','vir.svg','0',NULL,'2019-11-11 18:56:59','2019-11-11 18:56:59'),(142,0,'https://genstone.s3.us-east-2.amazonaws.com/brn.svg','Brunei Darussalam','https://genstone.s3.us-east-2.amazonaws.com/brn.svg','image/svg','brn.svg','0',NULL,'2019-11-11 18:57:00','2019-11-11 18:57:00'),(143,0,'https://genstone.s3.us-east-2.amazonaws.com/bgr.svg','Bulgaria','https://genstone.s3.us-east-2.amazonaws.com/bgr.svg','image/svg','bgr.svg','0',NULL,'2019-11-11 18:57:00','2019-11-11 18:57:00'),(144,0,'https://genstone.s3.us-east-2.amazonaws.com/bfa.svg','Burkina Faso','https://genstone.s3.us-east-2.amazonaws.com/bfa.svg','image/svg','bfa.svg','0',NULL,'2019-11-11 18:57:00','2019-11-11 18:57:00'),(145,0,'https://genstone.s3.us-east-2.amazonaws.com/bdi.svg','Burundi','https://genstone.s3.us-east-2.amazonaws.com/bdi.svg','image/svg','bdi.svg','0',NULL,'2019-11-11 18:57:01','2019-11-11 18:57:01'),(146,0,'https://genstone.s3.us-east-2.amazonaws.com/khm.svg','Cambodia','https://genstone.s3.us-east-2.amazonaws.com/khm.svg','image/svg','khm.svg','0',NULL,'2019-11-11 18:57:01','2019-11-11 18:57:01'),(147,0,'https://genstone.s3.us-east-2.amazonaws.com/cmr.svg','Cameroon','https://genstone.s3.us-east-2.amazonaws.com/cmr.svg','image/svg','cmr.svg','0',NULL,'2019-11-11 18:57:02','2019-11-11 18:57:02'),(148,0,'https://genstone.s3.us-east-2.amazonaws.com/can.svg','Canada','https://genstone.s3.us-east-2.amazonaws.com/can.svg','image/svg','can.svg','0',NULL,'2019-11-11 18:57:02','2019-11-11 18:57:02'),(149,0,'https://genstone.s3.us-east-2.amazonaws.com/cpv.svg','Cabo Verde','https://genstone.s3.us-east-2.amazonaws.com/cpv.svg','image/svg','cpv.svg','0',NULL,'2019-11-11 18:57:02','2019-11-11 18:57:02'),(150,0,'https://genstone.s3.us-east-2.amazonaws.com/cym.svg','Cayman Islands','https://genstone.s3.us-east-2.amazonaws.com/cym.svg','image/svg','cym.svg','0',NULL,'2019-11-11 18:57:03','2019-11-11 18:57:03'),(151,0,'https://genstone.s3.us-east-2.amazonaws.com/caf.svg','Central African Republic','https://genstone.s3.us-east-2.amazonaws.com/caf.svg','image/svg','caf.svg','0',NULL,'2019-11-11 18:57:03','2019-11-11 18:57:03'),(152,0,'https://genstone.s3.us-east-2.amazonaws.com/tcd.svg','Chad','https://genstone.s3.us-east-2.amazonaws.com/tcd.svg','image/svg','tcd.svg','0',NULL,'2019-11-11 18:57:04','2019-11-11 18:57:04'),(153,0,'https://genstone.s3.us-east-2.amazonaws.com/chl.svg','Chile','https://genstone.s3.us-east-2.amazonaws.com/chl.svg','image/svg','chl.svg','0',NULL,'2019-11-11 18:57:04','2019-11-11 18:57:04'),(154,0,'https://genstone.s3.us-east-2.amazonaws.com/chn.svg','China','https://genstone.s3.us-east-2.amazonaws.com/chn.svg','image/svg','chn.svg','0',NULL,'2019-11-11 18:57:04','2019-11-11 18:57:04'),(155,0,'https://genstone.s3.us-east-2.amazonaws.com/cxr.svg','Christmas Island','https://genstone.s3.us-east-2.amazonaws.com/cxr.svg','image/svg','cxr.svg','0',NULL,'2019-11-11 18:57:05','2019-11-11 18:57:05'),(156,0,'https://genstone.s3.us-east-2.amazonaws.com/cck.svg','Cocos (Keeling) Islands','https://genstone.s3.us-east-2.amazonaws.com/cck.svg','image/svg','cck.svg','0',NULL,'2019-11-11 18:57:05','2019-11-11 18:57:05'),(157,0,'https://genstone.s3.us-east-2.amazonaws.com/col.svg','Colombia','https://genstone.s3.us-east-2.amazonaws.com/col.svg','image/svg','col.svg','0',NULL,'2019-11-11 18:57:06','2019-11-11 18:57:06'),(158,0,'https://genstone.s3.us-east-2.amazonaws.com/com.svg','Comoros','https://genstone.s3.us-east-2.amazonaws.com/com.svg','image/svg','com.svg','0',NULL,'2019-11-11 18:57:06','2019-11-11 18:57:06'),(159,0,'https://genstone.s3.us-east-2.amazonaws.com/cog.svg','Congo','https://genstone.s3.us-east-2.amazonaws.com/cog.svg','image/svg','cog.svg','0',NULL,'2019-11-11 18:57:06','2019-11-11 18:57:06'),(160,0,'https://genstone.s3.us-east-2.amazonaws.com/cod.svg','Congo (Democratic Republic of the)','https://genstone.s3.us-east-2.amazonaws.com/cod.svg','image/svg','cod.svg','0',NULL,'2019-11-11 18:57:07','2019-11-11 18:57:07'),(161,0,'https://genstone.s3.us-east-2.amazonaws.com/cok.svg','Cook Islands','https://genstone.s3.us-east-2.amazonaws.com/cok.svg','image/svg','cok.svg','0',NULL,'2019-11-11 18:57:07','2019-11-11 18:57:07'),(162,0,'https://genstone.s3.us-east-2.amazonaws.com/cri.svg','Costa Rica','https://genstone.s3.us-east-2.amazonaws.com/cri.svg','image/svg','cri.svg','0',NULL,'2019-11-11 18:57:07','2019-11-11 18:57:07'),(163,0,'https://genstone.s3.us-east-2.amazonaws.com/hrv.svg','Croatia','https://genstone.s3.us-east-2.amazonaws.com/hrv.svg','image/svg','hrv.svg','0',NULL,'2019-11-11 18:57:08','2019-11-11 18:57:08'),(164,0,'https://genstone.s3.us-east-2.amazonaws.com/cub.svg','Cuba','https://genstone.s3.us-east-2.amazonaws.com/cub.svg','image/svg','cub.svg','0',NULL,'2019-11-11 18:57:08','2019-11-11 18:57:08'),(165,0,'https://genstone.s3.us-east-2.amazonaws.com/cuw.svg','Curaçao','https://genstone.s3.us-east-2.amazonaws.com/cuw.svg','image/svg','cuw.svg','0',NULL,'2019-11-11 18:57:09','2019-11-11 18:57:09'),(166,0,'https://genstone.s3.us-east-2.amazonaws.com/cyp.svg','Cyprus','https://genstone.s3.us-east-2.amazonaws.com/cyp.svg','image/svg','cyp.svg','0',NULL,'2019-11-11 18:57:09','2019-11-11 18:57:09'),(167,0,'https://genstone.s3.us-east-2.amazonaws.com/cze.svg','Czech Republic','https://genstone.s3.us-east-2.amazonaws.com/cze.svg','image/svg','cze.svg','0',NULL,'2019-11-11 18:57:09','2019-11-11 18:57:09'),(168,0,'https://genstone.s3.us-east-2.amazonaws.com/dnk.svg','Denmark','https://genstone.s3.us-east-2.amazonaws.com/dnk.svg','image/svg','dnk.svg','0',NULL,'2019-11-11 18:57:10','2019-11-11 18:57:10'),(169,0,'https://genstone.s3.us-east-2.amazonaws.com/dji.svg','Djibouti','https://genstone.s3.us-east-2.amazonaws.com/dji.svg','image/svg','dji.svg','0',NULL,'2019-11-11 18:57:10','2019-11-11 18:57:10'),(170,0,'https://genstone.s3.us-east-2.amazonaws.com/dma.svg','Dominica','https://genstone.s3.us-east-2.amazonaws.com/dma.svg','image/svg','dma.svg','0',NULL,'2019-11-11 18:57:10','2019-11-11 18:57:10'),(171,0,'https://genstone.s3.us-east-2.amazonaws.com/dom.svg','Dominican Republic','https://genstone.s3.us-east-2.amazonaws.com/dom.svg','image/svg','dom.svg','0',NULL,'2019-11-11 18:57:12','2019-11-11 18:57:12'),(172,0,'https://genstone.s3.us-east-2.amazonaws.com/ecu.svg','Ecuador','https://genstone.s3.us-east-2.amazonaws.com/ecu.svg','image/svg','ecu.svg','0',NULL,'2019-11-11 18:57:15','2019-11-11 18:57:15'),(173,0,'https://genstone.s3.us-east-2.amazonaws.com/egy.svg','Egypt','https://genstone.s3.us-east-2.amazonaws.com/egy.svg','image/svg','egy.svg','0',NULL,'2019-11-11 18:57:15','2019-11-11 18:57:15'),(174,0,'https://genstone.s3.us-east-2.amazonaws.com/slv.svg','El Salvador','https://genstone.s3.us-east-2.amazonaws.com/slv.svg','image/svg','slv.svg','0',NULL,'2019-11-11 18:57:16','2019-11-11 18:57:16'),(175,0,'https://genstone.s3.us-east-2.amazonaws.com/gnq.svg','Equatorial Guinea','https://genstone.s3.us-east-2.amazonaws.com/gnq.svg','image/svg','gnq.svg','0',NULL,'2019-11-11 18:57:16','2019-11-11 18:57:16'),(176,0,'https://genstone.s3.us-east-2.amazonaws.com/eri.svg','Eritrea','https://genstone.s3.us-east-2.amazonaws.com/eri.svg','image/svg','eri.svg','0',NULL,'2019-11-11 18:57:16','2019-11-11 18:57:16'),(177,0,'https://genstone.s3.us-east-2.amazonaws.com/est.svg','Estonia','https://genstone.s3.us-east-2.amazonaws.com/est.svg','image/svg','est.svg','0',NULL,'2019-11-11 18:57:17','2019-11-11 18:57:17'),(178,0,'https://genstone.s3.us-east-2.amazonaws.com/eth.svg','Ethiopia','https://genstone.s3.us-east-2.amazonaws.com/eth.svg','image/svg','eth.svg','0',NULL,'2019-11-11 18:57:17','2019-11-11 18:57:17'),(179,0,'https://genstone.s3.us-east-2.amazonaws.com/flk.svg','Falkland Islands (Malvinas)','https://genstone.s3.us-east-2.amazonaws.com/flk.svg','image/svg','flk.svg','0',NULL,'2019-11-11 18:57:17','2019-11-11 18:57:17'),(180,0,'https://genstone.s3.us-east-2.amazonaws.com/fro.svg','Faroe Islands','https://genstone.s3.us-east-2.amazonaws.com/fro.svg','image/svg','fro.svg','0',NULL,'2019-11-11 18:57:18','2019-11-11 18:57:18'),(181,0,'https://genstone.s3.us-east-2.amazonaws.com/fji.svg','Fiji','https://genstone.s3.us-east-2.amazonaws.com/fji.svg','image/svg','fji.svg','0',NULL,'2019-11-11 18:57:18','2019-11-11 18:57:18'),(182,0,'https://genstone.s3.us-east-2.amazonaws.com/fin.svg','Finland','https://genstone.s3.us-east-2.amazonaws.com/fin.svg','image/svg','fin.svg','0',NULL,'2019-11-11 18:57:19','2019-11-11 18:57:19'),(183,0,'https://genstone.s3.us-east-2.amazonaws.com/fra.svg','France','https://genstone.s3.us-east-2.amazonaws.com/fra.svg','image/svg','fra.svg','0',NULL,'2019-11-11 18:57:19','2019-11-11 18:57:19'),(184,0,'https://genstone.s3.us-east-2.amazonaws.com/guf.svg','French Guiana','https://genstone.s3.us-east-2.amazonaws.com/guf.svg','image/svg','guf.svg','0',NULL,'2019-11-11 18:57:19','2019-11-11 18:57:19'),(185,0,'https://genstone.s3.us-east-2.amazonaws.com/pyf.svg','French Polynesia','https://genstone.s3.us-east-2.amazonaws.com/pyf.svg','image/svg','pyf.svg','0',NULL,'2019-11-11 18:57:20','2019-11-11 18:57:20'),(186,0,'https://genstone.s3.us-east-2.amazonaws.com/atf.svg','French Southern Territories','https://genstone.s3.us-east-2.amazonaws.com/atf.svg','image/svg','atf.svg','0',NULL,'2019-11-11 18:57:20','2019-11-11 18:57:20'),(187,0,'https://genstone.s3.us-east-2.amazonaws.com/gab.svg','Gabon','https://genstone.s3.us-east-2.amazonaws.com/gab.svg','image/svg','gab.svg','0',NULL,'2019-11-11 18:57:20','2019-11-11 18:57:20'),(188,0,'https://genstone.s3.us-east-2.amazonaws.com/gmb.svg','Gambia','https://genstone.s3.us-east-2.amazonaws.com/gmb.svg','image/svg','gmb.svg','0',NULL,'2019-11-11 18:57:21','2019-11-11 18:57:21'),(189,0,'https://genstone.s3.us-east-2.amazonaws.com/geo.svg','Georgia','https://genstone.s3.us-east-2.amazonaws.com/geo.svg','image/svg','geo.svg','0',NULL,'2019-11-11 18:57:21','2019-11-11 18:57:21'),(190,0,'https://genstone.s3.us-east-2.amazonaws.com/deu.svg','Germany','https://genstone.s3.us-east-2.amazonaws.com/deu.svg','image/svg','deu.svg','0',NULL,'2019-11-11 18:57:21','2019-11-11 18:57:21'),(191,0,'https://genstone.s3.us-east-2.amazonaws.com/gha.svg','Ghana','https://genstone.s3.us-east-2.amazonaws.com/gha.svg','image/svg','gha.svg','0',NULL,'2019-11-11 18:57:22','2019-11-11 18:57:22'),(192,0,'https://genstone.s3.us-east-2.amazonaws.com/gib.svg','Gibraltar','https://genstone.s3.us-east-2.amazonaws.com/gib.svg','image/svg','gib.svg','0',NULL,'2019-11-11 18:57:22','2019-11-11 18:57:22'),(193,0,'https://genstone.s3.us-east-2.amazonaws.com/grc.svg','Greece','https://genstone.s3.us-east-2.amazonaws.com/grc.svg','image/svg','grc.svg','0',NULL,'2019-11-11 18:57:22','2019-11-11 18:57:22'),(194,0,'https://genstone.s3.us-east-2.amazonaws.com/grl.svg','Greenland','https://genstone.s3.us-east-2.amazonaws.com/grl.svg','image/svg','grl.svg','0',NULL,'2019-11-11 18:57:23','2019-11-11 18:57:23'),(195,0,'https://genstone.s3.us-east-2.amazonaws.com/grd.svg','Grenada','https://genstone.s3.us-east-2.amazonaws.com/grd.svg','image/svg','grd.svg','0',NULL,'2019-11-11 18:57:23','2019-11-11 18:57:23'),(196,0,'https://genstone.s3.us-east-2.amazonaws.com/glp.svg','Guadeloupe','https://genstone.s3.us-east-2.amazonaws.com/glp.svg','image/svg','glp.svg','0',NULL,'2019-11-11 18:57:23','2019-11-11 18:57:23'),(197,0,'https://genstone.s3.us-east-2.amazonaws.com/gum.svg','Guam','https://genstone.s3.us-east-2.amazonaws.com/gum.svg','image/svg','gum.svg','0',NULL,'2019-11-11 18:57:24','2019-11-11 18:57:24'),(198,0,'https://genstone.s3.us-east-2.amazonaws.com/gtm.svg','Guatemala','https://genstone.s3.us-east-2.amazonaws.com/gtm.svg','image/svg','gtm.svg','0',NULL,'2019-11-11 18:57:24','2019-11-11 18:57:24'),(199,0,'https://genstone.s3.us-east-2.amazonaws.com/ggy.svg','Guernsey','https://genstone.s3.us-east-2.amazonaws.com/ggy.svg','image/svg','ggy.svg','0',NULL,'2019-11-11 18:57:24','2019-11-11 18:57:24'),(200,0,'https://genstone.s3.us-east-2.amazonaws.com/gin.svg','Guinea','https://genstone.s3.us-east-2.amazonaws.com/gin.svg','image/svg','gin.svg','0',NULL,'2019-11-11 18:57:25','2019-11-11 18:57:25'),(201,0,'https://genstone.s3.us-east-2.amazonaws.com/gnb.svg','Guinea-Bissau','https://genstone.s3.us-east-2.amazonaws.com/gnb.svg','image/svg','gnb.svg','0',NULL,'2019-11-11 18:57:25','2019-11-11 18:57:25'),(202,0,'https://genstone.s3.us-east-2.amazonaws.com/guy.svg','Guyana','https://genstone.s3.us-east-2.amazonaws.com/guy.svg','image/svg','guy.svg','0',NULL,'2019-11-11 18:57:25','2019-11-11 18:57:25'),(203,0,'https://genstone.s3.us-east-2.amazonaws.com/hti.svg','Haiti','https://genstone.s3.us-east-2.amazonaws.com/hti.svg','image/svg','hti.svg','0',NULL,'2019-11-11 18:57:26','2019-11-11 18:57:26'),(204,0,'https://genstone.s3.us-east-2.amazonaws.com/hmd.svg','Heard Island and McDonald Islands','https://genstone.s3.us-east-2.amazonaws.com/hmd.svg','image/svg','hmd.svg','0',NULL,'2019-11-11 18:57:26','2019-11-11 18:57:26'),(205,0,'https://genstone.s3.us-east-2.amazonaws.com/vat.svg','Holy See','https://genstone.s3.us-east-2.amazonaws.com/vat.svg','image/svg','vat.svg','0',NULL,'2019-11-11 18:57:26','2019-11-11 18:57:26'),(206,0,'https://genstone.s3.us-east-2.amazonaws.com/hnd.svg','Honduras','https://genstone.s3.us-east-2.amazonaws.com/hnd.svg','image/svg','hnd.svg','0',NULL,'2019-11-11 18:57:27','2019-11-11 18:57:27'),(207,0,'https://genstone.s3.us-east-2.amazonaws.com/hkg.svg','Hong Kong','https://genstone.s3.us-east-2.amazonaws.com/hkg.svg','image/svg','hkg.svg','0',NULL,'2019-11-11 18:57:28','2019-11-11 18:57:28'),(208,0,'https://genstone.s3.us-east-2.amazonaws.com/hun.svg','Hungary','https://genstone.s3.us-east-2.amazonaws.com/hun.svg','image/svg','hun.svg','0',NULL,'2019-11-11 18:57:28','2019-11-11 18:57:28'),(209,0,'https://genstone.s3.us-east-2.amazonaws.com/isl.svg','Iceland','https://genstone.s3.us-east-2.amazonaws.com/isl.svg','image/svg','isl.svg','0',NULL,'2019-11-11 18:57:28','2019-11-11 18:57:28'),(210,0,'https://genstone.s3.us-east-2.amazonaws.com/ind.svg','India','https://genstone.s3.us-east-2.amazonaws.com/ind.svg','image/svg','ind.svg','0',NULL,'2019-11-11 18:57:29','2019-11-11 18:57:29'),(211,0,'https://genstone.s3.us-east-2.amazonaws.com/idn.svg','Indonesia','https://genstone.s3.us-east-2.amazonaws.com/idn.svg','image/svg','idn.svg','0',NULL,'2019-11-11 18:57:29','2019-11-11 18:57:29'),(212,0,'https://genstone.s3.us-east-2.amazonaws.com/civ.svg','Côte d\'Ivoire','https://genstone.s3.us-east-2.amazonaws.com/civ.svg','image/svg','civ.svg','0',NULL,'2019-11-11 18:57:30','2019-11-11 18:57:30'),(213,0,'https://genstone.s3.us-east-2.amazonaws.com/irn.svg','Iran (Islamic Republic of)','https://genstone.s3.us-east-2.amazonaws.com/irn.svg','image/svg','irn.svg','0',NULL,'2019-11-11 18:57:30','2019-11-11 18:57:30'),(214,0,'https://genstone.s3.us-east-2.amazonaws.com/irq.svg','Iraq','https://genstone.s3.us-east-2.amazonaws.com/irq.svg','image/svg','irq.svg','0',NULL,'2019-11-11 18:57:30','2019-11-11 18:57:30'),(215,0,'https://genstone.s3.us-east-2.amazonaws.com/irl.svg','Ireland','https://genstone.s3.us-east-2.amazonaws.com/irl.svg','image/svg','irl.svg','0',NULL,'2019-11-11 18:57:31','2019-11-11 18:57:31'),(216,0,'https://genstone.s3.us-east-2.amazonaws.com/imn.svg','Isle of Man','https://genstone.s3.us-east-2.amazonaws.com/imn.svg','image/svg','imn.svg','0',NULL,'2019-11-11 18:57:31','2019-11-11 18:57:31'),(217,0,'https://genstone.s3.us-east-2.amazonaws.com/isr.svg','Israel','https://genstone.s3.us-east-2.amazonaws.com/isr.svg','image/svg','isr.svg','0',NULL,'2019-11-11 18:57:31','2019-11-11 18:57:31'),(218,0,'https://genstone.s3.us-east-2.amazonaws.com/ita.svg','Italy','https://genstone.s3.us-east-2.amazonaws.com/ita.svg','image/svg','ita.svg','0',NULL,'2019-11-11 18:57:32','2019-11-11 18:57:32'),(219,0,'https://genstone.s3.us-east-2.amazonaws.com/jam.svg','Jamaica','https://genstone.s3.us-east-2.amazonaws.com/jam.svg','image/svg','jam.svg','0',NULL,'2019-11-11 18:57:32','2019-11-11 18:57:32'),(220,0,'https://genstone.s3.us-east-2.amazonaws.com/jpn.svg','Japan','https://genstone.s3.us-east-2.amazonaws.com/jpn.svg','image/svg','jpn.svg','0',NULL,'2019-11-11 18:57:32','2019-11-11 18:57:32'),(221,0,'https://genstone.s3.us-east-2.amazonaws.com/jey.svg','Jersey','https://genstone.s3.us-east-2.amazonaws.com/jey.svg','image/svg','jey.svg','0',NULL,'2019-11-11 18:57:33','2019-11-11 18:57:33'),(222,0,'https://genstone.s3.us-east-2.amazonaws.com/jor.svg','Jordan','https://genstone.s3.us-east-2.amazonaws.com/jor.svg','image/svg','jor.svg','0',NULL,'2019-11-11 18:57:33','2019-11-11 18:57:33'),(223,0,'https://genstone.s3.us-east-2.amazonaws.com/kaz.svg','Kazakhstan','https://genstone.s3.us-east-2.amazonaws.com/kaz.svg','image/svg','kaz.svg','0',NULL,'2019-11-11 18:57:33','2019-11-11 18:57:33'),(224,0,'https://genstone.s3.us-east-2.amazonaws.com/ken.svg','Kenya','https://genstone.s3.us-east-2.amazonaws.com/ken.svg','image/svg','ken.svg','0',NULL,'2019-11-11 18:57:34','2019-11-11 18:57:34'),(225,0,'https://genstone.s3.us-east-2.amazonaws.com/kir.svg','Kiribati','https://genstone.s3.us-east-2.amazonaws.com/kir.svg','image/svg','kir.svg','0',NULL,'2019-11-11 18:57:34','2019-11-11 18:57:34'),(226,0,'https://genstone.s3.us-east-2.amazonaws.com/kwt.svg','Kuwait','https://genstone.s3.us-east-2.amazonaws.com/kwt.svg','image/svg','kwt.svg','0',NULL,'2019-11-11 18:57:34','2019-11-11 18:57:34'),(227,0,'https://genstone.s3.us-east-2.amazonaws.com/kgz.svg','Kyrgyzstan','https://genstone.s3.us-east-2.amazonaws.com/kgz.svg','image/svg','kgz.svg','0',NULL,'2019-11-11 18:57:35','2019-11-11 18:57:35'),(228,0,'https://genstone.s3.us-east-2.amazonaws.com/lao.svg','Lao People\'s Democratic Republic','https://genstone.s3.us-east-2.amazonaws.com/lao.svg','image/svg','lao.svg','0',NULL,'2019-11-11 18:57:35','2019-11-11 18:57:35'),(229,0,'https://genstone.s3.us-east-2.amazonaws.com/lva.svg','Latvia','https://genstone.s3.us-east-2.amazonaws.com/lva.svg','image/svg','lva.svg','0',NULL,'2019-11-11 18:57:36','2019-11-11 18:57:36'),(230,0,'https://genstone.s3.us-east-2.amazonaws.com/lbn.svg','Lebanon','https://genstone.s3.us-east-2.amazonaws.com/lbn.svg','image/svg','lbn.svg','0',NULL,'2019-11-11 18:57:36','2019-11-11 18:57:36'),(231,0,'https://genstone.s3.us-east-2.amazonaws.com/lso.svg','Lesotho','https://genstone.s3.us-east-2.amazonaws.com/lso.svg','image/svg','lso.svg','0',NULL,'2019-11-11 18:57:36','2019-11-11 18:57:36'),(232,0,'https://genstone.s3.us-east-2.amazonaws.com/lbr.svg','Liberia','https://genstone.s3.us-east-2.amazonaws.com/lbr.svg','image/svg','lbr.svg','0',NULL,'2019-11-11 18:57:36','2019-11-11 18:57:36'),(233,0,'https://genstone.s3.us-east-2.amazonaws.com/lby.svg','Libya','https://genstone.s3.us-east-2.amazonaws.com/lby.svg','image/svg','lby.svg','0',NULL,'2019-11-11 18:57:37','2019-11-11 18:57:37'),(234,0,'https://genstone.s3.us-east-2.amazonaws.com/lie.svg','Liechtenstein','https://genstone.s3.us-east-2.amazonaws.com/lie.svg','image/svg','lie.svg','0',NULL,'2019-11-11 18:57:37','2019-11-11 18:57:37'),(235,0,'https://genstone.s3.us-east-2.amazonaws.com/ltu.svg','Lithuania','https://genstone.s3.us-east-2.amazonaws.com/ltu.svg','image/svg','ltu.svg','0',NULL,'2019-11-11 18:57:37','2019-11-11 18:57:37'),(236,0,'https://genstone.s3.us-east-2.amazonaws.com/lux.svg','Luxembourg','https://genstone.s3.us-east-2.amazonaws.com/lux.svg','image/svg','lux.svg','0',NULL,'2019-11-11 18:57:38','2019-11-11 18:57:38'),(237,0,'https://genstone.s3.us-east-2.amazonaws.com/mac.svg','Macao','https://genstone.s3.us-east-2.amazonaws.com/mac.svg','image/svg','mac.svg','0',NULL,'2019-11-11 18:57:38','2019-11-11 18:57:38'),(238,0,'https://genstone.s3.us-east-2.amazonaws.com/mkd.svg','Macedonia (the former Yugoslav Republic of)','https://genstone.s3.us-east-2.amazonaws.com/mkd.svg','image/svg','mkd.svg','0',NULL,'2019-11-11 18:57:38','2019-11-11 18:57:38'),(239,0,'https://genstone.s3.us-east-2.amazonaws.com/mdg.svg','Madagascar','https://genstone.s3.us-east-2.amazonaws.com/mdg.svg','image/svg','mdg.svg','0',NULL,'2019-11-11 18:57:39','2019-11-11 18:57:39'),(240,0,'https://genstone.s3.us-east-2.amazonaws.com/mwi.svg','Malawi','https://genstone.s3.us-east-2.amazonaws.com/mwi.svg','image/svg','mwi.svg','0',NULL,'2019-11-11 18:57:39','2019-11-11 18:57:39'),(241,0,'https://genstone.s3.us-east-2.amazonaws.com/mys.svg','Malaysia','https://genstone.s3.us-east-2.amazonaws.com/mys.svg','image/svg','mys.svg','0',NULL,'2019-11-11 18:57:39','2019-11-11 18:57:39'),(242,0,'https://genstone.s3.us-east-2.amazonaws.com/mdv.svg','Maldives','https://genstone.s3.us-east-2.amazonaws.com/mdv.svg','image/svg','mdv.svg','0',NULL,'2019-11-11 18:57:40','2019-11-11 18:57:40'),(243,0,'https://genstone.s3.us-east-2.amazonaws.com/mli.svg','Mali','https://genstone.s3.us-east-2.amazonaws.com/mli.svg','image/svg','mli.svg','0',NULL,'2019-11-11 18:57:40','2019-11-11 18:57:40'),(244,0,'https://genstone.s3.us-east-2.amazonaws.com/mlt.svg','Malta','https://genstone.s3.us-east-2.amazonaws.com/mlt.svg','image/svg','mlt.svg','0',NULL,'2019-11-11 18:57:40','2019-11-11 18:57:40'),(245,0,'https://genstone.s3.us-east-2.amazonaws.com/mhl.svg','Marshall Islands','https://genstone.s3.us-east-2.amazonaws.com/mhl.svg','image/svg','mhl.svg','0',NULL,'2019-11-11 18:57:41','2019-11-11 18:57:41'),(246,0,'https://genstone.s3.us-east-2.amazonaws.com/mtq.svg','Martinique','https://genstone.s3.us-east-2.amazonaws.com/mtq.svg','image/svg','mtq.svg','0',NULL,'2019-11-11 18:57:41','2019-11-11 18:57:41'),(247,0,'https://genstone.s3.us-east-2.amazonaws.com/mrt.svg','Mauritania','https://genstone.s3.us-east-2.amazonaws.com/mrt.svg','image/svg','mrt.svg','0',NULL,'2019-11-11 18:57:42','2019-11-11 18:57:42'),(248,0,'https://genstone.s3.us-east-2.amazonaws.com/mus.svg','Mauritius','https://genstone.s3.us-east-2.amazonaws.com/mus.svg','image/svg','mus.svg','0',NULL,'2019-11-11 18:57:42','2019-11-11 18:57:42'),(249,0,'https://genstone.s3.us-east-2.amazonaws.com/myt.svg','Mayotte','https://genstone.s3.us-east-2.amazonaws.com/myt.svg','image/svg','myt.svg','0',NULL,'2019-11-11 18:57:42','2019-11-11 18:57:42'),(250,0,'https://genstone.s3.us-east-2.amazonaws.com/mex.svg','Mexico','https://genstone.s3.us-east-2.amazonaws.com/mex.svg','image/svg','mex.svg','0',NULL,'2019-11-11 18:57:44','2019-11-11 18:57:44'),(251,0,'https://genstone.s3.us-east-2.amazonaws.com/fsm.svg','Micronesia (Federated States of)','https://genstone.s3.us-east-2.amazonaws.com/fsm.svg','image/svg','fsm.svg','0',NULL,'2019-11-11 18:57:44','2019-11-11 18:57:44'),(252,0,'https://genstone.s3.us-east-2.amazonaws.com/mda.svg','Moldova (Republic of)','https://genstone.s3.us-east-2.amazonaws.com/mda.svg','image/svg','mda.svg','0',NULL,'2019-11-11 18:57:45','2019-11-11 18:57:45'),(253,0,'https://genstone.s3.us-east-2.amazonaws.com/mco.svg','Monaco','https://genstone.s3.us-east-2.amazonaws.com/mco.svg','image/svg','mco.svg','0',NULL,'2019-11-11 18:57:45','2019-11-11 18:57:45'),(254,0,'https://genstone.s3.us-east-2.amazonaws.com/mng.svg','Mongolia','https://genstone.s3.us-east-2.amazonaws.com/mng.svg','image/svg','mng.svg','0',NULL,'2019-11-11 18:57:46','2019-11-11 18:57:46'),(255,0,'https://genstone.s3.us-east-2.amazonaws.com/mne.svg','Montenegro','https://genstone.s3.us-east-2.amazonaws.com/mne.svg','image/svg','mne.svg','0',NULL,'2019-11-11 18:57:46','2019-11-11 18:57:46'),(256,0,'https://genstone.s3.us-east-2.amazonaws.com/msr.svg','Montserrat','https://genstone.s3.us-east-2.amazonaws.com/msr.svg','image/svg','msr.svg','0',NULL,'2019-11-11 18:57:47','2019-11-11 18:57:47'),(257,0,'https://genstone.s3.us-east-2.amazonaws.com/mar.svg','Morocco','https://genstone.s3.us-east-2.amazonaws.com/mar.svg','image/svg','mar.svg','0',NULL,'2019-11-11 18:57:47','2019-11-11 18:57:47'),(258,0,'https://genstone.s3.us-east-2.amazonaws.com/moz.svg','Mozambique','https://genstone.s3.us-east-2.amazonaws.com/moz.svg','image/svg','moz.svg','0',NULL,'2019-11-11 18:57:47','2019-11-11 18:57:47'),(259,0,'https://genstone.s3.us-east-2.amazonaws.com/mmr.svg','Myanmar','https://genstone.s3.us-east-2.amazonaws.com/mmr.svg','image/svg','mmr.svg','0',NULL,'2019-11-11 18:57:48','2019-11-11 18:57:48'),(260,0,'https://genstone.s3.us-east-2.amazonaws.com/nam.svg','Namibia','https://genstone.s3.us-east-2.amazonaws.com/nam.svg','image/svg','nam.svg','0',NULL,'2019-11-11 18:57:48','2019-11-11 18:57:48'),(261,0,'https://genstone.s3.us-east-2.amazonaws.com/nru.svg','Nauru','https://genstone.s3.us-east-2.amazonaws.com/nru.svg','image/svg','nru.svg','0',NULL,'2019-11-11 18:57:48','2019-11-11 18:57:48'),(262,0,'https://genstone.s3.us-east-2.amazonaws.com/npl.svg','Nepal','https://genstone.s3.us-east-2.amazonaws.com/npl.svg','image/svg','npl.svg','0',NULL,'2019-11-11 18:57:49','2019-11-11 18:57:49'),(263,0,'https://genstone.s3.us-east-2.amazonaws.com/nld.svg','Netherlands','https://genstone.s3.us-east-2.amazonaws.com/nld.svg','image/svg','nld.svg','0',NULL,'2019-11-11 18:57:49','2019-11-11 18:57:49'),(264,0,'https://genstone.s3.us-east-2.amazonaws.com/ncl.svg','New Caledonia','https://genstone.s3.us-east-2.amazonaws.com/ncl.svg','image/svg','ncl.svg','0',NULL,'2019-11-11 18:57:49','2019-11-11 18:57:49'),(265,0,'https://genstone.s3.us-east-2.amazonaws.com/nzl.svg','New Zealand','https://genstone.s3.us-east-2.amazonaws.com/nzl.svg','image/svg','nzl.svg','0',NULL,'2019-11-11 18:57:50','2019-11-11 18:57:50'),(266,0,'https://genstone.s3.us-east-2.amazonaws.com/nic.svg','Nicaragua','https://genstone.s3.us-east-2.amazonaws.com/nic.svg','image/svg','nic.svg','0',NULL,'2019-11-11 18:57:50','2019-11-11 18:57:50'),(267,0,'https://genstone.s3.us-east-2.amazonaws.com/ner.svg','Niger','https://genstone.s3.us-east-2.amazonaws.com/ner.svg','image/svg','ner.svg','0',NULL,'2019-11-11 18:57:51','2019-11-11 18:57:51'),(268,0,'https://genstone.s3.us-east-2.amazonaws.com/nga.svg','Nigeria','https://genstone.s3.us-east-2.amazonaws.com/nga.svg','image/svg','nga.svg','0',NULL,'2019-11-11 18:57:51','2019-11-11 18:57:51'),(269,0,'https://genstone.s3.us-east-2.amazonaws.com/niu.svg','Niue','https://genstone.s3.us-east-2.amazonaws.com/niu.svg','image/svg','niu.svg','0',NULL,'2019-11-11 18:57:51','2019-11-11 18:57:51'),(270,0,'https://genstone.s3.us-east-2.amazonaws.com/nfk.svg','Norfolk Island','https://genstone.s3.us-east-2.amazonaws.com/nfk.svg','image/svg','nfk.svg','0',NULL,'2019-11-11 18:57:52','2019-11-11 18:57:52'),(271,0,'https://genstone.s3.us-east-2.amazonaws.com/prk.svg','Korea (Democratic People\'s Republic of)','https://genstone.s3.us-east-2.amazonaws.com/prk.svg','image/svg','prk.svg','0',NULL,'2019-11-11 18:57:52','2019-11-11 18:57:52'),(272,0,'https://genstone.s3.us-east-2.amazonaws.com/mnp.svg','Northern Mariana Islands','https://genstone.s3.us-east-2.amazonaws.com/mnp.svg','image/svg','mnp.svg','0',NULL,'2019-11-11 18:57:52','2019-11-11 18:57:52'),(273,0,'https://genstone.s3.us-east-2.amazonaws.com/nor.svg','Norway','https://genstone.s3.us-east-2.amazonaws.com/nor.svg','image/svg','nor.svg','0',NULL,'2019-11-11 18:57:52','2019-11-11 18:57:52'),(274,0,'https://genstone.s3.us-east-2.amazonaws.com/omn.svg','Oman','https://genstone.s3.us-east-2.amazonaws.com/omn.svg','image/svg','omn.svg','0',NULL,'2019-11-11 18:57:53','2019-11-11 18:57:53'),(275,0,'https://genstone.s3.us-east-2.amazonaws.com/pak.svg','Pakistan','https://genstone.s3.us-east-2.amazonaws.com/pak.svg','image/svg','pak.svg','0',NULL,'2019-11-11 18:57:53','2019-11-11 18:57:53'),(276,0,'https://genstone.s3.us-east-2.amazonaws.com/plw.svg','Palau','https://genstone.s3.us-east-2.amazonaws.com/plw.svg','image/svg','plw.svg','0',NULL,'2019-11-11 18:57:54','2019-11-11 18:57:54'),(277,0,'https://genstone.s3.us-east-2.amazonaws.com/pse.svg','Palestine, State of','https://genstone.s3.us-east-2.amazonaws.com/pse.svg','image/svg','pse.svg','0',NULL,'2019-11-11 18:57:54','2019-11-11 18:57:54'),(278,0,'https://genstone.s3.us-east-2.amazonaws.com/pan.svg','Panama','https://genstone.s3.us-east-2.amazonaws.com/pan.svg','image/svg','pan.svg','0',NULL,'2019-11-11 18:57:54','2019-11-11 18:57:54'),(279,0,'https://genstone.s3.us-east-2.amazonaws.com/png.svg','Papua New Guinea','https://genstone.s3.us-east-2.amazonaws.com/png.svg','image/svg','png.svg','0',NULL,'2019-11-11 18:57:55','2019-11-11 18:57:55'),(280,0,'https://genstone.s3.us-east-2.amazonaws.com/pry.svg','Paraguay','https://genstone.s3.us-east-2.amazonaws.com/pry.svg','image/svg','pry.svg','0',NULL,'2019-11-11 18:57:55','2019-11-11 18:57:55'),(281,0,'https://genstone.s3.us-east-2.amazonaws.com/per.svg','Peru','https://genstone.s3.us-east-2.amazonaws.com/per.svg','image/svg','per.svg','0',NULL,'2019-11-11 18:57:55','2019-11-11 18:57:55'),(282,0,'https://genstone.s3.us-east-2.amazonaws.com/phl.svg','Philippines','https://genstone.s3.us-east-2.amazonaws.com/phl.svg','image/svg','phl.svg','0',NULL,'2019-11-11 18:57:56','2019-11-11 18:57:56'),(283,0,'https://genstone.s3.us-east-2.amazonaws.com/pcn.svg','Pitcairn','https://genstone.s3.us-east-2.amazonaws.com/pcn.svg','image/svg','pcn.svg','0',NULL,'2019-11-11 18:57:56','2019-11-11 18:57:56'),(284,0,'https://genstone.s3.us-east-2.amazonaws.com/pol.svg','Poland','https://genstone.s3.us-east-2.amazonaws.com/pol.svg','image/svg','pol.svg','0',NULL,'2019-11-11 18:57:56','2019-11-11 18:57:56'),(285,0,'https://genstone.s3.us-east-2.amazonaws.com/prt.svg','Portugal','https://genstone.s3.us-east-2.amazonaws.com/prt.svg','image/svg','prt.svg','0',NULL,'2019-11-11 18:57:57','2019-11-11 18:57:57'),(286,0,'https://genstone.s3.us-east-2.amazonaws.com/pri.svg','Puerto Rico','https://genstone.s3.us-east-2.amazonaws.com/pri.svg','image/svg','pri.svg','0',NULL,'2019-11-11 18:57:57','2019-11-11 18:57:57'),(287,0,'https://genstone.s3.us-east-2.amazonaws.com/qat.svg','Qatar','https://genstone.s3.us-east-2.amazonaws.com/qat.svg','image/svg','qat.svg','0',NULL,'2019-11-11 18:57:57','2019-11-11 18:57:57'),(288,0,'https://genstone.s3.us-east-2.amazonaws.com/kos.svg','Republic of Kosovo','https://genstone.s3.us-east-2.amazonaws.com/kos.svg','image/svg','kos.svg','0',NULL,'2019-11-11 18:57:58','2019-11-11 18:57:58'),(289,0,'https://genstone.s3.us-east-2.amazonaws.com/reu.svg','Réunion','https://genstone.s3.us-east-2.amazonaws.com/reu.svg','image/svg','reu.svg','0',NULL,'2019-11-11 18:57:58','2019-11-11 18:57:58'),(290,0,'https://genstone.s3.us-east-2.amazonaws.com/rou.svg','Romania','https://genstone.s3.us-east-2.amazonaws.com/rou.svg','image/svg','rou.svg','0',NULL,'2019-11-11 18:57:58','2019-11-11 18:57:58'),(291,0,'https://genstone.s3.us-east-2.amazonaws.com/rus.svg','Russian Federation','https://genstone.s3.us-east-2.amazonaws.com/rus.svg','image/svg','rus.svg','0',NULL,'2019-11-11 18:57:59','2019-11-11 18:57:59'),(292,0,'https://genstone.s3.us-east-2.amazonaws.com/rwa.svg','Rwanda','https://genstone.s3.us-east-2.amazonaws.com/rwa.svg','image/svg','rwa.svg','0',NULL,'2019-11-11 18:57:59','2019-11-11 18:57:59'),(293,0,'https://genstone.s3.us-east-2.amazonaws.com/blm.svg','Saint Barthélemy','https://genstone.s3.us-east-2.amazonaws.com/blm.svg','image/svg','blm.svg','0',NULL,'2019-11-11 18:58:00','2019-11-11 18:58:00'),(294,0,'https://genstone.s3.us-east-2.amazonaws.com/shn.svg','Saint Helena, Ascension and Tristan da Cunha','https://genstone.s3.us-east-2.amazonaws.com/shn.svg','image/svg','shn.svg','0',NULL,'2019-11-11 18:58:00','2019-11-11 18:58:00'),(295,0,'https://genstone.s3.us-east-2.amazonaws.com/kna.svg','Saint Kitts and Nevis','https://genstone.s3.us-east-2.amazonaws.com/kna.svg','image/svg','kna.svg','0',NULL,'2019-11-11 18:58:01','2019-11-11 18:58:01'),(296,0,'https://genstone.s3.us-east-2.amazonaws.com/lca.svg','Saint Lucia','https://genstone.s3.us-east-2.amazonaws.com/lca.svg','image/svg','lca.svg','0',NULL,'2019-11-11 18:58:01','2019-11-11 18:58:01'),(297,0,'https://genstone.s3.us-east-2.amazonaws.com/maf.svg','Saint Martin (French part)','https://genstone.s3.us-east-2.amazonaws.com/maf.svg','image/svg','maf.svg','0',NULL,'2019-11-11 18:58:01','2019-11-11 18:58:01'),(298,0,'https://genstone.s3.us-east-2.amazonaws.com/spm.svg','Saint Pierre and Miquelon','https://genstone.s3.us-east-2.amazonaws.com/spm.svg','image/svg','spm.svg','0',NULL,'2019-11-11 18:58:04','2019-11-11 18:58:04'),(299,0,'https://genstone.s3.us-east-2.amazonaws.com/vct.svg','Saint Vincent and the Grenadines','https://genstone.s3.us-east-2.amazonaws.com/vct.svg','image/svg','vct.svg','0',NULL,'2019-11-11 18:58:04','2019-11-11 18:58:04'),(300,0,'https://genstone.s3.us-east-2.amazonaws.com/wsm.svg','Samoa','https://genstone.s3.us-east-2.amazonaws.com/wsm.svg','image/svg','wsm.svg','0',NULL,'2019-11-11 18:58:05','2019-11-11 18:58:05'),(301,0,'https://genstone.s3.us-east-2.amazonaws.com/smr.svg','San Marino','https://genstone.s3.us-east-2.amazonaws.com/smr.svg','image/svg','smr.svg','0',NULL,'2019-11-11 18:58:08','2019-11-11 18:58:08'),(302,0,'https://genstone.s3.us-east-2.amazonaws.com/stp.svg','Sao Tome and Principe','https://genstone.s3.us-east-2.amazonaws.com/stp.svg','image/svg','stp.svg','0',NULL,'2019-11-11 18:58:08','2019-11-11 18:58:08'),(303,0,'https://genstone.s3.us-east-2.amazonaws.com/sau.svg','Saudi Arabia','https://genstone.s3.us-east-2.amazonaws.com/sau.svg','image/svg','sau.svg','0',NULL,'2019-11-11 18:58:08','2019-11-11 18:58:08'),(304,0,'https://genstone.s3.us-east-2.amazonaws.com/sen.svg','Senegal','https://genstone.s3.us-east-2.amazonaws.com/sen.svg','image/svg','sen.svg','0',NULL,'2019-11-11 18:58:09','2019-11-11 18:58:09'),(305,0,'https://genstone.s3.us-east-2.amazonaws.com/srb.svg','Serbia','https://genstone.s3.us-east-2.amazonaws.com/srb.svg','image/svg','srb.svg','0',NULL,'2019-11-11 18:58:10','2019-11-11 18:58:10'),(306,0,'https://genstone.s3.us-east-2.amazonaws.com/syc.svg','Seychelles','https://genstone.s3.us-east-2.amazonaws.com/syc.svg','image/svg','syc.svg','0',NULL,'2019-11-11 18:58:11','2019-11-11 18:58:11'),(307,0,'https://genstone.s3.us-east-2.amazonaws.com/sle.svg','Sierra Leone','https://genstone.s3.us-east-2.amazonaws.com/sle.svg','image/svg','sle.svg','0',NULL,'2019-11-11 18:58:12','2019-11-11 18:58:12'),(308,0,'https://genstone.s3.us-east-2.amazonaws.com/sgp.svg','Singapore','https://genstone.s3.us-east-2.amazonaws.com/sgp.svg','image/svg','sgp.svg','0',NULL,'2019-11-11 18:58:12','2019-11-11 18:58:12'),(309,0,'https://genstone.s3.us-east-2.amazonaws.com/sxm.svg','Sint Maarten (Dutch part)','https://genstone.s3.us-east-2.amazonaws.com/sxm.svg','image/svg','sxm.svg','0',NULL,'2019-11-11 18:58:15','2019-11-11 18:58:15'),(310,0,'https://genstone.s3.us-east-2.amazonaws.com/svk.svg','Slovakia','https://genstone.s3.us-east-2.amazonaws.com/svk.svg','image/svg','svk.svg','0',NULL,'2019-11-11 18:58:15','2019-11-11 18:58:15'),(311,0,'https://genstone.s3.us-east-2.amazonaws.com/svn.svg','Slovenia','https://genstone.s3.us-east-2.amazonaws.com/svn.svg','image/svg','svn.svg','0',NULL,'2019-11-11 18:58:16','2019-11-11 18:58:16'),(312,0,'https://genstone.s3.us-east-2.amazonaws.com/slb.svg','Solomon Islands','https://genstone.s3.us-east-2.amazonaws.com/slb.svg','image/svg','slb.svg','0',NULL,'2019-11-11 18:58:16','2019-11-11 18:58:16'),(313,0,'https://genstone.s3.us-east-2.amazonaws.com/som.svg','Somalia','https://genstone.s3.us-east-2.amazonaws.com/som.svg','image/svg','som.svg','0',NULL,'2019-11-11 18:58:17','2019-11-11 18:58:17'),(314,0,'https://genstone.s3.us-east-2.amazonaws.com/zaf.svg','South Africa','https://genstone.s3.us-east-2.amazonaws.com/zaf.svg','image/svg','zaf.svg','0',NULL,'2019-11-11 18:58:17','2019-11-11 18:58:17'),(315,0,'https://genstone.s3.us-east-2.amazonaws.com/sgs.svg','South Georgia and the South Sandwich Islands','https://genstone.s3.us-east-2.amazonaws.com/sgs.svg','image/svg','sgs.svg','0',NULL,'2019-11-11 18:58:18','2019-11-11 18:58:18'),(316,0,'https://genstone.s3.us-east-2.amazonaws.com/kor.svg','Korea (Republic of)','https://genstone.s3.us-east-2.amazonaws.com/kor.svg','image/svg','kor.svg','0',NULL,'2019-11-11 18:58:18','2019-11-11 18:58:18'),(317,0,'https://genstone.s3.us-east-2.amazonaws.com/ssd.svg','South Sudan','https://genstone.s3.us-east-2.amazonaws.com/ssd.svg','image/svg','ssd.svg','0',NULL,'2019-11-11 18:58:18','2019-11-11 18:58:18'),(318,0,'https://genstone.s3.us-east-2.amazonaws.com/esp.svg','Spain','https://genstone.s3.us-east-2.amazonaws.com/esp.svg','image/svg','esp.svg','0',NULL,'2019-11-11 18:58:19','2019-11-11 18:58:19'),(319,0,'https://genstone.s3.us-east-2.amazonaws.com/lka.svg','Sri Lanka','https://genstone.s3.us-east-2.amazonaws.com/lka.svg','image/svg','lka.svg','0',NULL,'2019-11-11 18:58:20','2019-11-11 18:58:20'),(320,0,'https://genstone.s3.us-east-2.amazonaws.com/sdn.svg','Sudan','https://genstone.s3.us-east-2.amazonaws.com/sdn.svg','image/svg','sdn.svg','0',NULL,'2019-11-11 18:58:20','2019-11-11 18:58:20'),(321,0,'https://genstone.s3.us-east-2.amazonaws.com/sur.svg','Suriname','https://genstone.s3.us-east-2.amazonaws.com/sur.svg','image/svg','sur.svg','0',NULL,'2019-11-11 18:58:20','2019-11-11 18:58:20'),(322,0,'https://genstone.s3.us-east-2.amazonaws.com/sjm.svg','Svalbard and Jan Mayen','https://genstone.s3.us-east-2.amazonaws.com/sjm.svg','image/svg','sjm.svg','0',NULL,'2019-11-11 18:58:21','2019-11-11 18:58:21'),(323,0,'https://genstone.s3.us-east-2.amazonaws.com/swz.svg','Swaziland','https://genstone.s3.us-east-2.amazonaws.com/swz.svg','image/svg','swz.svg','0',NULL,'2019-11-11 18:58:21','2019-11-11 18:58:21'),(324,0,'https://genstone.s3.us-east-2.amazonaws.com/swe.svg','Sweden','https://genstone.s3.us-east-2.amazonaws.com/swe.svg','image/svg','swe.svg','0',NULL,'2019-11-11 18:58:21','2019-11-11 18:58:21'),(325,0,'https://genstone.s3.us-east-2.amazonaws.com/che.svg','Switzerland','https://genstone.s3.us-east-2.amazonaws.com/che.svg','image/svg','che.svg','0',NULL,'2019-11-11 18:58:22','2019-11-11 18:58:22'),(326,0,'https://genstone.s3.us-east-2.amazonaws.com/syr.svg','Syrian Arab Republic','https://genstone.s3.us-east-2.amazonaws.com/syr.svg','image/svg','syr.svg','0',NULL,'2019-11-11 18:58:22','2019-11-11 18:58:22'),(327,0,'https://genstone.s3.us-east-2.amazonaws.com/twn.svg','Taiwan','https://genstone.s3.us-east-2.amazonaws.com/twn.svg','image/svg','twn.svg','0',NULL,'2019-11-11 18:58:22','2019-11-11 18:58:22'),(328,0,'https://genstone.s3.us-east-2.amazonaws.com/tjk.svg','Tajikistan','https://genstone.s3.us-east-2.amazonaws.com/tjk.svg','image/svg','tjk.svg','0',NULL,'2019-11-11 18:58:23','2019-11-11 18:58:23'),(329,0,'https://genstone.s3.us-east-2.amazonaws.com/tza.svg','Tanzania, United Republic of','https://genstone.s3.us-east-2.amazonaws.com/tza.svg','image/svg','tza.svg','0',NULL,'2019-11-11 18:58:23','2019-11-11 18:58:23'),(330,0,'https://genstone.s3.us-east-2.amazonaws.com/tha.svg','Thailand','https://genstone.s3.us-east-2.amazonaws.com/tha.svg','image/svg','tha.svg','0',NULL,'2019-11-11 18:58:23','2019-11-11 18:58:23'),(331,0,'https://genstone.s3.us-east-2.amazonaws.com/tls.svg','Timor-Leste','https://genstone.s3.us-east-2.amazonaws.com/tls.svg','image/svg','tls.svg','0',NULL,'2019-11-11 18:58:24','2019-11-11 18:58:24'),(332,0,'https://genstone.s3.us-east-2.amazonaws.com/tgo.svg','Togo','https://genstone.s3.us-east-2.amazonaws.com/tgo.svg','image/svg','tgo.svg','0',NULL,'2019-11-11 18:58:24','2019-11-11 18:58:24'),(333,0,'https://genstone.s3.us-east-2.amazonaws.com/tkl.svg','Tokelau','https://genstone.s3.us-east-2.amazonaws.com/tkl.svg','image/svg','tkl.svg','0',NULL,'2019-11-11 18:58:24','2019-11-11 18:58:24'),(334,0,'https://genstone.s3.us-east-2.amazonaws.com/ton.svg','Tonga','https://genstone.s3.us-east-2.amazonaws.com/ton.svg','image/svg','ton.svg','0',NULL,'2019-11-11 18:58:24','2019-11-11 18:58:24'),(335,0,'https://genstone.s3.us-east-2.amazonaws.com/tto.svg','Trinidad and Tobago','https://genstone.s3.us-east-2.amazonaws.com/tto.svg','image/svg','tto.svg','0',NULL,'2019-11-11 18:58:25','2019-11-11 18:58:25'),(336,0,'https://genstone.s3.us-east-2.amazonaws.com/tun.svg','Tunisia','https://genstone.s3.us-east-2.amazonaws.com/tun.svg','image/svg','tun.svg','0',NULL,'2019-11-11 18:58:25','2019-11-11 18:58:25'),(337,0,'https://genstone.s3.us-east-2.amazonaws.com/tur.svg','Turkey','https://genstone.s3.us-east-2.amazonaws.com/tur.svg','image/svg','tur.svg','0',NULL,'2019-11-11 18:58:25','2019-11-11 18:58:25'),(338,0,'https://genstone.s3.us-east-2.amazonaws.com/tkm.svg','Turkmenistan','https://genstone.s3.us-east-2.amazonaws.com/tkm.svg','image/svg','tkm.svg','0',NULL,'2019-11-11 18:58:26','2019-11-11 18:58:26'),(339,0,'https://genstone.s3.us-east-2.amazonaws.com/tca.svg','Turks and Caicos Islands','https://genstone.s3.us-east-2.amazonaws.com/tca.svg','image/svg','tca.svg','0',NULL,'2019-11-11 18:58:26','2019-11-11 18:58:26'),(340,0,'https://genstone.s3.us-east-2.amazonaws.com/tuv.svg','Tuvalu','https://genstone.s3.us-east-2.amazonaws.com/tuv.svg','image/svg','tuv.svg','0',NULL,'2019-11-11 18:58:27','2019-11-11 18:58:27'),(341,0,'https://genstone.s3.us-east-2.amazonaws.com/uga.svg','Uganda','https://genstone.s3.us-east-2.amazonaws.com/uga.svg','image/svg','uga.svg','0',NULL,'2019-11-11 18:58:27','2019-11-11 18:58:27'),(342,0,'https://genstone.s3.us-east-2.amazonaws.com/ukr.svg','Ukraine','https://genstone.s3.us-east-2.amazonaws.com/ukr.svg','image/svg','ukr.svg','0',NULL,'2019-11-11 18:58:27','2019-11-11 18:58:27'),(343,0,'https://genstone.s3.us-east-2.amazonaws.com/are.svg','United Arab Emirates','https://genstone.s3.us-east-2.amazonaws.com/are.svg','image/svg','are.svg','0',NULL,'2019-11-11 18:58:28','2019-11-11 18:58:28'),(344,0,'https://genstone.s3.us-east-2.amazonaws.com/gbr.svg','United Kingdom of Great Britain and Northern Ireland','https://genstone.s3.us-east-2.amazonaws.com/gbr.svg','image/svg','gbr.svg','0',NULL,'2019-11-11 18:58:28','2019-11-11 18:58:28'),(345,0,'https://genstone.s3.us-east-2.amazonaws.com/usa.svg','United States of America','https://genstone.s3.us-east-2.amazonaws.com/usa.svg','image/svg','usa.svg','0',NULL,'2019-11-11 18:58:29','2019-11-11 18:58:29'),(346,0,'https://genstone.s3.us-east-2.amazonaws.com/ury.svg','Uruguay','https://genstone.s3.us-east-2.amazonaws.com/ury.svg','image/svg','ury.svg','0',NULL,'2019-11-11 18:58:29','2019-11-11 18:58:29'),(347,0,'https://genstone.s3.us-east-2.amazonaws.com/uzb.svg','Uzbekistan','https://genstone.s3.us-east-2.amazonaws.com/uzb.svg','image/svg','uzb.svg','0',NULL,'2019-11-11 18:58:29','2019-11-11 18:58:29'),(348,0,'https://genstone.s3.us-east-2.amazonaws.com/vut.svg','Vanuatu','https://genstone.s3.us-east-2.amazonaws.com/vut.svg','image/svg','vut.svg','0',NULL,'2019-11-11 18:58:30','2019-11-11 18:58:30'),(349,0,'https://genstone.s3.us-east-2.amazonaws.com/ven.svg','Venezuela (Bolivarian Republic of)','https://genstone.s3.us-east-2.amazonaws.com/ven.svg','image/svg','ven.svg','0',NULL,'2019-11-11 18:58:30','2019-11-11 18:58:30'),(350,0,'https://genstone.s3.us-east-2.amazonaws.com/vnm.svg','Viet Nam','https://genstone.s3.us-east-2.amazonaws.com/vnm.svg','image/svg','vnm.svg','0',NULL,'2019-11-11 18:58:30','2019-11-11 18:58:30'),(351,0,'https://genstone.s3.us-east-2.amazonaws.com/wlf.svg','Wallis and Futuna','https://genstone.s3.us-east-2.amazonaws.com/wlf.svg','image/svg','wlf.svg','0',NULL,'2019-11-11 18:58:31','2019-11-11 18:58:31'),(352,0,'https://genstone.s3.us-east-2.amazonaws.com/esh.svg','Western Sahara','https://genstone.s3.us-east-2.amazonaws.com/esh.svg','image/svg','esh.svg','0',NULL,'2019-11-11 18:58:31','2019-11-11 18:58:31'),(353,0,'https://genstone.s3.us-east-2.amazonaws.com/yem.svg','Yemen','https://genstone.s3.us-east-2.amazonaws.com/yem.svg','image/svg','yem.svg','0',NULL,'2019-11-11 18:58:31','2019-11-11 18:58:31'),(354,0,'https://genstone.s3.us-east-2.amazonaws.com/zmb.svg','Zambia','https://genstone.s3.us-east-2.amazonaws.com/zmb.svg','image/svg','zmb.svg','0',NULL,'2019-11-11 18:58:32','2019-11-11 18:58:32'),(355,0,'https://genstone.s3.us-east-2.amazonaws.com/zwe.svg','Zimbabwe','https://genstone.s3.us-east-2.amazonaws.com/zwe.svg','image/svg','zwe.svg','0',NULL,'2019-11-11 18:58:32','2019-11-11 18:58:32');
/*!40000 ALTER TABLE `file` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `flightclass`
--

DROP TABLE IF EXISTS `flightclass`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `flightclass` (
  `flightclassid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `flightclassname` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `code` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`flightclassid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `flightclass`
--

LOCK TABLES `flightclass` WRITE;
/*!40000 ALTER TABLE `flightclass` DISABLE KEYS */;
/*!40000 ALTER TABLE `flightclass` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `goal`
--

DROP TABLE IF EXISTS `goal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `goal` (
  `goalid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userid` int(10) unsigned NOT NULL,
  `goaltypeid` int(10) unsigned NOT NULL,
  `flightclassid` int(10) unsigned DEFAULT NULL,
  `cityid` int(10) unsigned DEFAULT NULL,
  `airlineid` int(10) unsigned DEFAULT NULL,
  `hotelid` int(10) unsigned DEFAULT NULL,
  `regionid` int(10) unsigned DEFAULT NULL,
  `hotelclassid` int(10) unsigned DEFAULT NULL,
  `personcount` tinyint(4) DEFAULT '0',
  `daycount` tinyint(4) DEFAULT '0',
  `primary` tinyint(4) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`goalid`),
  KEY `fk_goal_airline1_idx` (`airlineid`),
  KEY `fk_goal_flightclass1_idx` (`flightclassid`),
  KEY `fk_goal_region1_idx` (`regionid`),
  KEY `fk_goal_hotelclass1_idx` (`hotelclassid`),
  KEY `fk_goal_city1_idx` (`cityid`),
  KEY `fk_goal_hotel1_idx` (`hotelid`),
  KEY `fk_goal_user1_idx` (`userid`),
  KEY `fk_goal_goaltype1_idx` (`goaltypeid`),
  CONSTRAINT `fk_goal_airline1_idx` FOREIGN KEY (`airlineid`) REFERENCES `airline` (`airlineid`),
  CONSTRAINT `fk_goal_city1_idx` FOREIGN KEY (`cityid`) REFERENCES `city` (`cityid`),
  CONSTRAINT `fk_goal_flightclass1_idx` FOREIGN KEY (`flightclassid`) REFERENCES `flightclass` (`flightclassid`),
  CONSTRAINT `fk_goal_goaltype1_idx` FOREIGN KEY (`goaltypeid`) REFERENCES `goaltype` (`goaltypeid`),
  CONSTRAINT `fk_goal_hotel1_idx` FOREIGN KEY (`hotelid`) REFERENCES `hotel` (`hotelid`),
  CONSTRAINT `fk_goal_hotelclass1_idx` FOREIGN KEY (`hotelclassid`) REFERENCES `hotelclass` (`hotelclassid`),
  CONSTRAINT `fk_goal_region1_idx` FOREIGN KEY (`regionid`) REFERENCES `region` (`regionid`),
  CONSTRAINT `fk_goal_user1_idx` FOREIGN KEY (`userid`) REFERENCES `user` (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `goal`
--

LOCK TABLES `goal` WRITE;
/*!40000 ALTER TABLE `goal` DISABLE KEYS */;
/*!40000 ALTER TABLE `goal` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `goal_creditcard`
--

DROP TABLE IF EXISTS `goal_creditcard`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `goal_creditcard` (
  `goalid` int(10) unsigned NOT NULL,
  `creditcardid` int(10) unsigned NOT NULL,
  PRIMARY KEY (`goalid`,`creditcardid`),
  KEY `fk_goal_creditcard_creditcard1_idx` (`creditcardid`),
  KEY `fk_goal_creditcard_goal1_idx` (`goalid`),
  CONSTRAINT `fk_goal_creditcard_creditcard1_idx` FOREIGN KEY (`creditcardid`) REFERENCES `creditcard` (`creditcardid`),
  CONSTRAINT `fk_goal_creditcard_goal1_idx` FOREIGN KEY (`goalid`) REFERENCES `goal` (`goalid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `goal_creditcard`
--

LOCK TABLES `goal_creditcard` WRITE;
/*!40000 ALTER TABLE `goal_creditcard` DISABLE KEYS */;
/*!40000 ALTER TABLE `goal_creditcard` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `goaltype`
--

DROP TABLE IF EXISTS `goaltype`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `goaltype` (
  `goaltypeid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `goalname` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`goaltypeid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `goaltype`
--

LOCK TABLES `goaltype` WRITE;
/*!40000 ALTER TABLE `goaltype` DISABLE KEYS */;
/*!40000 ALTER TABLE `goaltype` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hotel`
--

DROP TABLE IF EXISTS `hotel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `hotel` (
  `hotelid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `hotelname` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`hotelid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hotel`
--

LOCK TABLES `hotel` WRITE;
/*!40000 ALTER TABLE `hotel` DISABLE KEYS */;
/*!40000 ALTER TABLE `hotel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hotel_city`
--

DROP TABLE IF EXISTS `hotel_city`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `hotel_city` (
  `hotelid` int(10) unsigned NOT NULL,
  `cityid` int(10) unsigned NOT NULL,
  PRIMARY KEY (`hotelid`,`cityid`),
  KEY `fk_hotel_city_hotel1_idx` (`hotelid`),
  KEY `fk_hotel_city_city1_idx` (`cityid`),
  CONSTRAINT `fk_hotel_city_city1_idx` FOREIGN KEY (`cityid`) REFERENCES `city` (`cityid`),
  CONSTRAINT `fk_hotel_city_hotel1_idx` FOREIGN KEY (`hotelid`) REFERENCES `hotel` (`hotelid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hotel_city`
--

LOCK TABLES `hotel_city` WRITE;
/*!40000 ALTER TABLE `hotel_city` DISABLE KEYS */;
/*!40000 ALTER TABLE `hotel_city` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hotelclass`
--

DROP TABLE IF EXISTS `hotelclass`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `hotelclass` (
  `hotelclassid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `hotelclassname` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `code` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`hotelclassid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hotelclass`
--

LOCK TABLES `hotelclass` WRITE;
/*!40000 ALTER TABLE `hotelclass` DISABLE KEYS */;
/*!40000 ALTER TABLE `hotelclass` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_resets_table',1),(3,'2017_09_11_073942_create_userright_table',1),(4,'2017_09_11_074024_create_userrole_table',1),(5,'2017_09_11_074646_create_userrole_userright_table',1),(6,'2017_09_11_074659_create_user_userrole_table',1),(7,'2017_09_21_054015_create_useruserright_table',1),(8,'2019_03_04_000004_create_file_table',1),(9,'2019_03_13_000003_create_setting_table',1),(10,'2019_03_13_201655_create_user_roles',1),(11,'2019_11_04_000000_create_goaltype_table',1),(12,'2019_11_04_000001_create_hotelclass_table',1),(13,'2019_11_04_000002_create_network_table',1),(14,'2019_11_04_000003_create_rewardcurrency_table',1),(15,'2019_11_04_000004_create_hotel_table',1),(16,'2019_11_04_000005_create_spendcategory_table',1),(17,'2019_11_04_000006_create_program_table',1),(18,'2019_11_04_000009_create_flightclass_table',1),(19,'2019_11_04_000010_create_region_table',1),(20,'2019_11_04_000011_create_bank_table',1),(21,'2019_11_04_000012_create_airline_table',1),(22,'2019_11_04_000013_create_country_table',1),(23,'2019_11_04_000014_create_transaction_table',1),(24,'2019_11_04_000015_create_creditcard_table',1),(25,'2019_11_04_000016_create_program_rewardcurrency_table',1),(26,'2019_11_04_000017_create_city_table',1),(27,'2019_11_04_000018_create_reward_table',1),(28,'2019_11_04_000019_create_usercard_table',1),(29,'2019_11_04_000020_create_milecost_table',1),(30,'2019_11_04_000021_create_airline_city_table',1),(31,'2019_11_04_000022_create_hotel_city_table',1),(32,'2019_11_04_000023_create_goal_table',1),(33,'2019_11_04_000024_create_goal_creditcard_table',1),(35,'2019_11_05_033032_alter_airline_table_add_logo_file_id',2),(36,'2019_11_06_044627_alter_city_table_add_region_id',3),(37,'2019_11_12_193724_alter_country_table_add_regionid',4);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `milecost`
--

DROP TABLE IF EXISTS `milecost`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `milecost` (
  `milecostid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `regionid` int(10) unsigned NOT NULL,
  `cost` int(11) DEFAULT NULL,
  `hotelid` int(10) unsigned DEFAULT NULL,
  `hotelclassid` int(10) unsigned DEFAULT NULL,
  `cityid` int(10) unsigned DEFAULT NULL,
  `countryid` int(10) unsigned DEFAULT NULL,
  `flightclassid` int(10) unsigned DEFAULT NULL,
  `airlineid` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`milecostid`),
  KEY `fk_milecost_airline1_idx` (`airlineid`),
  KEY `fk_hotel_hotelclass_city1_idx` (`cityid`),
  KEY `fk_hotel_hotelclass_hotel1_idx` (`hotelid`),
  KEY `fk_hotel_hotelclass_region1_idx` (`regionid`),
  KEY `fk_hotel_hotelclass_hotelclass1_idx` (`hotelclassid`),
  KEY `fk_milecost_flightclass1_idx` (`flightclassid`),
  KEY `fk_hotel_hotelclass_country1_idx` (`countryid`),
  CONSTRAINT `fk_hotel_hotelclass_city1_idx` FOREIGN KEY (`cityid`) REFERENCES `city` (`cityid`),
  CONSTRAINT `fk_hotel_hotelclass_country1_idx` FOREIGN KEY (`countryid`) REFERENCES `country` (`countryid`),
  CONSTRAINT `fk_hotel_hotelclass_hotel1_idx` FOREIGN KEY (`hotelid`) REFERENCES `hotel` (`hotelid`),
  CONSTRAINT `fk_hotel_hotelclass_hotelclass1_idx` FOREIGN KEY (`hotelclassid`) REFERENCES `hotelclass` (`hotelclassid`),
  CONSTRAINT `fk_hotel_hotelclass_region1_idx` FOREIGN KEY (`regionid`) REFERENCES `region` (`regionid`),
  CONSTRAINT `fk_milecost_airline1_idx` FOREIGN KEY (`airlineid`) REFERENCES `airline` (`airlineid`),
  CONSTRAINT `fk_milecost_flightclass1_idx` FOREIGN KEY (`flightclassid`) REFERENCES `flightclass` (`flightclassid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `milecost`
--

LOCK TABLES `milecost` WRITE;
/*!40000 ALTER TABLE `milecost` DISABLE KEYS */;
/*!40000 ALTER TABLE `milecost` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `network`
--

DROP TABLE IF EXISTS `network`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `network` (
  `networkid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `networkname` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `networkcode` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`networkid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `network`
--

LOCK TABLES `network` WRITE;
/*!40000 ALTER TABLE `network` DISABLE KEYS */;
/*!40000 ALTER TABLE `network` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `program`
--

DROP TABLE IF EXISTS `program`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `program` (
  `programid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `programname` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`programid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `program`
--

LOCK TABLES `program` WRITE;
/*!40000 ALTER TABLE `program` DISABLE KEYS */;
/*!40000 ALTER TABLE `program` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `program_rewardcurrency`
--

DROP TABLE IF EXISTS `program_rewardcurrency`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `program_rewardcurrency` (
  `programid` int(10) unsigned NOT NULL,
  `rewardcurrencyid` int(10) unsigned NOT NULL,
  `ratio` decimal(2,2) DEFAULT NULL,
  PRIMARY KEY (`programid`,`rewardcurrencyid`),
  KEY `fk_program_rewardcurrency_program1_idx` (`programid`),
  KEY `fk_program_rewardcurrency_rewardcurrency1_idx` (`rewardcurrencyid`),
  CONSTRAINT `fk_program_rewardcurrency_program1_idx` FOREIGN KEY (`programid`) REFERENCES `program` (`programid`),
  CONSTRAINT `fk_program_rewardcurrency_rewardcurrency1_idx` FOREIGN KEY (`rewardcurrencyid`) REFERENCES `rewardcurrency` (`rewardcurrencyid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `program_rewardcurrency`
--

LOCK TABLES `program_rewardcurrency` WRITE;
/*!40000 ALTER TABLE `program_rewardcurrency` DISABLE KEYS */;
/*!40000 ALTER TABLE `program_rewardcurrency` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `region`
--

DROP TABLE IF EXISTS `region`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `region` (
  `regionid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `regiondescription` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`regionid`)
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `region`
--

LOCK TABLES `region` WRITE;
/*!40000 ALTER TABLE `region` DISABLE KEYS */;
INSERT INTO `region` VALUES (36,'Southern Asia'),(37,'Northern Europe'),(38,'Southern Europe'),(39,'Northern Africa'),(40,'Polynesia'),(41,'Middle Africa'),(42,'Caribbean'),(43,'South America'),(44,'Western Asia'),(45,'Australia and New Zealand'),(46,'Western Europe'),(47,'Eastern Europe'),(48,'Central America'),(49,'Western Africa'),(50,'Northern America'),(51,'Southern Africa'),(52,'Eastern Africa'),(53,'South-Eastern Asia'),(54,'Eastern Asia'),(55,'Melanesia'),(56,'Micronesia'),(57,'Central Asia');
/*!40000 ALTER TABLE `region` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reward`
--

DROP TABLE IF EXISTS `reward`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reward` (
  `rewardid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `precentage` decimal(2,2) DEFAULT NULL,
  `creditcardid` int(10) unsigned NOT NULL,
  `rewardcurrencyid` int(10) unsigned NOT NULL,
  `spendcategoryid` int(10) unsigned NOT NULL,
  PRIMARY KEY (`rewardid`),
  KEY `fk_reward_spendcategory1_idx` (`spendcategoryid`),
  KEY `fk_reward_rewardcurrency1_idx` (`rewardcurrencyid`),
  KEY `fk_reward_creditcard1_idx` (`creditcardid`),
  CONSTRAINT `fk_reward_creditcard1_idx` FOREIGN KEY (`creditcardid`) REFERENCES `creditcard` (`creditcardid`),
  CONSTRAINT `fk_reward_rewardcurrency1_idx` FOREIGN KEY (`rewardcurrencyid`) REFERENCES `rewardcurrency` (`rewardcurrencyid`),
  CONSTRAINT `fk_reward_spendcategory1_idx` FOREIGN KEY (`spendcategoryid`) REFERENCES `spendcategory` (`spendcategoryid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reward`
--

LOCK TABLES `reward` WRITE;
/*!40000 ALTER TABLE `reward` DISABLE KEYS */;
/*!40000 ALTER TABLE `reward` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rewardcurrency`
--

DROP TABLE IF EXISTS `rewardcurrency`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rewardcurrency` (
  `rewardcurrencyid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rewardcurrencyname` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` decimal(6,2) DEFAULT NULL,
  PRIMARY KEY (`rewardcurrencyid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rewardcurrency`
--

LOCK TABLES `rewardcurrency` WRITE;
/*!40000 ALTER TABLE `rewardcurrency` DISABLE KEYS */;
/*!40000 ALTER TABLE `rewardcurrency` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `setting`
--

DROP TABLE IF EXISTS `setting`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `setting` (
  `settingid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `settingvalue` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `settingname` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `settingcode` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ignore` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`settingid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `setting`
--

LOCK TABLES `setting` WRITE;
/*!40000 ALTER TABLE `setting` DISABLE KEYS */;
/*!40000 ALTER TABLE `setting` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `spendcategory`
--

DROP TABLE IF EXISTS `spendcategory`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `spendcategory` (
  `spendcategoryid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `spendcategoryname` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `code` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`spendcategoryid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `spendcategory`
--

LOCK TABLES `spendcategory` WRITE;
/*!40000 ALTER TABLE `spendcategory` DISABLE KEYS */;
/*!40000 ALTER TABLE `spendcategory` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transaction`
--

DROP TABLE IF EXISTS `transaction`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `transaction` (
  `transactionid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `amount` decimal(6,2) DEFAULT NULL,
  `spendcategoryid` int(10) unsigned NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`transactionid`),
  KEY `fk_transaction_spendcategory1_idx` (`spendcategoryid`),
  CONSTRAINT `fk_transaction_spendcategory1_idx` FOREIGN KEY (`spendcategoryid`) REFERENCES `spendcategory` (`spendcategoryid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transaction`
--

LOCK TABLES `transaction` WRITE;
/*!40000 ALTER TABLE `transaction` DISABLE KEYS */;
/*!40000 ALTER TABLE `transaction` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user` (
  `userid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`userid`),
  UNIQUE KEY `user_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'Werner Gerber','wernergerber264@gmail.com','$2y$10$daT40yPntOaBEMKfQRQSG.89ehMYmCQUwdvIEABX5DRsaLaybmoTG','EAgYyTjg5YvwK09uJGHnCM10ESSlnwDAbnnrcfhJ22CwOgFEbBt4u9rCpHOC','2017-11-01 12:00:00',NULL,NULL),(4,'Ryno Badenhorst','ryno.esli@gmail.com','$2y$10$lMailUcA0yOgFmsDCFaIBOHqw1MD28pZQETAfsdX.SOxB3M/E5vTW',NULL,'2019-11-04 22:00:00',NULL,NULL),(5,'Peet van der Westhuizen','peet@typedev.co.za','$2y$10$AgqX.7cWWHAcmE0/ueUy7ePiAQF1awqg0.l.rh2chhUf6XvZv5.UG',NULL,'2019-11-05 22:00:00',NULL,NULL),(6,'Merciale Erasmus','merciale@typedev.co.za','$2y$10$Fs4p2POfacPdD.GviS0XieDDHPmH5HFVry5sNj.PUFcjJJ81muJ..',NULL,'2019-11-06 22:00:00',NULL,NULL);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_userright`
--

DROP TABLE IF EXISTS `user_userright`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_userright` (
  `userrightid` int(10) unsigned NOT NULL,
  `userid` int(10) unsigned NOT NULL,
  KEY `user_userright_userrightid_foreign` (`userrightid`),
  KEY `user_userright_userid_foreign` (`userid`),
  CONSTRAINT `user_userright_userid_foreign` FOREIGN KEY (`userid`) REFERENCES `user` (`userid`) ON DELETE CASCADE,
  CONSTRAINT `user_userright_userrightid_foreign` FOREIGN KEY (`userrightid`) REFERENCES `userright` (`userrightid`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_userright`
--

LOCK TABLES `user_userright` WRITE;
/*!40000 ALTER TABLE `user_userright` DISABLE KEYS */;
INSERT INTO `user_userright` VALUES (1,4),(11,4);
/*!40000 ALTER TABLE `user_userright` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_userrole`
--

DROP TABLE IF EXISTS `user_userrole`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_userrole` (
  `userroleid` int(10) unsigned NOT NULL,
  `userid` int(10) unsigned NOT NULL,
  KEY `user_userrole_userroleid_foreign` (`userroleid`),
  KEY `user_userrole_userid_foreign` (`userid`),
  CONSTRAINT `user_userrole_userid_foreign` FOREIGN KEY (`userid`) REFERENCES `user` (`userid`) ON DELETE CASCADE,
  CONSTRAINT `user_userrole_userroleid_foreign` FOREIGN KEY (`userroleid`) REFERENCES `userrole` (`userroleid`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_userrole`
--

LOCK TABLES `user_userrole` WRITE;
/*!40000 ALTER TABLE `user_userrole` DISABLE KEYS */;
INSERT INTO `user_userrole` VALUES (1,1),(1,5),(1,6);
/*!40000 ALTER TABLE `user_userrole` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usercard`
--

DROP TABLE IF EXISTS `usercard`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usercard` (
  `usercardid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `expire_at` timestamp NULL DEFAULT NULL,
  `cancelled_at` timestamp NULL DEFAULT NULL,
  `userid` int(10) unsigned NOT NULL,
  `creditcardid` int(10) unsigned NOT NULL,
  `archived` tinyint(4) DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`usercardid`),
  KEY `fk_usercard_user1_idx` (`userid`),
  KEY `fk_usercard_creditcard1_idx` (`creditcardid`),
  CONSTRAINT `fk_usercard_creditcard1_idx` FOREIGN KEY (`creditcardid`) REFERENCES `creditcard` (`creditcardid`),
  CONSTRAINT `fk_usercard_user1_idx` FOREIGN KEY (`userid`) REFERENCES `user` (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usercard`
--

LOCK TABLES `usercard` WRITE;
/*!40000 ALTER TABLE `usercard` DISABLE KEYS */;
/*!40000 ALTER TABLE `usercard` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `userright`
--

DROP TABLE IF EXISTS `userright`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `userright` (
  `userrightid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rightname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rightslug` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`userrightid`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `userright`
--

LOCK TABLES `userright` WRITE;
/*!40000 ALTER TABLE `userright` DISABLE KEYS */;
INSERT INTO `userright` VALUES (1,'Setup','setup',NULL,NULL),(2,'Setting Management','setting_management',NULL,NULL),(3,'User Management','user_management',NULL,NULL),(4,'Credit Card Management','credit_card_management',NULL,NULL),(5,'Location Management','location_management',NULL,NULL),(6,'Reward Management','reward_management',NULL,NULL),(7,'Transaction Management','transaction_management',NULL,NULL),(8,'Goal Management','goal_management',NULL,NULL),(9,'Store Management','spend_management',NULL,NULL),(10,'Airline Management','airline_management',NULL,NULL),(11,'Bank Management','bank_management',NULL,NULL);
/*!40000 ALTER TABLE `userright` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `userrole`
--

DROP TABLE IF EXISTS `userrole`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `userrole` (
  `userroleid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rolename` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`userroleid`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `userrole`
--

LOCK TABLES `userrole` WRITE;
/*!40000 ALTER TABLE `userrole` DISABLE KEYS */;
INSERT INTO `userrole` VALUES (1,'Superuser',NULL,NULL),(2,'Admin',NULL,NULL);
/*!40000 ALTER TABLE `userrole` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `userrole_userright`
--

DROP TABLE IF EXISTS `userrole_userright`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `userrole_userright` (
  `userroleid` int(10) unsigned NOT NULL,
  `userrightid` int(10) unsigned NOT NULL,
  KEY `userrole_userright_userroleid_foreign` (`userroleid`),
  KEY `userrole_userright_userrightid_foreign` (`userrightid`),
  CONSTRAINT `userrole_userright_userrightid_foreign` FOREIGN KEY (`userrightid`) REFERENCES `userright` (`userrightid`) ON DELETE CASCADE,
  CONSTRAINT `userrole_userright_userroleid_foreign` FOREIGN KEY (`userroleid`) REFERENCES `userrole` (`userroleid`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `userrole_userright`
--

LOCK TABLES `userrole_userright` WRITE;
/*!40000 ALTER TABLE `userrole_userright` DISABLE KEYS */;
INSERT INTO `userrole_userright` VALUES (1,1),(1,2),(1,3),(1,4),(1,5),(1,6),(1,7),(1,8),(1,9),(1,11),(1,10);
/*!40000 ALTER TABLE `userrole_userright` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-11-12 22:08:05
