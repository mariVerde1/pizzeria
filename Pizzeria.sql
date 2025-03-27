CREATE DATABASE  IF NOT EXISTS `pizzeria` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `pizzeria`;
-- MySQL dump 10.13  Distrib 8.0.41, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: pizzeria
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
-- Table structure for table `bestellingen`
--

DROP TABLE IF EXISTS `bestellingen`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bestellingen` (
  `bestellingID` int NOT NULL AUTO_INCREMENT,
  `klantID` int NOT NULL,
  `datumTijd` datetime NOT NULL,
  PRIMARY KEY (`bestellingID`),
  KEY `klantID` (`klantID`),
  CONSTRAINT `bestellingen_ibfk_1` FOREIGN KEY (`klantID`) REFERENCES `klanten` (`klantID`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bestellingen`
--

LOCK TABLES `bestellingen` WRITE;
/*!40000 ALTER TABLE `bestellingen` DISABLE KEYS */;
INSERT INTO `bestellingen` VALUES (1,1,'2025-03-15 12:30:00'),(2,2,'2025-03-15 13:10:00'),(3,3,'2025-03-15 14:00:00');
/*!40000 ALTER TABLE `bestellingen` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bestellinglijnen`
--

DROP TABLE IF EXISTS `bestellinglijnen`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bestellinglijnen` (
  `bestellingLijnID` int NOT NULL AUTO_INCREMENT,
  `bestellingID` int NOT NULL,
  `pizzaID` int NOT NULL,
  `aantal` int NOT NULL,
  `prijsPerStuk` decimal(6,2) NOT NULL,
  `opmerking` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`bestellingLijnID`),
  KEY `bestellingID` (`bestellingID`),
  KEY `pizzaID` (`pizzaID`),
  CONSTRAINT `bestellinglijnen_ibfk_1` FOREIGN KEY (`bestellingID`) REFERENCES `bestellingen` (`bestellingID`) ON DELETE CASCADE,
  CONSTRAINT `bestellinglijnen_ibfk_2` FOREIGN KEY (`pizzaID`) REFERENCES `pizzas` (`pizzaID`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bestellinglijnen`
--

LOCK TABLES `bestellinglijnen` WRITE;
/*!40000 ALTER TABLE `bestellinglijnen` DISABLE KEYS */;
INSERT INTO `bestellinglijnen` VALUES (7,1,1,1,8.50,NULL),(8,1,2,1,10.00,NULL),(9,2,5,1,12.00,NULL),(10,2,7,1,13.00,NULL),(11,3,3,2,9.50,NULL),(12,3,6,1,11.50,NULL);
/*!40000 ALTER TABLE `bestellinglijnen` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `klanten`
--

DROP TABLE IF EXISTS `klanten`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `klanten` (
  `klantID` int NOT NULL AUTO_INCREMENT,
  `naam` varchar(50) NOT NULL,
  `voornaam` varchar(50) NOT NULL,
  `adres` varchar(100) NOT NULL,
  `postcode` varchar(10) NOT NULL,
  `gemeente` varchar(50) NOT NULL,
  `gsm` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `wachtwoord` varchar(255) DEFAULT NULL,
  `promotieRecht` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`klantID`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `klanten`
--

LOCK TABLES `klanten` WRITE;
/*!40000 ALTER TABLE `klanten` DISABLE KEYS */;
INSERT INTO `klanten` VALUES (1,'Janssen','Joe','Westouterstraat 16','8970','Poperinge','12345678','joe.janssen@example.com','7bdb867406014343d036c33421671556',1),(2,'Peeters','Marie','Meenseweg 100','8900','Ieper','23456789','marie.peeters@example.com','dbabfc9b49b6a213870d7145e3e0fe55',0),(3,'Vermeulen','Peter','Veurnestraat 152','8640','Oost-Vleteren','34567890','peter.vermeulen@example.com','1a489bf8653a66f9a1a813c5fa0e51d4',1),(4,'Menenso','Mario','Ketostraat 12','9000','Ieper','425148524','test@gmail.com','4091ecbd1684f6f050d7a089fa7eb3e4',1),(5,'VandeMeere','Jose','Groenestraat 12','9000','Ieper','425148527','Jose@test.com','515ad4cfb3cb3f01be2ae225bbc8617d',1),(6,'Mena','Ana','Ieperstraat 42','8908','Vlamertinge','125485523','anamena@example.com','ec6a6536ca304edf844d1d248a4f08dc',1),(10,'Mons','Anouck','Tempelstraat 49','8900','Ieper','125455555','anouckmons@example.com','ec6a6536ca304edf844d1d248a4f08dc',1),(11,'Menenso','pelota','jjjjjjj 2','8777','koko','254652','jojo@gmail.com','$2y$10$qaVnEmyfZvRHm/ohg7XKw.c13g45ZmdPPwIsGRj.uZ70uDAD3J2La',1),(12,'Dewaarder','Tom','jujustraat','5654','Ieper','65892225','Tom@example.com','$2y$10$OuAOISNO0fDIbQL7AVsao.tocrSHxOOoEUS7epBFkCw27NFkP6vfK',1),(14,'Dewaarder','Tom','jujustraat','5654','Ieper','65892225','juan@example.com','$2y$10$rTxOWvilMbMcv8TwrCtwP.MmSRL77CUrVd3p2ai0HSpBeS0AnZdHm',1),(16,'Komen','Rico','jujustraat','5654','Ieper','65892225','lucero@example.com','$2y$10$vLj7SWAssqPZ5zk10xGoze2IfqPVzE/eoOA0ala0NpEmWN/WctAF2',1),(18,'humen','Koen','lolostraat','8900','Ieper','65892225','humen@example.com','$2y$10$rU2h0PQGvC..GmED1V3CZua2Bu8KZ56ilTihvzFVgq7iwSJowJB9e',1),(19,'meno','Koen','lolostraat','8900','Ieper','65892225','meno@example.com','$2y$10$Z0geABFiFWgRR2i4GZwm4uM9XzcKMmBVfWDYu5riKAqq1zWlrL9yO',1),(20,'Lalala','Lelele','lilistraat12','9000','Ieper','0425148524','lala@test.com','$2y$10$hy6YPMZZ/HqL1D.N5dqZAOXIFXRrCwJ6vgrFm7TcSpEXrZAd4pEHm',1),(21,'Pitt','Brad','Pittstraat 6','9000','Ieper','21254325421','Pitt@test.com','$2y$10$NpVj4MG5cDvJD.RgUNFmjO5JKXgVTFAUnVfkfaNvFGxkrpAhjnlVy',1);
/*!40000 ALTER TABLE `klanten` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pizzas`
--

DROP TABLE IF EXISTS `pizzas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pizzas` (
  `pizzaID` int NOT NULL AUTO_INCREMENT,
  `naam` varchar(100) NOT NULL,
  `prijs` decimal(6,2) NOT NULL,
  `samenstelling` text,
  `beschikbaarheid` tinyint(1) DEFAULT '1',
  `promotiePrijs` decimal(6,2) DEFAULT NULL,
  PRIMARY KEY (`pizzaID`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pizzas`
--

LOCK TABLES `pizzas` WRITE;
/*!40000 ALTER TABLE `pizzas` DISABLE KEYS */;
INSERT INTO `pizzas` VALUES (1,'Margherita',8.50,'Tomatensaus, mozzarella, basilicum',1,NULL),(2,'Pepperoni',10.00,'Tomatensaus, mozzarella, pepperoni',1,9.00),(3,'Hawaii',9.50,'Tomatensaus, mozzarella, hesp, ananas',1,NULL),(4,'Quattro Formaggi',11.00,'Tomatensaus, mozzarella, gorgonzola, parmezaan, fontina',1,10.00),(5,'BBQ',12.00,'Tomatensaus, mozzarella, hesp, kip, Bbq-saus, paprika',1,11.00),(6,'Quattro Stagioni',12.00,'Tomatensaus, mozzarella, Kerstomaten, ham, rucola, champignon, olijven, artisjok',1,11.50),(7,'Speciale',13.00,'Tomatensaus, mozzarella, Kip, rund, Pepperoni, champignon, Paprika',1,NULL);
/*!40000 ALTER TABLE `pizzas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'pizzeria'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-03-26 22:37:27
