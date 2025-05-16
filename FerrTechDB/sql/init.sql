-- MySQL dump 10.13  Distrib 8.0.41, for Win64 (x86_64)
--
-- Host: localhost    Database: testrun_6
-- ------------------------------------------------------
-- Server version	8.0.41

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
-- Table structure for table `chemical_data`
--

DROP TABLE IF EXISTS `chemical_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `chemical_data` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `test_number` int NOT NULL,
  `added_order` int NOT NULL,
  `chemical_name` varchar(64) NOT NULL,
  `ml` decimal(6,2) DEFAULT NULL,
  `ph` decimal(6,2) DEFAULT NULL,
  `trpm` varchar(45) DEFAULT NULL,
  `project_id` int DEFAULT NULL,
  PRIMARY KEY (`ID`,`test_number`),
  KEY `project_chemical_idx` (`project_id`),
  CONSTRAINT `project_chemical` FOREIGN KEY (`project_id`) REFERENCES `project_data` (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `chemical_data`
--

LOCK TABLES `chemical_data` WRITE;
/*!40000 ALTER TABLE `chemical_data` DISABLE KEYS */;
INSERT INTO `chemical_data` VALUES (13,1,1,'Sodium ferrate (VI)',0.05,8.40,'10*250',4),(14,1,2,'C-497',2.00,0.00,'',4),(15,2,1,'Sodium ferrate (VI)',0.05,8.50,'',4),(16,2,2,'Bcfloc',1.00,0.00,'',4),(17,3,1,'Sodium ferrate (VI)',0.05,8.40,'10*250',4),(18,3,2,'C-492',2.00,0.00,'',4),(19,4,1,'Sodium ferrate (VI)',0.05,8.50,'10*250',4),(20,4,2,'SD-7081',2.00,0.00,'',4),(21,5,1,'Sodium ferrate (VI)',0.05,8.60,'10*250',4),(22,5,2,'A1820',2.00,0.00,'',4),(23,6,1,'Sodium ferrate (VI)',0.05,8.60,'10*250',4),(24,6,2,'A150',2.00,0.00,'',4),(25,7,1,'Sodium ferrate (VI)',0.05,8.60,'10*250',4),(26,7,2,'A100',2.00,0.00,'',4),(27,8,1,'FeCl3',0.30,6.00,'5*250',4),(28,8,2,'Sodium ferrate (VI)',0.05,6.46,'5*250',4),(29,8,3,'Bcfloc',1.00,0.00,'',4),(30,1,1,'Sodium ferrate (VI)',0.05,8.40,'10*250',5),(31,1,2,'FeCl3',0.30,8.60,'5*250',5),(32,1,3,'C-497',2.00,0.00,'',5),(33,1,4,'A150',1.00,0.00,'',5),(34,1,5,'A100',1.00,0.00,'',5),(35,2,1,'Sodium ferrate (VI)',1.00,8.60,'10*250',5),(36,2,2,'FeCl3',2.00,0.00,'',5),(37,3,1,'Poly',3.00,32.00,'',5),(38,3,2,'KH2PO4',12.00,0.00,'',5),(39,2,1,'H2SO4',0.00,0.00,'',5),(40,2,2,'H2SO4',0.00,0.00,'',5),(41,2,3,'H2SO4',0.00,0.00,'',5),(42,2,4,'H2SO4',0.00,0.00,'',5),(45,5,1,'H2SO4',23.00,0.00,'',5),(46,5,2,'',0.00,0.00,'',5),(47,5,3,'GAC',43.00,0.00,'',5),(48,7,1,'H2SO4',0.00,0.00,'',5),(49,7,2,'',0.00,0.00,'',5),(50,7,3,'VTA/VAT',0.00,0.00,'',5),(51,1,1,'H2SO4',1.00,1.00,'10250',24),(52,1,2,'Poly',0.00,0.00,'0',24),(53,1,1,'APG',1.00,1.00,'10250',24),(54,1,2,'KFerSol',0.00,0.00,'0',24),(55,1,1,'FeCl3',1.00,1.00,'10250',24),(56,1,2,'FerSol',0.00,0.00,'0',24),(57,1,1,'FerSol',1.00,8.00,'10*250',26),(58,1,2,'Poly',3.00,0.00,'',26),(59,1,3,'',0.00,0.00,'',26),(60,1,4,'M40',2.00,0.00,'',26),(61,1,5,'HCl',1.00,0.00,'',26),(62,1,1,'HClO',1.00,2.00,'10250',5),(63,1,1,'M40',2.00,3.00,'10250',30);
/*!40000 ALTER TABLE `chemical_data` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cod_training`
--

