-- MySQL dump 10.13  Distrib 8.0.27, for Win64 (x86_64)
--
-- Host: localhost    Database: reserva
-- ------------------------------------------------------
-- Server version	8.0.27

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
-- Table structure for table `cancha`
--

DROP TABLE IF EXISTS `cancha`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cancha` (
  `id_cancha` int NOT NULL AUTO_INCREMENT,
  `tipo_cancha` varchar(15) NOT NULL,
  `dim_cancha` varchar(15) DEFAULT NULL,
  `estado_cancha` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id_cancha`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cancha`
--

LOCK TABLES `cancha` WRITE;
/*!40000 ALTER TABLE `cancha` DISABLE KEYS */;
INSERT INTO `cancha` VALUES (1,'Futbol','16x38','Funcional');
/*!40000 ALTER TABLE `cancha` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categoria`
--

DROP TABLE IF EXISTS `categoria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categoria` (
  `id_categoria` int NOT NULL AUTO_INCREMENT,
  `nombre_categoria` varchar(45) NOT NULL,
  PRIMARY KEY (`id_categoria`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categoria`
--

LOCK TABLES `categoria` WRITE;
/*!40000 ALTER TABLE `categoria` DISABLE KEYS */;
INSERT INTO `categoria` VALUES (1,'General');
/*!40000 ALTER TABLE `categoria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cliente`
--

DROP TABLE IF EXISTS `cliente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cliente` (
  `id_cliente` int NOT NULL AUTO_INCREMENT,
  `nombre_cliente` varchar(145) NOT NULL,
  `ci_cliente` varchar(15) DEFAULT NULL,
  `celular_cliente` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`id_cliente`),
  UNIQUE KEY `ci_cliente_UNIQUE` (`ci_cliente`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cliente`
--

LOCK TABLES `cliente` WRITE;
/*!40000 ALTER TABLE `cliente` DISABLE KEYS */;
INSERT INTO `cliente` VALUES (1,'Nadie','Sin Carnet',''),(2,'Daniel Choque Terrazas','11952211','7930021'),(3,'Miguel Angel Lopez Castro','47832112','6971122');
/*!40000 ALTER TABLE `cliente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `detalle_venta`
--

DROP TABLE IF EXISTS `detalle_venta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `detalle_venta` (
  `id_detalle_venta` int NOT NULL AUTO_INCREMENT,
  `id_ventas` int NOT NULL,
  `id_producto` int NOT NULL,
  `total_producto` float NOT NULL,
  `cant_venta` float NOT NULL,
  PRIMARY KEY (`id_detalle_venta`),
  KEY `fk_detalle_venta_venta1_idx` (`id_ventas`),
  KEY `fk_detalle_venta_producto1_idx` (`id_producto`),
  CONSTRAINT `fk_detalle_venta_producto1` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`),
  CONSTRAINT `fk_detalle_venta_venta1` FOREIGN KEY (`id_ventas`) REFERENCES `venta` (`id_ventas`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detalle_venta`
--

LOCK TABLES `detalle_venta` WRITE;
/*!40000 ALTER TABLE `detalle_venta` DISABLE KEYS */;
INSERT INTO `detalle_venta` VALUES (1,1,1,11,1),(2,2,3,8,1),(3,3,1,11,1),(4,4,4,4,2);
/*!40000 ALTER TABLE `detalle_venta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `empleado`
--

DROP TABLE IF EXISTS `empleado`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `empleado` (
  `id_empleado` int NOT NULL AUTO_INCREMENT,
  `nombre_empleado` varchar(75) NOT NULL,
  `telefono_empleado` varchar(15) DEFAULT NULL,
  `usuario_empleado` varchar(45) DEFAULT NULL,
  `pass_empleado` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id_empleado`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `empleado`
--

LOCK TABLES `empleado` WRITE;
/*!40000 ALTER TABLE `empleado` DISABLE KEYS */;
INSERT INTO `empleado` VALUES (1,'Carlos Nogales Villaroel','7478522','Carlos2022@gmail.com','123456');
/*!40000 ALTER TABLE `empleado` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `producto`
--

DROP TABLE IF EXISTS `producto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `producto` (
  `id_producto` int NOT NULL AUTO_INCREMENT,
  `id_categoria` int NOT NULL,
  `nombre_producto` varchar(145) NOT NULL,
  `descripcion_producto` varchar(75) DEFAULT NULL,
  `stock_producto` int NOT NULL,
  `precio_venta` float NOT NULL,
  `precio_compra` float DEFAULT NULL,
  `por_paquete` tinyint DEFAULT NULL,
  PRIMARY KEY (`id_producto`),
  KEY `fk_pruductos_categorias1_idx` (`id_categoria`),
  CONSTRAINT `fk_pruductos_categorias1` FOREIGN KEY (`id_categoria`) REFERENCES `categoria` (`id_categoria`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `producto`
--

LOCK TABLES `producto` WRITE;
/*!40000 ALTER TABLE `producto` DISABLE KEYS */;
INSERT INTO `producto` VALUES (1,1,'2 Litros (2000 ml) - NO RETORNABLE','Coca Cola Original',6,11,8.52,0),(2,1,'Ades (1 Litro)',NULL,8,10,8,1),(3,1,'Activate 600 ml','Isotonica',6,8,4.7,NULL),(4,1,'Supermini (190 ml)','Fanta Papaya',24,2,1.11,NULL),(5,1,'Papa Queso Cheedar 130 gr','prueba',10,15,12.01,NULL),(6,1,'Mineragua (2 litros) - NO RETORNABLE','',6,10,7.81,NULL);
/*!40000 ALTER TABLE `producto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reserva`
--

DROP TABLE IF EXISTS `reserva`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reserva` (
  `id_reserva` int NOT NULL AUTO_INCREMENT,
  `id_cancha` int NOT NULL,
  `id_empleado` int DEFAULT NULL,
  `id_cliente` int DEFAULT NULL,
  `fecha_reserva` date NOT NULL,
  `dia_reserva` enum('lunes','martes','miercoles','jueves','viernes','sabado','domingo') NOT NULL,
  `precio_hora` float NOT NULL,
  `hora_reserva` varchar(15) NOT NULL,
  `estado_reserva` enum('reservado','disponible','cerrado') NOT NULL,
  PRIMARY KEY (`id_reserva`),
  KEY `fk_reservas_cancha1_idx` (`id_cancha`),
  KEY `fk_reservas_empleados1_idx` (`id_empleado`),
  KEY `fk_reservas_clientes1_idx` (`id_cliente`),
  CONSTRAINT `fk_reservas_cancha1` FOREIGN KEY (`id_cancha`) REFERENCES `cancha` (`id_cancha`),
  CONSTRAINT `fk_reservas_clientes1` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id_cliente`),
  CONSTRAINT `fk_reservas_empleados1` FOREIGN KEY (`id_empleado`) REFERENCES `empleado` (`id_empleado`)
) ENGINE=InnoDB AUTO_INCREMENT=371 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reserva`
--

LOCK TABLES `reserva` WRITE;
/*!40000 ALTER TABLE `reserva` DISABLE KEYS */;
INSERT INTO `reserva` VALUES (2,1,NULL,NULL,'2022-07-29','viernes',90,'9:00','disponible'),(3,1,NULL,NULL,'2022-07-29','viernes',90,'10:00','disponible'),(4,1,NULL,NULL,'2022-07-29','viernes',90,'11:00','disponible'),(5,1,NULL,NULL,'2022-07-29','viernes',90,'12:00','disponible'),(6,1,NULL,NULL,'2022-07-29','viernes',90,'13:00','disponible'),(7,1,NULL,NULL,'2022-07-29','viernes',90,'14:00','disponible'),(8,1,NULL,NULL,'2022-07-29','viernes',90,'15:00','disponible'),(9,1,NULL,NULL,'2022-07-29','viernes',90,'16:00','disponible'),(10,1,NULL,NULL,'2022-07-29','viernes',90,'17:00','disponible'),(11,1,NULL,NULL,'2022-07-29','viernes',90,'18:00','disponible'),(12,1,NULL,NULL,'2022-07-29','viernes',90,'19:00','disponible'),(13,1,NULL,NULL,'2022-07-29','viernes',90,'20:00','disponible'),(14,1,NULL,NULL,'2022-07-29','viernes',90,'21:00','disponible'),(15,1,NULL,NULL,'2022-07-29','viernes',90,'22:00','disponible'),(16,1,NULL,NULL,'2022-07-30','sabado',90,'9:00','disponible'),(17,1,NULL,NULL,'2022-07-30','sabado',90,'10:00','disponible'),(18,1,NULL,NULL,'2022-07-30','sabado',90,'11:00','disponible'),(19,1,NULL,NULL,'2022-07-30','sabado',90,'12:00','disponible'),(20,1,NULL,NULL,'2022-07-30','sabado',90,'13:00','disponible'),(21,1,NULL,NULL,'2022-07-30','sabado',90,'14:00','disponible'),(22,1,NULL,NULL,'2022-07-30','sabado',90,'15:00','disponible'),(23,1,NULL,NULL,'2022-07-30','sabado',90,'16:00','disponible'),(24,1,NULL,2,'2022-07-30','sabado',90,'17:00','disponible'),(25,1,NULL,1,'2022-07-30','sabado',90,'18:00','disponible'),(26,1,NULL,1,'2022-07-30','sabado',90,'19:00','disponible'),(27,1,NULL,NULL,'2022-07-31','domingo',90,'9:00','disponible'),(28,1,NULL,2,'2022-07-31','domingo',90,'10:00','disponible'),(29,1,NULL,2,'2022-07-31','domingo',90,'11:00','disponible'),(30,1,NULL,3,'2022-07-31','domingo',90,'12:00','disponible'),(31,1,NULL,NULL,'2022-07-31','domingo',90,'13:00','disponible'),(32,1,NULL,NULL,'2022-08-01','lunes',90,'9:00','disponible'),(33,1,NULL,2,'2022-08-01','lunes',90,'10:00','reservado'),(34,1,NULL,2,'2022-08-01','lunes',90,'11:00','reservado'),(35,1,NULL,3,'2022-08-01','lunes',90,'12:00','reservado'),(36,1,NULL,NULL,'2022-08-01','lunes',90,'13:00','disponible'),(37,1,NULL,NULL,'2022-08-01','lunes',90,'14:00','disponible'),(38,1,NULL,NULL,'2022-08-01','lunes',90,'15:00','disponible'),(39,1,NULL,NULL,'2022-08-01','lunes',90,'16:00','disponible'),(40,1,NULL,NULL,'2022-08-01','lunes',90,'17:00','disponible'),(41,1,NULL,NULL,'2022-08-01','lunes',90,'18:00','disponible'),(42,1,NULL,NULL,'2022-08-01','lunes',90,'19:00','disponible'),(43,1,NULL,NULL,'2022-08-01','lunes',90,'20:00','disponible'),(44,1,NULL,NULL,'2022-08-01','lunes',90,'21:00','disponible'),(45,1,NULL,NULL,'2022-08-01','lunes',90,'22:00','disponible'),(46,1,NULL,NULL,'2022-08-02','martes',90,'9:00','disponible'),(47,1,NULL,2,'2022-08-02','martes',90,'10:00','reservado'),(48,1,NULL,NULL,'2022-08-02','martes',90,'11:00','disponible'),(49,1,NULL,NULL,'2022-08-02','martes',90,'12:00','disponible'),(50,1,NULL,NULL,'2022-08-02','martes',90,'13:00','disponible'),(51,1,NULL,NULL,'2022-08-02','martes',90,'14:00','disponible'),(52,1,NULL,NULL,'2022-08-02','martes',90,'15:00','disponible'),(53,1,NULL,NULL,'2022-08-02','martes',90,'16:00','disponible'),(54,1,NULL,NULL,'2022-08-02','martes',90,'17:00','disponible'),(55,1,NULL,NULL,'2022-08-02','martes',90,'18:00','disponible'),(56,1,NULL,NULL,'2022-08-02','martes',90,'19:00','disponible'),(57,1,NULL,NULL,'2022-08-02','martes',90,'20:00','disponible'),(58,1,NULL,NULL,'2022-08-02','martes',90,'21:00','disponible'),(59,1,NULL,NULL,'2022-08-02','martes',90,'22:00','disponible'),(60,1,NULL,NULL,'2022-08-03','miercoles',90,'9:00','disponible'),(61,1,NULL,NULL,'2022-08-03','miercoles',90,'10:00','disponible'),(62,1,NULL,NULL,'2022-08-03','miercoles',90,'11:00','disponible'),(63,1,NULL,NULL,'2022-08-03','miercoles',90,'12:00','disponible'),(64,1,NULL,NULL,'2022-08-03','miercoles',90,'13:00','disponible'),(65,1,NULL,NULL,'2022-08-03','miercoles',90,'14:00','disponible'),(66,1,NULL,NULL,'2022-08-03','miercoles',90,'15:00','disponible'),(67,1,NULL,NULL,'2022-08-03','miercoles',90,'16:00','disponible'),(68,1,NULL,NULL,'2022-08-03','miercoles',90,'17:00','disponible'),(69,1,NULL,NULL,'2022-08-03','miercoles',90,'18:00','disponible'),(70,1,NULL,NULL,'2022-08-03','miercoles',90,'19:00','disponible'),(71,1,NULL,NULL,'2022-08-03','miercoles',90,'20:00','disponible'),(72,1,NULL,NULL,'2022-08-03','miercoles',90,'21:00','disponible'),(73,1,NULL,NULL,'2022-08-03','miercoles',90,'22:00','disponible'),(74,1,NULL,NULL,'2022-08-04','jueves',90,'9:00','disponible'),(75,1,NULL,NULL,'2022-08-04','jueves',90,'10:00','disponible'),(76,1,NULL,NULL,'2022-08-04','jueves',90,'11:00','disponible'),(77,1,NULL,NULL,'2022-08-04','jueves',90,'12:00','disponible'),(78,1,NULL,NULL,'2022-08-04','jueves',90,'13:00','disponible'),(79,1,NULL,NULL,'2022-08-04','jueves',90,'14:00','disponible'),(80,1,NULL,NULL,'2022-08-04','jueves',90,'15:00','disponible'),(81,1,NULL,NULL,'2022-08-04','jueves',90,'16:00','disponible'),(82,1,NULL,NULL,'2022-08-04','jueves',90,'17:00','disponible'),(83,1,NULL,NULL,'2022-08-04','jueves',90,'18:00','disponible'),(84,1,NULL,NULL,'2022-08-04','jueves',90,'19:00','disponible'),(85,1,NULL,NULL,'2022-08-04','jueves',90,'20:00','disponible'),(86,1,NULL,NULL,'2022-08-04','jueves',90,'21:00','disponible'),(87,1,NULL,NULL,'2022-08-04','jueves',90,'22:00','disponible'),(88,1,NULL,NULL,'2022-08-05','viernes',90,'9:00','disponible'),(89,1,NULL,NULL,'2022-08-05','viernes',90,'10:00','disponible'),(90,1,NULL,NULL,'2022-08-05','viernes',90,'11:00','disponible'),(91,1,NULL,NULL,'2022-08-05','viernes',90,'12:00','disponible'),(92,1,NULL,NULL,'2022-08-05','viernes',90,'13:00','disponible'),(93,1,NULL,NULL,'2022-08-05','viernes',90,'14:00','disponible'),(94,1,NULL,NULL,'2022-08-05','viernes',90,'15:00','disponible'),(95,1,NULL,NULL,'2022-08-05','viernes',90,'16:00','disponible'),(96,1,NULL,NULL,'2022-08-05','viernes',90,'17:00','disponible'),(97,1,NULL,NULL,'2022-08-05','viernes',90,'18:00','disponible'),(98,1,NULL,NULL,'2022-08-05','viernes',90,'19:00','disponible'),(99,1,NULL,NULL,'2022-08-05','viernes',90,'20:00','disponible'),(100,1,NULL,NULL,'2022-08-05','viernes',90,'21:00','disponible'),(101,1,NULL,NULL,'2022-08-05','viernes',90,'22:00','disponible'),(102,1,NULL,NULL,'2022-08-06','sabado',90,'9:00','disponible'),(103,1,NULL,NULL,'2022-08-06','sabado',90,'10:00','disponible'),(104,1,NULL,NULL,'2022-08-06','sabado',90,'11:00','disponible'),(105,1,NULL,NULL,'2022-08-06','sabado',90,'12:00','disponible'),(106,1,NULL,NULL,'2022-08-06','sabado',90,'13:00','disponible'),(107,1,NULL,NULL,'2022-08-06','sabado',90,'14:00','disponible'),(108,1,NULL,NULL,'2022-08-06','sabado',90,'15:00','disponible'),(109,1,NULL,NULL,'2022-08-06','sabado',90,'16:00','disponible'),(110,1,NULL,NULL,'2022-08-06','sabado',90,'17:00','disponible'),(111,1,NULL,NULL,'2022-08-06','sabado',90,'18:00','disponible'),(112,1,NULL,NULL,'2022-08-06','sabado',90,'19:00','disponible'),(113,1,NULL,NULL,'2022-08-07','domingo',90,'9:00','disponible'),(114,1,NULL,NULL,'2022-08-07','domingo',90,'10:00','disponible'),(115,1,NULL,NULL,'2022-08-07','domingo',90,'11:00','disponible'),(116,1,NULL,NULL,'2022-08-07','domingo',90,'12:00','disponible'),(117,1,NULL,NULL,'2022-08-07','domingo',90,'13:00','disponible'),(118,1,NULL,NULL,'2022-08-08','lunes',90,'9:00','disponible'),(119,1,NULL,NULL,'2022-08-08','lunes',90,'10:00','disponible'),(120,1,NULL,NULL,'2022-08-08','lunes',90,'11:00','disponible'),(121,1,NULL,NULL,'2022-08-08','lunes',90,'12:00','disponible'),(122,1,NULL,NULL,'2022-08-08','lunes',90,'13:00','disponible'),(123,1,NULL,NULL,'2022-08-08','lunes',90,'14:00','disponible'),(124,1,NULL,NULL,'2022-08-08','lunes',90,'15:00','disponible'),(125,1,NULL,NULL,'2022-08-08','lunes',90,'16:00','disponible'),(126,1,NULL,NULL,'2022-08-08','lunes',90,'17:00','disponible'),(127,1,NULL,NULL,'2022-08-08','lunes',90,'18:00','disponible'),(128,1,NULL,NULL,'2022-08-08','lunes',90,'19:00','disponible'),(129,1,NULL,NULL,'2022-08-08','lunes',90,'20:00','disponible'),(130,1,NULL,NULL,'2022-08-08','lunes',90,'21:00','disponible'),(131,1,NULL,NULL,'2022-08-08','lunes',90,'22:00','disponible'),(132,1,NULL,NULL,'2022-08-09','martes',90,'9:00','disponible'),(133,1,NULL,NULL,'2022-08-09','martes',90,'10:00','disponible'),(134,1,NULL,NULL,'2022-08-09','martes',90,'11:00','disponible'),(135,1,NULL,NULL,'2022-08-09','martes',90,'12:00','disponible'),(136,1,NULL,NULL,'2022-08-09','martes',90,'13:00','disponible'),(137,1,NULL,NULL,'2022-08-09','martes',90,'14:00','disponible'),(138,1,NULL,NULL,'2022-08-09','martes',90,'15:00','disponible'),(139,1,NULL,NULL,'2022-08-09','martes',90,'16:00','disponible'),(140,1,NULL,NULL,'2022-08-09','martes',90,'17:00','disponible'),(141,1,NULL,NULL,'2022-08-09','martes',90,'18:00','disponible'),(142,1,NULL,NULL,'2022-08-09','martes',90,'19:00','disponible'),(143,1,NULL,NULL,'2022-08-09','martes',90,'20:00','disponible'),(144,1,NULL,NULL,'2022-08-09','martes',90,'21:00','disponible'),(145,1,NULL,NULL,'2022-08-09','martes',90,'22:00','disponible'),(146,1,NULL,NULL,'2022-08-10','miercoles',90,'9:00','disponible'),(147,1,NULL,NULL,'2022-08-10','miercoles',90,'10:00','disponible'),(148,1,NULL,NULL,'2022-08-10','miercoles',90,'11:00','disponible'),(149,1,NULL,NULL,'2022-08-10','miercoles',90,'12:00','disponible'),(150,1,NULL,NULL,'2022-08-10','miercoles',90,'13:00','disponible'),(151,1,NULL,NULL,'2022-08-10','miercoles',90,'14:00','disponible'),(152,1,NULL,NULL,'2022-08-10','miercoles',90,'15:00','disponible'),(153,1,NULL,NULL,'2022-08-10','miercoles',90,'16:00','disponible'),(154,1,NULL,NULL,'2022-08-10','miercoles',90,'17:00','disponible'),(155,1,NULL,NULL,'2022-08-10','miercoles',90,'18:00','disponible'),(156,1,NULL,NULL,'2022-08-10','miercoles',90,'19:00','disponible'),(157,1,NULL,NULL,'2022-08-10','miercoles',90,'20:00','disponible'),(158,1,NULL,NULL,'2022-08-10','miercoles',90,'21:00','disponible'),(159,1,NULL,NULL,'2022-08-10','miercoles',90,'22:00','disponible'),(160,1,NULL,NULL,'2022-08-11','jueves',90,'9:00','disponible'),(161,1,NULL,NULL,'2022-08-11','jueves',90,'10:00','disponible'),(162,1,NULL,NULL,'2022-08-11','jueves',90,'11:00','disponible'),(163,1,NULL,NULL,'2022-08-11','jueves',90,'12:00','disponible'),(164,1,NULL,NULL,'2022-08-11','jueves',90,'13:00','disponible'),(165,1,NULL,NULL,'2022-08-11','jueves',90,'14:00','disponible'),(166,1,NULL,NULL,'2022-08-11','jueves',90,'15:00','disponible'),(167,1,NULL,NULL,'2022-08-11','jueves',90,'16:00','disponible'),(168,1,NULL,NULL,'2022-08-11','jueves',90,'17:00','disponible'),(169,1,NULL,NULL,'2022-08-11','jueves',90,'18:00','disponible'),(170,1,NULL,NULL,'2022-08-11','jueves',90,'19:00','disponible'),(171,1,NULL,NULL,'2022-08-11','jueves',90,'20:00','disponible'),(172,1,NULL,NULL,'2022-08-11','jueves',90,'21:00','disponible'),(173,1,NULL,NULL,'2022-08-11','jueves',90,'22:00','disponible'),(174,1,NULL,NULL,'2022-08-12','viernes',90,'9:00','disponible'),(175,1,NULL,NULL,'2022-08-12','viernes',90,'10:00','disponible'),(176,1,NULL,NULL,'2022-08-12','viernes',90,'11:00','disponible'),(177,1,NULL,NULL,'2022-08-12','viernes',90,'12:00','disponible'),(178,1,NULL,NULL,'2022-08-12','viernes',90,'13:00','disponible'),(179,1,NULL,NULL,'2022-08-12','viernes',90,'14:00','disponible'),(180,1,NULL,NULL,'2022-08-12','viernes',90,'15:00','disponible'),(181,1,NULL,NULL,'2022-08-12','viernes',90,'16:00','disponible'),(182,1,NULL,NULL,'2022-08-12','viernes',90,'17:00','disponible'),(183,1,NULL,NULL,'2022-08-12','viernes',90,'18:00','disponible'),(184,1,NULL,NULL,'2022-08-12','viernes',90,'19:00','disponible'),(185,1,NULL,NULL,'2022-08-12','viernes',90,'20:00','disponible'),(186,1,NULL,NULL,'2022-08-12','viernes',90,'21:00','disponible'),(187,1,NULL,NULL,'2022-08-12','viernes',90,'22:00','disponible'),(188,1,NULL,NULL,'2022-08-13','sabado',90,'9:00','disponible'),(189,1,NULL,NULL,'2022-08-13','sabado',90,'10:00','disponible'),(190,1,NULL,NULL,'2022-08-13','sabado',90,'11:00','disponible'),(191,1,NULL,NULL,'2022-08-13','sabado',90,'12:00','disponible'),(192,1,NULL,NULL,'2022-08-13','sabado',90,'13:00','disponible'),(193,1,NULL,NULL,'2022-08-13','sabado',90,'14:00','disponible'),(194,1,NULL,NULL,'2022-08-13','sabado',90,'15:00','disponible'),(195,1,NULL,NULL,'2022-08-13','sabado',90,'16:00','disponible'),(196,1,NULL,NULL,'2022-08-13','sabado',90,'17:00','disponible'),(197,1,NULL,NULL,'2022-08-13','sabado',90,'18:00','disponible'),(198,1,NULL,NULL,'2022-08-13','sabado',90,'19:00','disponible'),(199,1,NULL,NULL,'2022-08-14','domingo',90,'9:00','disponible'),(200,1,NULL,NULL,'2022-08-14','domingo',90,'10:00','disponible'),(201,1,NULL,NULL,'2022-08-14','domingo',90,'11:00','disponible'),(202,1,NULL,NULL,'2022-08-14','domingo',90,'12:00','disponible'),(203,1,NULL,NULL,'2022-08-14','domingo',90,'13:00','disponible'),(204,1,NULL,NULL,'2022-08-15','lunes',90,'9:00','disponible'),(205,1,NULL,NULL,'2022-08-15','lunes',90,'10:00','disponible'),(206,1,NULL,NULL,'2022-08-15','lunes',90,'11:00','disponible'),(207,1,NULL,NULL,'2022-08-15','lunes',90,'12:00','disponible'),(208,1,NULL,NULL,'2022-08-15','lunes',90,'13:00','disponible'),(209,1,NULL,NULL,'2022-08-15','lunes',90,'14:00','disponible'),(210,1,NULL,NULL,'2022-08-15','lunes',90,'15:00','disponible'),(211,1,NULL,NULL,'2022-08-15','lunes',90,'16:00','disponible'),(212,1,NULL,NULL,'2022-08-15','lunes',90,'17:00','disponible'),(213,1,NULL,NULL,'2022-08-15','lunes',90,'18:00','disponible'),(214,1,NULL,NULL,'2022-08-15','lunes',90,'19:00','disponible'),(215,1,NULL,NULL,'2022-08-15','lunes',90,'20:00','disponible'),(216,1,NULL,NULL,'2022-08-15','lunes',90,'21:00','disponible'),(217,1,NULL,NULL,'2022-08-15','lunes',90,'22:00','disponible'),(218,1,NULL,NULL,'2022-08-16','martes',90,'9:00','disponible'),(219,1,NULL,NULL,'2022-08-16','martes',90,'10:00','disponible'),(220,1,NULL,NULL,'2022-08-16','martes',90,'11:00','disponible'),(221,1,NULL,NULL,'2022-08-16','martes',90,'12:00','disponible'),(222,1,NULL,NULL,'2022-08-16','martes',90,'13:00','disponible'),(223,1,NULL,NULL,'2022-08-16','martes',90,'14:00','disponible'),(224,1,NULL,NULL,'2022-08-16','martes',90,'15:00','disponible'),(225,1,NULL,NULL,'2022-08-16','martes',90,'16:00','disponible'),(226,1,NULL,NULL,'2022-08-16','martes',90,'17:00','disponible'),(227,1,NULL,NULL,'2022-08-16','martes',90,'18:00','disponible'),(228,1,NULL,NULL,'2022-08-16','martes',90,'19:00','disponible'),(229,1,NULL,NULL,'2022-08-16','martes',90,'20:00','disponible'),(230,1,NULL,NULL,'2022-08-16','martes',90,'21:00','disponible'),(231,1,NULL,NULL,'2022-08-16','martes',90,'22:00','disponible'),(232,1,NULL,NULL,'2022-08-17','miercoles',90,'9:00','disponible'),(233,1,NULL,NULL,'2022-08-17','miercoles',90,'10:00','disponible'),(234,1,NULL,NULL,'2022-08-17','miercoles',90,'11:00','disponible'),(235,1,NULL,NULL,'2022-08-17','miercoles',90,'12:00','disponible'),(236,1,NULL,NULL,'2022-08-17','miercoles',90,'13:00','disponible'),(237,1,NULL,NULL,'2022-08-17','miercoles',90,'14:00','disponible'),(238,1,NULL,NULL,'2022-08-17','miercoles',90,'15:00','disponible'),(239,1,NULL,NULL,'2022-08-17','miercoles',90,'16:00','disponible'),(240,1,NULL,NULL,'2022-08-17','miercoles',90,'17:00','disponible'),(241,1,NULL,NULL,'2022-08-17','miercoles',90,'18:00','disponible'),(242,1,NULL,NULL,'2022-08-17','miercoles',90,'19:00','disponible'),(243,1,NULL,NULL,'2022-08-17','miercoles',90,'20:00','disponible'),(244,1,NULL,NULL,'2022-08-17','miercoles',90,'21:00','disponible'),(245,1,NULL,NULL,'2022-08-17','miercoles',90,'22:00','disponible'),(246,1,NULL,NULL,'2022-08-18','jueves',90,'9:00','disponible'),(247,1,NULL,NULL,'2022-08-18','jueves',90,'10:00','disponible'),(248,1,NULL,NULL,'2022-08-18','jueves',90,'11:00','disponible'),(249,1,NULL,NULL,'2022-08-18','jueves',90,'12:00','disponible'),(250,1,NULL,NULL,'2022-08-18','jueves',90,'13:00','disponible'),(251,1,NULL,NULL,'2022-08-18','jueves',90,'14:00','disponible'),(252,1,NULL,NULL,'2022-08-18','jueves',90,'15:00','disponible'),(253,1,NULL,NULL,'2022-08-18','jueves',90,'16:00','disponible'),(254,1,NULL,NULL,'2022-08-18','jueves',90,'17:00','disponible'),(255,1,NULL,NULL,'2022-08-18','jueves',90,'18:00','disponible'),(256,1,NULL,NULL,'2022-08-18','jueves',90,'19:00','disponible'),(257,1,NULL,NULL,'2022-08-18','jueves',90,'20:00','disponible'),(258,1,NULL,NULL,'2022-08-18','jueves',90,'21:00','disponible'),(259,1,NULL,NULL,'2022-08-18','jueves',90,'22:00','disponible'),(260,1,NULL,NULL,'2022-08-19','viernes',90,'9:00','disponible'),(261,1,NULL,NULL,'2022-08-19','viernes',90,'10:00','disponible'),(262,1,NULL,NULL,'2022-08-19','viernes',90,'11:00','disponible'),(263,1,NULL,NULL,'2022-08-19','viernes',90,'12:00','disponible'),(264,1,NULL,NULL,'2022-08-19','viernes',90,'13:00','disponible'),(265,1,NULL,NULL,'2022-08-19','viernes',90,'14:00','disponible'),(266,1,NULL,NULL,'2022-08-19','viernes',90,'15:00','disponible'),(267,1,NULL,NULL,'2022-08-19','viernes',90,'16:00','disponible'),(268,1,NULL,NULL,'2022-08-19','viernes',90,'17:00','disponible'),(269,1,NULL,NULL,'2022-08-19','viernes',90,'18:00','disponible'),(270,1,NULL,NULL,'2022-08-19','viernes',90,'19:00','disponible'),(271,1,NULL,NULL,'2022-08-19','viernes',90,'20:00','disponible'),(272,1,NULL,NULL,'2022-08-19','viernes',90,'21:00','disponible'),(273,1,NULL,NULL,'2022-08-19','viernes',90,'22:00','disponible'),(274,1,NULL,NULL,'2022-08-20','sabado',90,'9:00','disponible'),(275,1,NULL,NULL,'2022-08-20','sabado',90,'10:00','disponible'),(276,1,NULL,NULL,'2022-08-20','sabado',90,'11:00','disponible'),(277,1,NULL,NULL,'2022-08-20','sabado',90,'12:00','disponible'),(278,1,NULL,NULL,'2022-08-20','sabado',90,'13:00','disponible'),(279,1,NULL,NULL,'2022-08-20','sabado',90,'14:00','disponible'),(280,1,NULL,NULL,'2022-08-20','sabado',90,'15:00','disponible'),(281,1,NULL,NULL,'2022-08-20','sabado',90,'16:00','disponible'),(282,1,NULL,NULL,'2022-08-20','sabado',90,'17:00','disponible'),(283,1,NULL,NULL,'2022-08-20','sabado',90,'18:00','disponible'),(284,1,NULL,NULL,'2022-08-20','sabado',90,'19:00','disponible'),(285,1,NULL,NULL,'2022-08-21','domingo',90,'9:00','disponible'),(286,1,NULL,NULL,'2022-08-21','domingo',90,'10:00','disponible'),(287,1,NULL,NULL,'2022-08-21','domingo',90,'11:00','disponible'),(288,1,NULL,NULL,'2022-08-21','domingo',90,'12:00','disponible'),(289,1,NULL,NULL,'2022-08-21','domingo',90,'13:00','disponible'),(290,1,NULL,NULL,'2022-08-22','lunes',90,'9:00','disponible'),(291,1,NULL,NULL,'2022-08-22','lunes',90,'10:00','disponible'),(292,1,NULL,NULL,'2022-08-22','lunes',90,'11:00','disponible'),(293,1,NULL,NULL,'2022-08-22','lunes',90,'12:00','disponible'),(294,1,NULL,NULL,'2022-08-22','lunes',90,'13:00','disponible'),(295,1,NULL,NULL,'2022-08-22','lunes',90,'14:00','disponible'),(296,1,NULL,NULL,'2022-08-22','lunes',90,'15:00','disponible'),(297,1,NULL,NULL,'2022-08-22','lunes',90,'16:00','disponible'),(298,1,NULL,NULL,'2022-08-22','lunes',90,'17:00','disponible'),(299,1,NULL,NULL,'2022-08-22','lunes',90,'18:00','disponible'),(300,1,NULL,NULL,'2022-08-22','lunes',90,'19:00','disponible'),(301,1,NULL,NULL,'2022-08-22','lunes',90,'20:00','disponible'),(302,1,NULL,NULL,'2022-08-22','lunes',90,'21:00','disponible'),(303,1,NULL,NULL,'2022-08-22','lunes',90,'22:00','disponible'),(304,1,NULL,NULL,'2022-08-23','martes',90,'9:00','disponible'),(305,1,NULL,NULL,'2022-08-23','martes',90,'10:00','disponible'),(306,1,NULL,NULL,'2022-08-23','martes',90,'11:00','disponible'),(307,1,NULL,NULL,'2022-08-23','martes',90,'12:00','disponible'),(308,1,NULL,NULL,'2022-08-23','martes',90,'13:00','disponible'),(309,1,NULL,NULL,'2022-08-23','martes',90,'14:00','disponible'),(310,1,NULL,NULL,'2022-08-23','martes',90,'15:00','disponible'),(311,1,NULL,NULL,'2022-08-23','martes',90,'16:00','disponible'),(312,1,NULL,NULL,'2022-08-23','martes',90,'17:00','disponible'),(313,1,NULL,NULL,'2022-08-23','martes',90,'18:00','disponible'),(314,1,NULL,NULL,'2022-08-23','martes',90,'19:00','disponible'),(315,1,NULL,NULL,'2022-08-23','martes',90,'20:00','disponible'),(316,1,NULL,NULL,'2022-08-23','martes',90,'21:00','disponible'),(317,1,NULL,NULL,'2022-08-23','martes',90,'22:00','disponible'),(318,1,NULL,NULL,'2022-08-24','miercoles',90,'9:00','disponible'),(319,1,NULL,NULL,'2022-08-24','miercoles',90,'10:00','disponible'),(320,1,NULL,NULL,'2022-08-24','miercoles',90,'11:00','disponible'),(321,1,NULL,NULL,'2022-08-24','miercoles',90,'12:00','disponible'),(322,1,NULL,NULL,'2022-08-24','miercoles',90,'13:00','disponible'),(323,1,NULL,NULL,'2022-08-24','miercoles',90,'14:00','disponible'),(324,1,NULL,NULL,'2022-08-24','miercoles',90,'15:00','disponible'),(325,1,NULL,NULL,'2022-08-24','miercoles',90,'16:00','disponible'),(326,1,NULL,NULL,'2022-08-24','miercoles',90,'17:00','disponible'),(327,1,NULL,NULL,'2022-08-24','miercoles',90,'18:00','disponible'),(328,1,NULL,NULL,'2022-08-24','miercoles',90,'19:00','disponible'),(329,1,NULL,NULL,'2022-08-24','miercoles',90,'20:00','disponible'),(330,1,NULL,NULL,'2022-08-24','miercoles',90,'21:00','disponible'),(331,1,NULL,NULL,'2022-08-24','miercoles',90,'22:00','disponible'),(332,1,NULL,NULL,'2022-08-25','jueves',90,'9:00','disponible'),(333,1,NULL,NULL,'2022-08-25','jueves',90,'10:00','disponible'),(334,1,NULL,NULL,'2022-08-25','jueves',90,'11:00','disponible'),(335,1,NULL,NULL,'2022-08-25','jueves',90,'12:00','disponible'),(336,1,NULL,NULL,'2022-08-25','jueves',90,'13:00','disponible'),(337,1,NULL,NULL,'2022-08-25','jueves',90,'14:00','disponible'),(338,1,NULL,NULL,'2022-08-25','jueves',90,'15:00','disponible'),(339,1,NULL,NULL,'2022-08-25','jueves',90,'16:00','disponible'),(340,1,NULL,NULL,'2022-08-25','jueves',90,'17:00','disponible'),(341,1,NULL,NULL,'2022-08-25','jueves',90,'18:00','disponible'),(342,1,NULL,NULL,'2022-08-25','jueves',90,'19:00','disponible'),(343,1,NULL,NULL,'2022-08-25','jueves',90,'20:00','disponible'),(344,1,NULL,NULL,'2022-08-25','jueves',90,'21:00','disponible'),(345,1,NULL,NULL,'2022-08-25','jueves',90,'22:00','disponible'),(346,1,NULL,NULL,'2022-08-26','viernes',90,'9:00','disponible'),(347,1,NULL,NULL,'2022-08-26','viernes',90,'10:00','disponible'),(348,1,NULL,NULL,'2022-08-26','viernes',90,'11:00','disponible'),(349,1,NULL,NULL,'2022-08-26','viernes',90,'12:00','disponible'),(350,1,NULL,NULL,'2022-08-26','viernes',90,'13:00','disponible'),(351,1,NULL,NULL,'2022-08-26','viernes',90,'14:00','disponible'),(352,1,NULL,NULL,'2022-08-26','viernes',90,'15:00','disponible'),(353,1,NULL,NULL,'2022-08-26','viernes',90,'16:00','disponible'),(354,1,NULL,NULL,'2022-08-26','viernes',90,'17:00','disponible'),(355,1,NULL,NULL,'2022-08-26','viernes',90,'18:00','disponible'),(356,1,NULL,NULL,'2022-08-26','viernes',90,'19:00','disponible'),(357,1,NULL,NULL,'2022-08-26','viernes',90,'20:00','disponible'),(358,1,NULL,NULL,'2022-08-26','viernes',90,'21:00','disponible'),(359,1,NULL,NULL,'2022-08-26','viernes',90,'22:00','disponible'),(360,1,NULL,NULL,'2022-08-27','sabado',90,'9:00','disponible'),(361,1,NULL,NULL,'2022-08-27','sabado',90,'10:00','disponible'),(362,1,NULL,NULL,'2022-08-27','sabado',90,'11:00','disponible'),(363,1,NULL,NULL,'2022-08-27','sabado',90,'12:00','disponible'),(364,1,NULL,NULL,'2022-08-27','sabado',90,'13:00','disponible'),(365,1,NULL,NULL,'2022-08-27','sabado',90,'14:00','disponible'),(366,1,NULL,NULL,'2022-08-27','sabado',90,'15:00','disponible'),(367,1,NULL,NULL,'2022-08-27','sabado',90,'16:00','disponible'),(368,1,NULL,NULL,'2022-08-27','sabado',90,'17:00','disponible'),(369,1,NULL,NULL,'2022-08-27','sabado',90,'18:00','disponible'),(370,1,NULL,NULL,'2022-08-27','sabado',90,'19:00','disponible');
/*!40000 ALTER TABLE `reserva` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `venta`
--

DROP TABLE IF EXISTS `venta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `venta` (
  `id_ventas` int NOT NULL AUTO_INCREMENT,
  `id_empleado` int NOT NULL,
  `id_cliente` int DEFAULT NULL,
  `fecha_venta` datetime NOT NULL,
  `total_venta` float NOT NULL,
  PRIMARY KEY (`id_ventas`),
  KEY `fk_ventas_empleados1_idx` (`id_empleado`),
  KEY `fk_ventas_clientes1_idx` (`id_cliente`),
  CONSTRAINT `fk_ventas_clientes1` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id_cliente`),
  CONSTRAINT `fk_ventas_empleados1` FOREIGN KEY (`id_empleado`) REFERENCES `empleado` (`id_empleado`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `venta`
--

LOCK TABLES `venta` WRITE;
/*!40000 ALTER TABLE `venta` DISABLE KEYS */;
INSERT INTO `venta` VALUES (1,1,2,'2022-07-29 12:10:05',11),(2,1,3,'2022-07-30 14:54:25',8),(3,1,NULL,'2022-07-30 18:10:10',11),(4,1,3,'2022-07-31 15:30:32',4);
/*!40000 ALTER TABLE `venta` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-08-01  2:08:46
