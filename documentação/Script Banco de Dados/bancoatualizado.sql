-- MySQL dump 10.13  Distrib 5.6.24, for osx10.8 (x86_64)
--
-- Host: 127.0.0.1    Database: freepass
-- ------------------------------------------------------
-- Server version	5.6.25

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `feriados`
--

DROP TABLE IF EXISTS `feriados`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `feriados` (
  `idferiado` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) DEFAULT NULL,
  `data` datetime NOT NULL,
  PRIMARY KEY (`idferiado`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `horarios`
--

DROP TABLE IF EXISTS `horarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `horarios` (
  `idhorario` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) DEFAULT NULL,
  `horainicio` datetime NOT NULL,
  `horafim` datetime NOT NULL,
  `seg` varchar(1) DEFAULT '0',
  `ter` varchar(1) DEFAULT '0',
  `qua` varchar(1) DEFAULT '0',
  `qui` varchar(1) DEFAULT '0',
  `sex` varchar(1) DEFAULT '0',
  `sab` varchar(1) DEFAULT '0',
  `dom` varchar(1) DEFAULT '0',
  PRIMARY KEY (`idhorario`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `logs`
--

DROP TABLE IF EXISTS `logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_pessoa` int(11) DEFAULT NULL,
  `id_cartao` varchar(12) DEFAULT NULL,
  `mensagem` tinytext,
  `data` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_pessoa_idx` (`id_pessoa`)
) ENGINE=InnoDB AUTO_INCREMENT=751 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pendentes`
--

DROP TABLE IF EXISTS `pendentes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pendentes` (
  `data` datetime(6) NOT NULL,
  `rfid` varchar(12) NOT NULL,
  `pin` varchar(4) NOT NULL,
  UNIQUE KEY `rfid_UNIQUE` (`rfid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `periodo_horario`
--

DROP TABLE IF EXISTS `periodo_horario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `periodo_horario` (
  `idPeriodo` int(11) NOT NULL,
  `idHorario` int(11) NOT NULL,
  KEY `idHorario_idx` (`idHorario`),
  KEY `idPeriodo_idx` (`idPeriodo`),
  CONSTRAINT `idHorario` FOREIGN KEY (`idHorario`) REFERENCES `horarios` (`idhorario`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `idPeriodo` FOREIGN KEY (`idPeriodo`) REFERENCES `periodos` (`idperiodo`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `periodos`
--

DROP TABLE IF EXISTS `periodos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `periodos` (
  `idperiodo` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) DEFAULT NULL,
  `datainicio` datetime NOT NULL,
  `datafim` datetime NOT NULL,
  `feriadoAtivo` varchar(1) DEFAULT '0',
  PRIMARY KEY (`idperiodo`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pessoa`
--

DROP TABLE IF EXISTS `pessoa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pessoa` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` text NOT NULL,
  `telefone` text NOT NULL,
  `endereco` varchar(45) NOT NULL,
  `dpto` varchar(1) NOT NULL,
  `email` varchar(45) NOT NULL,
  `senha` varchar(45) NOT NULL,
  `isAdmin` varchar(1) NOT NULL DEFAULT '0',
  `cpf` varchar(11) NOT NULL,
  `foto` varchar(80) DEFAULT NULL,
  `isActive` varchar(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `cpf_UNIQUE` (`cpf`)
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pessoa_periodo`
--

DROP TABLE IF EXISTS `pessoa_periodo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pessoa_periodo` (
  `idPeriodo` int(11) NOT NULL,
  `idPessoa` int(11) NOT NULL,
  KEY `idPeriodo_idx` (`idPeriodo`),
  KEY `fk_idPeriodo_idx` (`idPeriodo`),
  KEY `fk_idPessoa_idx` (`idPessoa`),
  CONSTRAINT `fk_idPeriodo` FOREIGN KEY (`idPeriodo`) REFERENCES `periodos` (`idperiodo`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `fk_idPessoa` FOREIGN KEY (`idPessoa`) REFERENCES `pessoa` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `rfid`
--

DROP TABLE IF EXISTS `rfid`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rfid` (
  `rfid` varchar(12) CHARACTER SET utf8 NOT NULL,
  `id_pessoa` int(11) DEFAULT NULL,
  `rfidActive` varchar(1) CHARACTER SET utf8 NOT NULL DEFAULT '0',
  `isMaster` varchar(1) DEFAULT NULL,
  PRIMARY KEY (`rfid`),
  KEY `id_pessoa` (`id_pessoa`),
  CONSTRAINT `fk-rfid-pessoa` FOREIGN KEY (`id_pessoa`) REFERENCES `pessoa` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-06-12 19:47:50