DROP TABLE IF EXISTS `cod_training`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cod_training` (
  `Sector` varchar(265) DEFAULT NULL,
  `cod_before` float NOT NULL,
  `chem1` varchar(265) DEFAULT NULL,
  `chem1_dose` float DEFAULT NULL,
  `chem2` varchar(245) DEFAULT NULL,
  `chem2_dose` float DEFAULT NULL,
  `chem3` varchar(245) DEFAULT NULL,
  `chem3_dose` float DEFAULT NULL,
  `chem4` varchar(245) DEFAULT NULL,
  `chem4_dose` float DEFAULT NULL,
  `chem5` varchar(245) DEFAULT NULL,
  `chem5_dose` float DEFAULT NULL,
  `chem6` varchar(245) DEFAULT NULL,
  `chem6_dose` float DEFAULT NULL,
  `chem7` varchar(245) DEFAULT NULL,
  `chem7_dose` float DEFAULT NULL,
  `chem8` varchar(245) DEFAULT NULL,
  `chem8_dose` float DEFAULT NULL,
  `chem9` varchar(245) DEFAULT NULL,
  `chem9_dose` float DEFAULT NULL,
  `chem10` varchar(245) DEFAULT NULL,
  `chem10_dose` float DEFAULT NULL,
  `cod_after` float DEFAULT NULL,
  PRIMARY KEY (`cod_before`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cod_training`
--

