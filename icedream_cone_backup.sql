-- MySQL dump 10.13  Distrib 5.6.28, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: icedream_cone
-- ------------------------------------------------------
-- Server version	5.6.28-0ubuntu0.15.04.1

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
-- Table structure for table `softserve_cart`
--

DROP TABLE IF EXISTS `softserve_cart`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `softserve_cart` (
  `cart_user_id` int(11) NOT NULL,
  `cart_product_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `softserve_cart`
--

LOCK TABLES `softserve_cart` WRITE;
/*!40000 ALTER TABLE `softserve_cart` DISABLE KEYS */;
INSERT INTO `softserve_cart` VALUES (4,42),(4,43),(4,44),(4,45),(4,46);
/*!40000 ALTER TABLE `softserve_cart` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `softserve_coupons`
--

DROP TABLE IF EXISTS `softserve_coupons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `softserve_coupons` (
  `coupon_id` int(11) NOT NULL AUTO_INCREMENT,
  `coupon_code` varchar(50) NOT NULL,
  `coupon_discount` int(11) NOT NULL,
  PRIMARY KEY (`coupon_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `softserve_coupons`
--

LOCK TABLES `softserve_coupons` WRITE;
/*!40000 ALTER TABLE `softserve_coupons` DISABLE KEYS */;
INSERT INTO `softserve_coupons` VALUES (1,'DOLLAROFF',1);
/*!40000 ALTER TABLE `softserve_coupons` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `softserve_ingredient_type`
--

DROP TABLE IF EXISTS `softserve_ingredient_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `softserve_ingredient_type` (
  `ingredient_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `ingredient_type_name` varchar(125) NOT NULL,
  `ingredient_type_slug` varchar(125) NOT NULL,
  PRIMARY KEY (`ingredient_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `softserve_ingredient_type`
--

LOCK TABLES `softserve_ingredient_type` WRITE;
/*!40000 ALTER TABLE `softserve_ingredient_type` DISABLE KEYS */;
INSERT INTO `softserve_ingredient_type` VALUES (1,'Ice Cream','ice_cream'),(2,'Soda','soda'),(3,'Milk','milk'),(4,'Container','container');
/*!40000 ALTER TABLE `softserve_ingredient_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `softserve_ingredients`
--

DROP TABLE IF EXISTS `softserve_ingredients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `softserve_ingredients` (
  `ingredient_id` int(11) NOT NULL AUTO_INCREMENT,
  `ingredient_name` varchar(125) NOT NULL,
  `ingredient_slug` varchar(125) NOT NULL,
  `ingredient_type` int(11) NOT NULL,
  `ingredient_price` float NOT NULL,
  PRIMARY KEY (`ingredient_id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `softserve_ingredients`
--

LOCK TABLES `softserve_ingredients` WRITE;
/*!40000 ALTER TABLE `softserve_ingredients` DISABLE KEYS */;
INSERT INTO `softserve_ingredients` VALUES (1,'Chocolate','chocolate',1,0.5),(2,'Vanilla','vanilla',1,0.5),(3,'Strawberry','strawberry',1,0.75),(4,'Peach','peach',1,1),(5,'Cherry','cherry',1,0.75),(6,'Mint Chocolate Chip','mint_chocolate_chip',1,1),(7,'Pecan','pecan',1,1),(8,'Coke','coke',2,0),(9,'Cream Soda','cream_soda',2,0),(10,'Root Beer','root_beer',2,0),(11,'Cherry Limeade','cherry_limeade',2,0),(12,'Orange Soda','orange_soda',2,0),(13,'2 Percent','2_percent',3,0.25),(14,'Skim Milk','skim_milk',3,0.75),(15,'Whole Milk','whole_milk',3,1.5),(16,'Sugar Cone','sugar_cone',4,0.5),(17,'Waffle Cone','waffle_cone',4,2),(18,'Glass','glass',4,0);
/*!40000 ALTER TABLE `softserve_ingredients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `softserve_order_items`
--

DROP TABLE IF EXISTS `softserve_order_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `softserve_order_items` (
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `softserve_order_items`
--

LOCK TABLES `softserve_order_items` WRITE;
/*!40000 ALTER TABLE `softserve_order_items` DISABLE KEYS */;
INSERT INTO `softserve_order_items` VALUES (11,42),(11,43),(11,44),(11,45),(11,46),(12,42),(12,43),(12,44),(12,45),(12,46),(13,42),(13,43),(13,44),(13,45),(13,46),(14,42),(14,43),(14,44),(14,45),(14,46),(15,42),(15,43),(15,44),(15,45),(15,46),(16,42),(16,43),(16,44),(16,45),(16,46),(17,42),(17,43),(17,44),(17,45),(17,46);
/*!40000 ALTER TABLE `softserve_order_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `softserve_orders`
--

DROP TABLE IF EXISTS `softserve_orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `softserve_orders` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_user_id` int(11) NOT NULL,
  `order_status` varchar(100) NOT NULL,
  `order_total` float DEFAULT NULL,
  PRIMARY KEY (`order_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `softserve_orders`
--

LOCK TABLES `softserve_orders` WRITE;
/*!40000 ALTER TABLE `softserve_orders` DISABLE KEYS */;
INSERT INTO `softserve_orders` VALUES (6,4,'1',21.25),(7,4,'1',21.25),(8,4,'1',21.25),(9,4,'1',21.25),(10,4,'1',22.25),(11,4,'1',22.25),(12,4,'1',22.25),(13,4,'1',22.25),(14,4,'1',22.25),(15,4,'1',21.25),(16,4,'1',21.25),(17,4,'1',21.25);
/*!40000 ALTER TABLE `softserve_orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `softserve_product`
--

DROP TABLE IF EXISTS `softserve_product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `softserve_product` (
  `product_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_base_price` float NOT NULL,
  `product_type` int(11) NOT NULL,
  PRIMARY KEY (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `softserve_product`
--

LOCK TABLES `softserve_product` WRITE;
/*!40000 ALTER TABLE `softserve_product` DISABLE KEYS */;
INSERT INTO `softserve_product` VALUES (42,1.5,1),(43,1.5,1),(44,4,2),(45,4,2),(46,2.5,3);
/*!40000 ALTER TABLE `softserve_product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `softserve_product_ingredients`
--

DROP TABLE IF EXISTS `softserve_product_ingredients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `softserve_product_ingredients` (
  `product_id` int(11) NOT NULL,
  `ingredient_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `softserve_product_ingredients`
--

LOCK TABLES `softserve_product_ingredients` WRITE;
/*!40000 ALTER TABLE `softserve_product_ingredients` DISABLE KEYS */;
INSERT INTO `softserve_product_ingredients` VALUES (42,17),(42,1),(42,3),(43,16),(43,1),(43,3),(44,18),(44,1),(44,15),(45,18),(45,1),(45,14),(46,18),(46,10),(46,2);
/*!40000 ALTER TABLE `softserve_product_ingredients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `softserve_product_type`
--

DROP TABLE IF EXISTS `softserve_product_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `softserve_product_type` (
  `product_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_type_name` varchar(125) NOT NULL,
  `product_type_slug` varchar(125) NOT NULL,
  `product_type_base_price` float NOT NULL,
  PRIMARY KEY (`product_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `softserve_product_type`
--

LOCK TABLES `softserve_product_type` WRITE;
/*!40000 ALTER TABLE `softserve_product_type` DISABLE KEYS */;
INSERT INTO `softserve_product_type` VALUES (1,'Ice Cream Cone','cone',1.5),(2,'Milkshake','milkshake',4),(3,'Ice Cream Float','float',2.5);
/*!40000 ALTER TABLE `softserve_product_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `softserve_users`
--

DROP TABLE IF EXISTS `softserve_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `softserve_users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(125) NOT NULL,
  `user_pass` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `softserve_users`
--

LOCK TABLES `softserve_users` WRITE;
/*!40000 ALTER TABLE `softserve_users` DISABLE KEYS */;
INSERT INTO `softserve_users` VALUES (4,'TrevorMW','$2y$10$H9Twt.RUdcJN/9HbAJivZOPA6IhP76DAFzbJrpTGPTzNuJZ990ZJW');
/*!40000 ALTER TABLE `softserve_users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-02-10 10:29:09