LOCK TABLES `cod_training` WRITE;
/*!40000 ALTER TABLE `cod_training` DISABLE KEYS */;
INSERT INTO `cod_training` VALUES ('Farming',10,'FerSol',0.15,'PAC',0,'Poly',3,'',0,'',0,'',0,'',0,'',0,'',0,'',0,10),('Wastewater',18.3,'H2SO4',0.5,'FeCl3',1,'NaOH',2.5,'FerSol',0.1,'Poly',2,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,46.5),('Water treatment',19.165,'FerSol',0.075,'H2SO4',0.28,'PAC',0.05,'NaOH',0.03,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,7.989),('Food processing',31.6,'H2SO4',0.5,'FerSol',0.1,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,33.3),('Food processing',37.2,'FeCl3',0.05,'H2SO4',0.45,'FerSol',0.05,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,31.1),('RWZI',53.74,'FeCl3',0.25,'Poly',0.5,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,43.89),('Others',73.1,'PAC',0.2,'FerSol',0.2,'Poly',0.5,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,25.8),('PFAS',109,'H2SO4',3.6,'FeCl3',0.3,'FerSol',0.7,'Poly',1,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,124),('PFAS',141,'H2SO4',1.45,'FeCl3',0.35,'FerSol',0.4,'Poly',1.5,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,10.7),('Metal',159,'H2SO4',0.25,'FerSol',0.2,'NaOH',0.1,'Poly',0.4,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,5.22),('Chemical',160,'FeCl3',0.15,'FerSol',0.2,'NaOH',1.5,'Poly',2,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,130),('Dairy',721,'FeCl3',1,'FerSol',0.05,'NaOH',2,'Poly',2,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,81),('Dairy',839,'FeCl3',1,'FerSol',0.05,'NaOH',0.1,'Poly',1,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,72.6),('Washing',980,'PAC',0.2,'FerSol',0.1,'Poly',1,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,621),('PFAS',1056,'H2SO4',1.8,'FerSol',0.2,'H2O2',0.2,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,1078),('Food processing',1363,'FerSol',0.1,'Poly',1,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,1163),('Dairy',1380,'FeCl3',0.05,'FerSol',0.05,'Poly',1,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,1094),('Wastewater',1537,'H2SO4',1.2,'FerSol',0.2,'Poly',0.5,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,1502),('Farming',2050,'FerSol',0.15,'PAC',NULL,'Poly',3,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,750),('Paper',2714,'FeSO4',0.05,'FerSol',0.2,'Poly',0.5,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,3169),('Dairy',3010,'H2SO4',1.5,'FerSol',0.2,'Poly',0.5,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,32.1),('Food processing',3374,'PAC',1,'FerSol',0.25,'Poly',1,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,738),('Dairy',4339,'FeCl3',0.25,'NaOH',0.4,'Poly',2,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,1910),('Wastewater',4347,'FerSol',0.1,'NaOH',21,'FeCl3',10,'Poly',3,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,2193),('Food processing',4710,'H2SO4',1,'FeCl3',1,'FerSol',0.25,'CaOH',10,'Poly',1,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,720),('Plastic',4829,'PAC',0.2,'Poly',1,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,4648),('Wastewater',5140,'H2SO4',11,'FeCl3',1,'FerSol',0.5,'NaOH',7,'Poly',2,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,2762),('Plastic',10180,'PAC',0.2,'Poly',1,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,6758),('Food processing',10430,'FerSol',0.25,'FeCl3',0.5,'Poly',1,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,5594),('Food processing',11132,'FeSO4',30,'FerSol',0.25,'Poly',1,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,4661),('Food processing',11153,'FerSol',0.5,'Poly',2,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,11170),('Food processing',14500,'H2SO4',20,'FerSol',0.5,'NaOH',3.95,'Poly',2,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,11000),('Wastewater',18981,'H2SO4',25,'FeCl3',0.5,'FerSol',0.15,'NaOH',50,'Poly',2,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,8085),('Wastewater',25220,'FeCl3',1.14,'FeCl3',0.73,'FeCl3',5.45,'NaOH',2.2,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,3365),('Coating',31200,'PAC',1,'FerSol',0.5,'H2SO4',0.25,'Poly',0.5,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,2519),('Coating',32300,'FerSol',0.5,'PAC',1,'Poly',0.5,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,2919),('Chemical',51200,'Al2(SO4)3/Al(SO4)3',4,'Poly',2,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,46500),('Paper',88000,'PAC',0.2,'FerSol',0.2,'NaOH',10.4,'Poly',3,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,7000),('Paper',100000,'Al2(SO4)3/Al(SO4)3',0.5,'NaOH',5.5,'Poly',6,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,100000);
/*!40000 ALTER TABLE `cod_training` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customer_data`
--

DROP TABLE IF EXISTS `customer_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `customer_data` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `customer_name` varchar(64) NOT NULL,
  `company_name` varchar(64) NOT NULL,
  `address` varchar(256) DEFAULT NULL,
  `email` varchar(320) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customer_data`
--

LOCK TABLES `customer_data` WRITE;
/*!40000 ALTER TABLE `customer_data` DISABLE KEYS */;
INSERT INTO `customer_data` VALUES (2,'Julian Crediet','Rouveen Kaasspecialiteiten','Oude Rijksweg 395, 7954 GH Rouveen','J.crediet@rouveenkaas.nl','522298222'),(3,'Chen jia hui','Ferr-Tech','Villa Kalkoven, Steenwijkerstraatweg 98, 7942 HR Meppel','random@gmail.com','912874635'),(4,'kayla','nootnoot inc','noot noot village','noot@gmail.com','90104701'),(5,'morgan','rum','there','this@gmail.com','98173209381'),(6,'jason','Ferr-Tech','laan van de ','random@gmail.com','98173209381'),(7,'dude','Rouveen Kaasspecialiteiten','more','noot@gmail.com','90104701'),(8,'man','manily','dude village','man@gmail.com','894273'),(9,'the one','the one inc','over there','one@gmail.com','1'),(10,'Asano','cooking','this and there','cooking@gmail.com','13890421'),(11,'aaaaaaa','aaaaaaa','aaaaaaa','aaa@gmail.com','1231213'),(12,'stone','rocks inc','down under','rocks@gmail.com','12308092'),(13,'stone','rocks inc','down under','rocks@gmail.com','9024094'),(14,'stone','rocks inc','down under','rocks@gmail.com','9024094'),(15,'adam','eve','here','smith.chen1@student.nhlstenden.com','91903809131'),(16,'cqc','cqc','cqcq','random@gmail.com','91903809131'),(17,'this guy','that guy','there','rocks@gmail.com','9024094'),(18,'zzzz','zzz','zzz','J.crediet@rouveenkaas.nl','982098345'),(19,'ddd','ddd','ddd','J.crediet@rouveenkaas.nl','9024094'),(20,'xxx','xxx','xxx','J.crediet@rouveenkaas.nl','982098345'),(21,'ggg','ggg','ggg','rocks@gmail.com','9024094'),(22,'ppp','ppp','ppp','rocks@gmail.com','9024094');
/*!40000 ALTER TABLE `customer_data` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `project_data`
--

DROP TABLE IF EXISTS `project_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `project_data` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `project_name` varchar(128) NOT NULL,
  `sector` varchar(128) NOT NULL,
  `customer_id` int DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `customer_project_idx` (`customer_id`),
  CONSTRAINT `customer_project` FOREIGN KEY (`customer_id`) REFERENCES `customer_data` (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `project_data`
--

LOCK TABLES `project_data` WRITE;
/*!40000 ALTER TABLE `project_data` DISABLE KEYS */;
INSERT INTO `project_data` VALUES (4,'P21051-2 Kaasfabriek Rouveen','Dairy',2),(5,'P20251-1','Food',3),(6,'P21051-3','Food',4),(7,'P21051-3','Food',4),(8,'P20251-4','Food',4),(9,'P20251-5','Rocks',3),(10,'P20251-5','Rocks',3),(11,'P20251-5','Rocks',3),(12,'P20251-4','Dairy',4),(13,'P21051-6 Kaasfabriek Rouveen','Dairy',3),(14,'P21051-2 Kaasfabriek Rouveen','Rocks',3),(15,'P21051-31','Dairy',3),(16,'P21051-311','Dairy',3),(17,'P21051-2 Kaasfabriek Rouveen 2','Dairy',3),(18,'P21051-22 Kaasfabriek Rouveen','Dairy',2),(19,'P21051-24 Kaasfabriek Rouveen','Rocks',2),(20,'P20251-4','Dairy',5),(21,'P20251-4','Rocks',2),(22,'P21051-2 Kaasfabriek Rouveen','Rocks',3),(23,'P20251-420','framing',7),(24,'P20251-420','Rocks',3),(25,'P20251-460','Dairy',7),(26,'P20251-421','Washing',3),(27,'P20251-444','Chemical',4),(28,'P20251-1222','Chemical',7),(29,'P21051-2 Kaasfabriek Rouveen 3','Coating',16),(30,'P20251-41122','Chemical',22);
/*!40000 ALTER TABLE `project_data` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `target_data`
--

DROP TABLE IF EXISTS `target_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `target_data` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `target_order` int DEFAULT NULL,
  `target_name` varchar(64) NOT NULL,
  `initial_concentration` decimal(6,2) DEFAULT NULL,
  `project_id` int DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `project_target_idx` (`project_id`),
  CONSTRAINT `project_target` FOREIGN KEY (`project_id`) REFERENCES `project_data` (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `target_data`
--

LOCK TABLES `target_data` WRITE;
/*!40000 ALTER TABLE `target_data` DISABLE KEYS */;
INSERT INTO `target_data` VALUES (4,1,'t',75.80,4),(5,2,'COD',1018.00,4),(6,3,'chloride',0.00,4),(7,1,'t',87.50,5),(8,2,'COD',203.00,5),(9,1,'COD',3.00,17),(10,1,'COD',32.00,18),(11,1,'COD',23.00,19),(12,1,'t',21.00,20),(13,1,'COD',32.00,21),(14,1,'COD',21.00,22),(15,2,'t',2.00,22),(16,1,'COD',1.00,24),(17,2,'t',2.00,24),(18,1,'t',1.00,25),(19,2,'COD',2.00,25),(20,1,'t',123.00,26),(21,2,'COD',231.00,26),(22,1,'COD',112.00,27),(23,1,'COD',123.00,28),(24,1,'COD',123.00,29),(25,1,'COD',123.00,30);
/*!40000 ALTER TABLE `target_data` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `treatment_data`
--

DROP TABLE IF EXISTS `treatment_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `treatment_data` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `target_id` int DEFAULT NULL,
  `test_number` int DEFAULT NULL,
  `target_achieved` varchar(45) DEFAULT NULL,
  `concentration` decimal(6,2) DEFAULT NULL,
  `reduction` decimal(6,2) DEFAULT NULL,
  `chemical_id` int DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `target_treatment_idx` (`target_id`),
  KEY `chemical_treatment_idx` (`chemical_id`,`test_number`),
  CONSTRAINT `chemical_treatment` FOREIGN KEY (`chemical_id`, `test_number`) REFERENCES `chemical_data` (`ID`, `test_number`),
  CONSTRAINT `target_treatment` FOREIGN KEY (`target_id`) REFERENCES `target_data` (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `treatment_data`
--

LOCK TABLES `treatment_data` WRITE;
/*!40000 ALTER TABLE `treatment_data` DISABLE KEYS */;
INSERT INTO `treatment_data` VALUES (11,4,1,'no',34.40,54.00,NULL),(12,5,1,'',0.00,0.00,NULL),(13,6,1,'',0.00,0.00,NULL),(14,4,2,'',0.00,0.00,NULL),(15,5,2,'',0.00,0.00,NULL),(16,6,2,'',0.00,0.00,NULL),(17,4,3,'',0.00,0.00,NULL),(18,5,3,'',0.00,0.00,NULL),(19,6,3,'',0.00,0.00,NULL),(20,4,4,'',0.00,0.00,NULL),(21,5,4,'',0.00,0.00,NULL),(22,6,4,'',0.00,0.00,NULL),(23,4,5,'',0.00,0.00,NULL),(24,5,5,'',0.00,0.00,NULL),(25,6,5,'',0.00,0.00,NULL),(26,4,6,'',0.00,0.00,NULL),(27,5,6,'',0.00,0.00,NULL),(28,6,6,'',0.00,0.00,NULL),(29,4,7,'',0.00,0.00,NULL),(30,5,7,'',0.00,0.00,NULL),(31,6,7,'',0.00,0.00,NULL),(32,4,8,'no',0.62,99.00,NULL),(33,5,8,'',0.00,0.00,NULL),(34,6,8,'',0.00,0.00,NULL),(35,7,1,'no',34.00,42.00,NULL),(36,8,1,'yes',12.00,99.00,NULL),(37,7,2,'no',23.00,43.00,NULL),(38,8,2,'',0.00,0.00,NULL),(39,7,3,'no',2.00,1.00,NULL),(40,8,3,'',0.00,0.00,NULL),(41,7,2,'',0.00,0.00,NULL),(42,8,2,'',0.00,0.00,NULL),(44,7,5,'Yes',0.00,0.00,NULL),(45,8,5,'',0.00,0.00,NULL),(46,7,7,'',0.00,0.00,NULL),(47,8,7,'',0.00,0.00,NULL),(48,16,1,'No',1.00,1.00,NULL),(49,17,1,'',0.00,0.00,NULL),(50,20,1,'Yes',12.00,32.00,NULL),(51,21,1,'',0.00,0.00,NULL),(52,7,1,'No',1.00,2.00,NULL),(53,8,1,'',0.00,0.00,NULL),(54,25,1,'Yes',1.00,23.00,NULL);
/*!40000 ALTER TABLE `treatment_data` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-05-14 11:37:36
