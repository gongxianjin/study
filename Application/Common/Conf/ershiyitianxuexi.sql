-- MySQL dump 10.13  Distrib 5.6.29, for Linux (x86_64)
--
-- Host: localhost    Database: ershiyitianxuexi
-- ------------------------------------------------------
-- Server version	5.6.29-log

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
-- Table structure for table `activity`
--

DROP TABLE IF EXISTS `activity`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `activity` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '活动ID',
  `platform_id` int(11) NOT NULL COMMENT 'platform 平台ID',
  `user_id` int(11) NOT NULL COMMENT '创建者ID',
  `name` varchar(20) NOT NULL COMMENT '活动名称',
  `activity_start` date NOT NULL COMMENT '活动开始时间',
  `continuous` int(11) NOT NULL COMMENT '活动持续时间',
  `start` char(8) NOT NULL COMMENT '活动每天开始时间',
  `end` char(8) NOT NULL COMMENT '活动每天结束时间',
  `is_repeat` int(11) DEFAULT '0' COMMENT '活动每月是否重复【0 不重复，1 重复】',
  `cover_img` varchar(50) NOT NULL COMMENT '活动封面',
  `content` varchar(250) NOT NULL COMMENT '活动描述 ',
  `time` int(11) NOT NULL COMMENT '活动创建时间',
  `status` int(11) DEFAULT '0' COMMENT '活动状态， 0  创建， 1 已发布， 2 活动结束',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='编辑活动';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `activity`
--

LOCK TABLES `activity` WRITE;
/*!40000 ALTER TABLE `activity` DISABLE KEYS */;
INSERT INTO `activity` VALUES (1,1,1,'活动1','2018-01-01',1,'10:00:00','22:00:00',0,'d65752bb5f86ad31d892ac0685cce5fc.jpg','1111111111777777',1514863614,2),(2,1,1,'35','2018-01-01',10,'01:00:00','22:00:00',0,'337b56db1b8a95179c654e87fd70742e.jpg','22222222222',1515048919,2),(3,1,1,'2','2018-01-01',10,'01:00:00','23:00:00',0,'17af6f7f5c22bbf418865192c6176895.jpg','22222222222222222',1515058505,1),(4,1,1,'2','2018-01-01',10,'01:00:00','23:00:00',0,'17af6f7f5c22bbf418865192c6176895.jpg','22222222222222222',1515058528,1),(5,1,1,'56','2018-01-01',1,'10:00:00','22:00:00',0,'be0f8a47c176e4d45116f159e78a61cd.jpg','111111111111',1515146213,1),(6,1,1,'活动','2018-01-22',10,'08:00:00','19:00:00',0,'55e8295434781d0042f3212592dbc3d6.jpg','',1516337873,0);
/*!40000 ALTER TABLE `activity` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `activity_course`
--

DROP TABLE IF EXISTS `activity_course`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `activity_course` (
  `activity_id` int(11) NOT NULL,
  `grade_id` int(11) NOT NULL COMMENT '课程ID',
  `level_id` int(11) DEFAULT '0',
  `checked` int(11) DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `activity_course`
--

LOCK TABLES `activity_course` WRITE;
/*!40000 ALTER TABLE `activity_course` DISABLE KEYS */;
INSERT INTO `activity_course` VALUES (1,6,0,0),(1,9,0,0),(1,6,0,0),(2,9,0,0),(3,6,2,1),(3,6,1,1),(4,10,1,0),(4,6,2,1),(5,11,1,1),(6,6,1,0);
/*!40000 ALTER TABLE `activity_course` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `account` varchar(15) NOT NULL COMMENT '管理员账号',
  `password` char(32) NOT NULL COMMENT '管理员密码',
  `nickname` varchar(20) NOT NULL COMMENT '管理员名称',
  `platform_id` int(11) DEFAULT '0' COMMENT '管理员所属平台ID， 0 主平台',
  `time` int(11) NOT NULL COMMENT '管理员注册日期',
  `status` int(11) DEFAULT '0' COMMENT '管理员状态 0 正常，1 冻结，2 待定',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin`
--

LOCK TABLES `admin` WRITE;
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
INSERT INTO `admin` VALUES (1,'admin','735db5254d09da3201c8f0d1c8fbd5d3','admin',0,1508563219,0),(2,'13550145019','735db5254d09da3201c8f0d1c8fbd5d3','清新脱俗',1,2222,0);
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `book`
--

DROP TABLE IF EXISTS `book`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `book` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '图书ID',
  `user_id` int(11) NOT NULL COMMENT '图书创建者【所属平台】， 0为时为后台创建',
  `platform_id` int(11) NOT NULL COMMENT '所属平台',
  `classify_id` int(11) NOT NULL COMMENT '分类ID',
  `level_id` int(11) NOT NULL COMMENT '分级ID',
  `type` int(11) NOT NULL DEFAULT '0' COMMENT '课本属性： 0平台课本，1公开课本',
  `name` varchar(30) NOT NULL COMMENT '图书名称',
  `author` varchar(50) DEFAULT '' COMMENT '作者',
  `press` varchar(50) DEFAULT '' COMMENT '出版社',
  `cover_img` varchar(50) NOT NULL COMMENT '图书封面',
  `describe` varchar(200) DEFAULT NULL COMMENT '图书描述',
  `time` int(11) NOT NULL COMMENT '图书创建时间',
  `status` int(11) DEFAULT '0' COMMENT '图书状态',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `classify_id` (`classify_id`),
  KEY `level_id` (`level_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `book`
--

LOCK TABLES `book` WRITE;
/*!40000 ALTER TABLE `book` DISABLE KEYS */;
INSERT INTO `book` VALUES (1,1,1,1,1,0,'dd ','','','743916afefac283f3f50b7c90691ea39.jpg',NULL,1514603856,0);
/*!40000 ALTER TABLE `book` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `book_classify`
--

DROP TABLE IF EXISTS `book_classify`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `book_classify` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '分类ID',
  `platform_id` int(11) DEFAULT '0',
  `name` varchar(20) NOT NULL COMMENT '分类名称',
  `head_img` varchar(200) DEFAULT '' COMMENT '分类图片',
  `time` int(11) NOT NULL COMMENT '分类创建时间',
  `status` int(11) DEFAULT '0' COMMENT '图书分类操作 0：正常， 1： 待定',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `book_classify`
--

LOCK TABLES `book_classify` WRITE;
/*!40000 ALTER TABLE `book_classify` DISABLE KEYS */;
INSERT INTO `book_classify` VALUES (1,1,'分类1','d6f04d4593cae9d99c0b83c1cfd9e795.jpg',1514450026,0),(2,1,'分类2','d6f04d4593cae9d99c0b83c1cfd9e795.jpg',1514451292,0);
/*!40000 ALTER TABLE `book_classify` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `book_res`
--

DROP TABLE IF EXISTS `book_res`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `book_res` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `book_id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT '' COMMENT '课本主题',
  `image` varchar(100) DEFAULT '',
  `audio` varchar(100) DEFAULT '',
  `vide` varchar(100) DEFAULT '',
  `desc` varchar(200) DEFAULT '' COMMENT '课本描述',
  PRIMARY KEY (`id`),
  KEY `book_id` (`book_id`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `book_res`
--

LOCK TABLES `book_res` WRITE;
/*!40000 ALTER TABLE `book_res` DISABLE KEYS */;
INSERT INTO `book_res` VALUES (20,1,'纯音乐 - 欢快钢琴曲','3ac2973e2e30c47884701dcab4c2a3d9.jpg','','',''),(19,1,'纯音乐 - 古筝 (王燕琴)','3ac2973e2e30c47884701dcab4c2a3d9.jpg','','',''),(18,1,'六哲 - 音乐','3ac2973e2e30c47884701dcab4c2a3d9.jpg','','',''),(17,1,'d62a6059252dd42a2a58724c093b5bb5c8eab887','3ac2973e2e30c47884701dcab4c2a3d9.jpg','','',''),(15,1,'b21c8701a18b87d609fe43f10d0828381e30fda4','c4c5dceaf449bd3011ff20ef8231b70b.jpg','','',''),(13,1,'5243fbf2b211931364524d606f380cd790238dc9','a8dca2ef0864c290d2109d76fa532b82.jpg','','',''),(14,1,'902397dda144ad34c5e9756ddaa20cf430ad8582','dc437a693a0eb267b3ab229bc746aaed.jpg','','',''),(16,1,'caef76094b36acaf29e9c61576d98d1000e99cc9','012a8bb1f653b4f2784db429e1d69f14.jpg','','',''),(12,1,'342ac65c10385343cc0a93f39913b07ecb80881e','743916afefac283f3f50b7c90691ea39.jpg','','',''),(22,1,'纯音乐 - 轻松欢快的背景音乐','3ac2973e2e30c47884701dcab4c2a3d9.jpg','','',''),(21,1,'纯音乐 - 第一轮抽奖欢快的背景音乐','3ac2973e2e30c47884701dcab4c2a3d9.jpg','','','');
/*!40000 ALTER TABLE `book_res` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `classes`
--

DROP TABLE IF EXISTS `classes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `classes` (
  `class_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '班级ID',
  `user_id` int(11) NOT NULL COMMENT '班级创建者',
  `platform_id` int(11) NOT NULL COMMENT '班级所属平台',
  `class_name` varchar(50) NOT NULL COMMENT '班级名称',
  `count` int(11) NOT NULL COMMENT '班级人数',
  `time` int(11) NOT NULL COMMENT '创建时间',
  `status` int(11) DEFAULT '0' COMMENT 'status',
  PRIMARY KEY (`class_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `classes`
--

LOCK TABLES `classes` WRITE;
/*!40000 ALTER TABLE `classes` DISABLE KEYS */;
/*!40000 ALTER TABLE `classes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `classify_level`
--

DROP TABLE IF EXISTS `classify_level`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `classify_level` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `platform_id` int(11) DEFAULT '0',
  `classify_id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `head_img` varchar(100) DEFAULT '',
  `time` int(11) NOT NULL,
  `status` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `classify_level`
--

LOCK TABLES `classify_level` WRITE;
/*!40000 ALTER TABLE `classify_level` DISABLE KEYS */;
INSERT INTO `classify_level` VALUES (1,1,1,'分级1','',1514450038,0),(2,1,2,'分级2','',1514451311,0);
/*!40000 ALTER TABLE `classify_level` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `curriculum`
--

DROP TABLE IF EXISTS `curriculum`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `curriculum` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `platform_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `grade_id` int(11) NOT NULL,
  `read` int(11) DEFAULT '0' COMMENT '却读天数',
  `status` int(11) DEFAULT '0' COMMENT '0 报名成功等待学习，1 学习已完成， 2却都',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `curriculum`
--

LOCK TABLES `curriculum` WRITE;
/*!40000 ALTER TABLE `curriculum` DISABLE KEYS */;
INSERT INTO `curriculum` VALUES (1,1,1,1,0,0);
/*!40000 ALTER TABLE `curriculum` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `enlists`
--

DROP TABLE IF EXISTS `enlists`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `enlists` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `platform_id` int(11) NOT NULL COMMENT '平台ID',
  `user_id` int(11) NOT NULL COMMENT '报名者',
  `g_id` int(11) NOT NULL COMMENT '报名活动ID/或报名班级ID',
  `type` int(11) NOT NULL COMMENT 'type 0 活动班级， 1普通班级 ',
  `time` int(11) NOT NULL COMMENT '报名时间',
  `status` int(11) NOT NULL COMMENT '0 报名， 1 通过， 2 移除',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `enlists`
--

LOCK TABLES `enlists` WRITE;
/*!40000 ALTER TABLE `enlists` DISABLE KEYS */;
/*!40000 ALTER TABLE `enlists` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `exchange`
--

DROP TABLE IF EXISTS `exchange`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `exchange` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '商品ID',
  `platform_id` int(11) DEFAULT '0' COMMENT '所属平台ID【为 0 时由主平台添加】',
  `name` varchar(30) NOT NULL COMMENT '商品名称',
  `price` float(8,2) DEFAULT '0.00' COMMENT '物品价格',
  `score` int(11) DEFAULT '0' COMMENT '物品兑换所需积分',
  `type` int(11) DEFAULT '0' COMMENT '商品类型，0 实物，1虚拟物品',
  `url` varchar(200) DEFAULT '' COMMENT '物品兑换链接【虚拟物品时】',
  `head_img` varchar(100) NOT NULL COMMENT '物品封面图片',
  `images` int(11) NOT NULL COMMENT '物品预览图',
  `desc` varchar(200) DEFAULT '' COMMENT '物品描述',
  `time` int(11) NOT NULL COMMENT '物品添加时间',
  `status` int(11) DEFAULT '0' COMMENT '物品状态【 0=可以兑换，1下架，2 删除 】',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `exchange`
--

LOCK TABLES `exchange` WRITE;
/*!40000 ALTER TABLE `exchange` DISABLE KEYS */;
/*!40000 ALTER TABLE `exchange` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `exchange_order`
--

DROP TABLE IF EXISTS `exchange_order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `exchange_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'orderID',
  `trade_no` char(20) NOT NULL COMMENT '兑换订单号',
  `exchange_id` int(11) NOT NULL,
  `total` int(11) NOT NULL DEFAULT '0' COMMENT '兑换金额/兑换积分[ * 100 ]',
  `pay_type` int(11) DEFAULT '0' COMMENT '支付方式： 0 积分兑换， 1 在线支付',
  `user_id` int(11) NOT NULL,
  `info_address` varchar(150) DEFAULT '' COMMENT '收货地址',
  `info_phone` char(11) DEFAULT '' COMMENT '联系方式',
  `info_name` varchar(50) DEFAULT '' COMMENT '收件人名称',
  `create_time` int(11) NOT NULL COMMENT '订单创建时间',
  `status` int(11) DEFAULT '0' COMMENT '订单状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `exchange_order`
--

LOCK TABLES `exchange_order` WRITE;
/*!40000 ALTER TABLE `exchange_order` DISABLE KEYS */;
/*!40000 ALTER TABLE `exchange_order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `forum`
--

DROP TABLE IF EXISTS `forum`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `forum` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `platform_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL COMMENT '发布者 user_id',
  `type` int(11) DEFAULT '0' COMMENT '类型',
  `title` varchar(20) DEFAULT '' COMMENT '主题名称',
  `content` varchar(240) NOT NULL COMMENT '话题内容',
  `img` text,
  `praise` int(11) DEFAULT '0' COMMENT '赞人数',
  `comments` int(11) DEFAULT '0' COMMENT '评论人数',
  `time` int(11) NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `forum`
--

LOCK TABLES `forum` WRITE;
/*!40000 ALTER TABLE `forum` DISABLE KEYS */;
INSERT INTO `forum` VALUES (1,1,1,0,'没有','专业吹牛，至今未逢敌手',NULL,0,0,33333),(2,1,1,0,'','阿斯顿发射点',NULL,0,0,155555555),(3,1,1,0,'','35634563456','[]',0,0,1515142230),(4,1,1,0,'','3563456356','[\"e16528a76186daccf6e2216d2ee2a09b.jpg\",\"d0299b8748342b3b73fd96d31c32ae9e.jpg\"]',0,0,1515142906),(5,1,1,0,'','563456','[]',0,0,1515142988),(6,1,1,0,'','发的算法的发','[\"9562bc17c2ac52c1134a36bb3d42594a.jpg\",\"7b1e6530b795de8f788c8b90cf4e078a.jpg\",\"94448e6c50868f44bc3ad8f5970f5891.jpg\"]',0,0,1515143724),(7,1,1,0,'','超帅','[]',0,0,1515144965);
/*!40000 ALTER TABLE `forum` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `forum_focus`
--

DROP TABLE IF EXISTS `forum_focus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `forum_focus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `bbs_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='论坛关注';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `forum_focus`
--

LOCK TABLES `forum_focus` WRITE;
/*!40000 ALTER TABLE `forum_focus` DISABLE KEYS */;
/*!40000 ALTER TABLE `forum_focus` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `goods_type`
--

DROP TABLE IF EXISTS `goods_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `goods_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `platform_id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `whether` int(11) DEFAULT '0' COMMENT '是否为虚拟物品类',
  `time` int(11) NOT NULL,
  `status` int(11) DEFAULT '0' COMMENT '类型状态',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `goods_type`
--

LOCK TABLES `goods_type` WRITE;
/*!40000 ALTER TABLE `goods_type` DISABLE KEYS */;
INSERT INTO `goods_type` VALUES (1,1,'物品分类1',0,1514451451,0),(2,1,'物品分类2',1,1514451462,0);
/*!40000 ALTER TABLE `goods_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `grade`
--

DROP TABLE IF EXISTS `grade`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `grade` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT '创建者',
  `platform_id` int(11) NOT NULL COMMENT '所属平台',
  `type` int(11) DEFAULT '0' COMMENT '班级类型【0 普通班级， 1 活动班级】',
  `name` varchar(20) NOT NULL COMMENT '班级名称',
  `price` float(9,2) DEFAULT '0.00',
  `describe` varchar(200) DEFAULT '',
  `img` varchar(50) NOT NULL DEFAULT '',
  `time` int(11) DEFAULT '0' COMMENT '创建时间',
  `status` int(11) DEFAULT '0' COMMENT 'status',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COMMENT='班级';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `grade`
--

LOCK TABLES `grade` WRITE;
/*!40000 ALTER TABLE `grade` DISABLE KEYS */;
INSERT INTO `grade` VALUES (1,1,1,0,'3563546',NULL,NULL,'a28b30d3eb0605c8e3a63584b9eed77d.jpg',1514795428,0),(2,1,1,0,'1212',NULL,NULL,'9b04107eedd9bb929a6a0b14cdbcf486.jpg',1514875050,0),(3,1,1,0,'666666666666',NULL,NULL,'c8f02b1d0514dbbb6d101bbdf4bde555.jpg',1514886287,0),(4,1,1,0,'888888888888',NULL,NULL,'45eca6292582eb3e8b23925c58e7abc2.jpg',1514886476,0),(5,1,1,0,'363',NULL,NULL,'883302b262a48bd2ca69a87b4290e10a.jpg',1514886519,0),(6,1,1,1,'3657',0.01,NULL,'eb693b924691bc0f6684085f6e20f82a.jpg',1514886679,0),(7,1,1,0,'3673',NULL,NULL,'259ff9e64bf01838d11eb16aef7c6ad5.jpg',1514886694,0),(8,1,1,0,'111111',NULL,NULL,'0c46ff613c92492400b33f63e394ed01.jpg',1515045644,0),(9,1,1,0,'66666666666666',0.00,'','6d3bcbc247cd9e411229737a2c64a35a.jpg',1515053630,0),(10,1,1,1,'打发打发',12.12,'烦烦烦烦烦烦','1237000a9e7a7e92edde5796a62cc887.jpg',1515053927,0),(11,1,1,1,'45674567',450.00,'4567456745674567','ec9c8594ad8eee15ceec96d3937816b3.jpg',1515145993,0),(12,1,1,0,'12',0.00,'','8733cf8ade73f91962827d87522fb908.jpg',1515146007,0);
/*!40000 ALTER TABLE `grade` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order`
--

DROP TABLE IF EXISTS `order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `trade_no` varchar(20) NOT NULL COMMENT '订单号',
  `out_trade_no` varchar(48) DEFAULT '' COMMENT '支付平台订单号',
  `user_id` int(11) NOT NULL COMMENT '支付学员',
  `platform_id` int(11) NOT NULL COMMENT '所属平台',
  `grade_id` int(11) NOT NULL COMMENT '班级',
  `price` float(9,2) NOT NULL COMMENT '支付金额',
  `create_time` int(11) NOT NULL COMMENT '创建时间',
  `pay_time` int(11) DEFAULT '0' COMMENT '支付时间',
  `status` int(11) DEFAULT '0' COMMENT '交易状态 0 支付创建，1支付成功，2支付失败，3 支付取消',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order`
--

LOCK TABLES `order` WRITE;
/*!40000 ALTER TABLE `order` DISABLE KEYS */;
INSERT INTO `order` VALUES (1,'T2018010517333630208','',1,1,6,0.01,1515144816,0,0),(2,'T2018010517333661341','',1,1,6,0.01,1515144817,0,0),(3,'T2018010517460941884','',1,1,6,0.01,1515145569,0,0);
/*!40000 ALTER TABLE `order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `platform`
--

DROP TABLE IF EXISTS `platform`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `platform` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `platform_name` varchar(20) NOT NULL COMMENT '公众平台名称',
  `app_id` varchar(100) DEFAULT NULL,
  `app_secret` text,
  `time` int(11) NOT NULL COMMENT '创建时间',
  `status` int(11) DEFAULT '0' COMMENT 'status',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `platform`
--

LOCK TABLES `platform` WRITE;
/*!40000 ALTER TABLE `platform` DISABLE KEYS */;
INSERT INTO `platform` VALUES (1,'超帅',NULL,NULL,1519444444,0);
/*!40000 ALTER TABLE `platform` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `score_order`
--

DROP TABLE IF EXISTS `score_order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `score_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `trade_no` char(20) NOT NULL COMMENT '订单号',
  `out_trade_no` varchar(48) DEFAULT NULL,
  `price` float(9,2) NOT NULL COMMENT '支付金额',
  `user_id` int(11) NOT NULL COMMENT '兑换用户ID',
  `goods_id` int(11) NOT NULL,
  `s_address` varchar(200) NOT NULL COMMENT '收件地址',
  `s_url` varchar(200) DEFAULT '' COMMENT '虚拟物品兑换地址',
  `s_nickname` varchar(20) NOT NULL COMMENT '收件人',
  `s_phone` varchar(15) NOT NULL COMMENT '收件人联系方式',
  `goods_name` varchar(20) NOT NULL COMMENT '物品名称',
  `count` int(11) NOT NULL COMMENT '购买数量',
  `score` int(11) DEFAULT '0' COMMENT '兑换时使用的积分数量',
  `code` varchar(100) DEFAULT '' COMMENT '虚拟物品的兑换码',
  `create_time` int(11) NOT NULL COMMENT '创建时间',
  `pay_time` int(11) DEFAULT '0' COMMENT '支付时间',
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `score_order`
--

LOCK TABLES `score_order` WRITE;
/*!40000 ALTER TABLE `score_order` DISABLE KEYS */;
INSERT INTO `score_order` VALUES (2,'S2018010517345017686','S2018010517345017686',0.00,1,2,'没有地址 不得说','http://www.baidu.com','测试收货地址','13550145019','商品2',1,56,'',1515144890,1515144890,1),(3,'S2018010517345782600','S2018010517345782600',0.00,1,2,'没有地址 不得说','http://www.baidu.com','测试收货地址','13550145019','商品2',1,56,'',1515144897,1515144897,1),(4,'S2018010517364143973','S2018010517364143973',0.00,1,2,'没有地址 不得说','http://www.baidu.com','测试收货地址','13550145019','商品2',1,56,'',1515145001,1515145001,1),(5,'S2018010517364498097','S2018010517364498097',0.00,1,2,'没有地址 不得说','http://www.baidu.com','测试收货地址','13550145019','商品2',1,56,'',1515145004,1515145004,1),(7,'S2018010517462269920',NULL,50.00,1,1,'没有地址 不得说','','测试收货地址','13550145019','商品1',1,34,'',1515145582,0,0),(8,'S2018010517463158129','S2018010517463158129',0.00,1,2,'没有地址 不得说','http://www.baidu.com','测试收货地址','13550145019','商品2',1,56,'',1515145591,1515145591,1),(10,'S2018010618492218291',NULL,50.00,1,1,'没有地址 不得说','','测试收货地址','13550145019','商品1',1,34,'',1515235762,0,0),(13,'S2018010618495366481',NULL,50.00,1,1,'没有地址 不得说','','测试收货地址','13550145019','商品1',1,34,'',1515235793,0,0),(14,'S2018010618495367120',NULL,50.00,1,1,'没有地址 不得说','','测试收货地址','13550145019','商品1',1,34,'',1515235793,0,0),(16,'S2018011912544213483',NULL,50.00,1,1,'没有地址 不得说','','测试收货地址','13550145019','商品1',1,34,'',1516337682,0,0);
/*!40000 ALTER TABLE `score_order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `score_shop`
--

DROP TABLE IF EXISTS `score_shop`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `score_shop` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `platform_id` int(11) DEFAULT '0' COMMENT '所属平台',
  `type_id` int(11) NOT NULL COMMENT '商品类型',
  `name` varchar(20) NOT NULL COMMENT '商品名称',
  `old_price` float(8,2) DEFAULT NULL COMMENT '商品原价',
  `price` float(8,2) DEFAULT NULL COMMENT '商品单价',
  `score` int(11) DEFAULT '0' COMMENT '兑换积分',
  `count` int(11) DEFAULT '1' COMMENT '库存数量',
  `sold` int(11) DEFAULT '0' COMMENT '销售数量',
  `color` varchar(50) DEFAULT '' COMMENT '商品颜色',
  `url` varchar(150) DEFAULT '' COMMENT '资源地址',
  `img` text NOT NULL COMMENT '商品图片',
  `content` varchar(250) DEFAULT '' COMMENT '商品描述',
  `time` int(11) NOT NULL COMMENT '创建时间',
  `status` int(11) DEFAULT '0' COMMENT '商品状态',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `score_shop`
--

LOCK TABLES `score_shop` WRITE;
/*!40000 ALTER TABLE `score_shop` DISABLE KEYS */;
INSERT INTO `score_shop` VALUES (1,1,2,'商品1',5000.00,50.00,34,452,45,'','','[\"d6f04d4593cae9d99c0b83c1cfd9e795.jpg\"]','问题我让他人',1514451573,0),(2,1,1,'商品2',56.00,0.00,56,565,564,'','http://www.baidu.com','[\"d6f04d4593cae9d99c0b83c1cfd9e795.jpg\"]','2523452',1514451641,0);
/*!40000 ALTER TABLE `score_shop` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `student_list`
--

DROP TABLE IF EXISTS `student_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `student_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `teacher_id` int(11) NOT NULL COMMENT '教师ID',
  `user_id` int(11) NOT NULL COMMENT '学员ID',
  `grade_id` int(11) NOT NULL COMMENT '班级',
  `start` int(11) NOT NULL COMMENT '开始时间',
  `end` int(11) NOT NULL COMMENT '结束时间',
  `course_id` int(11) NOT NULL COMMENT '课程',
  `setup` int(11) DEFAULT '0' COMMENT '完成课程步骤',
  `time` int(11) NOT NULL COMMENT '创建时间',
  `status` int(11) DEFAULT '0' COMMENT 'status',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `student_list`
--

LOCK TABLES `student_list` WRITE;
/*!40000 ALTER TABLE `student_list` DISABLE KEYS */;
/*!40000 ALTER TABLE `student_list` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `task_list`
--

DROP TABLE IF EXISTS `task_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `task_list` (
  `grade_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `book` int(11) NOT NULL,
  `start` int(11) NOT NULL,
  `end` int(11) NOT NULL,
  `day` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  UNIQUE KEY `grade_id` (`grade_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `task_list`
--

LOCK TABLES `task_list` WRITE;
/*!40000 ALTER TABLE `task_list` DISABLE KEYS */;
INSERT INTO `task_list` VALUES (2,1,12,12,1,2,1515126565),(12,1,12,12,12,12,1515146162);
/*!40000 ALTER TABLE `task_list` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '用户ID',
  `phone` varchar(20) NOT NULL COMMENT '手机号码',
  `platform_id` int(11) DEFAULT '0' COMMENT '账号所属平台',
  `open_id` varchar(50) DEFAULT '' COMMENT '微信openid',
  `password` char(32) NOT NULL COMMENT '密码',
  `nickname` varchar(20) DEFAULT '' COMMENT '名称',
  `parent_id` int(11) DEFAULT '0' COMMENT '是否是子账号， 0 家长账号，1 小孩子账号',
  `type` int(11) DEFAULT '0' COMMENT '账号类型 0，用户账号，1 教师账号， 2 管理员账号',
  `sex` int(11) DEFAULT '0' COMMENT '性别 0 不详 ，1 男 2女',
  `birthday` date DEFAULT NULL COMMENT '生日',
  `city` varchar(50) DEFAULT '',
  `head_img` varchar(100) DEFAULT '' COMMENT '账号头像',
  `time` int(11) NOT NULL COMMENT '账号创建时间',
  `status` int(11) DEFAULT '0' COMMENT '账号状态',
  PRIMARY KEY (`id`),
  UNIQUE KEY `phone` (`phone`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'13555555555',1,'','77ac6b28809897fa9de80c81f9ec2dbc','超会吹',0,1,1,'2017-04-08','湖南 衡阳市 珠晖区','0be9b7131937faadd178894875b52c28.jpg',1514426525,0),(2,'18108182710',1,'','468cc64e7bc0239a3c89b58aee062bb7','',0,0,0,NULL,'','',1515147284,0),(3,'17311481508',1,'','77ac6b28809897fa9de80c81f9ec2dbc','',0,0,0,NULL,'','',1515469236,0),(4,'18761152656',1,'','77ac6b28809897fa9de80c81f9ec2dbc','',0,0,0,NULL,'','',1516338161,0),(5,'13648013533',1,'','77ac6b28809897fa9de80c81f9ec2dbc','',0,0,0,NULL,'','',1516354276,0),(6,'18628246831',1,'','77ac6b28809897fa9de80c81f9ec2dbc','',0,0,0,NULL,'','',1516540633,0);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_address`
--

DROP TABLE IF EXISTS `user_address`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_address` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `nickname` varchar(20) NOT NULL,
  `phone` varchar(11) NOT NULL,
  `city` varchar(20) NOT NULL,
  `address` varchar(100) NOT NULL,
  `def` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_address`
--

LOCK TABLES `user_address` WRITE;
/*!40000 ALTER TABLE `user_address` DISABLE KEYS */;
INSERT INTO `user_address` VALUES (1,1,'测试收货地址','13550145019','湖南 张家界市 慈利县','没有地址 不得说',1);
/*!40000 ALTER TABLE `user_address` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_funds`
--

DROP TABLE IF EXISTS `user_funds`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_funds` (
  `user_id` int(11) NOT NULL COMMENT '用户ID',
  `money` float(10,2) DEFAULT '0.00' COMMENT '用户金额',
  `frozen_money` float(10,2) DEFAULT '0.00' COMMENT '冻结金额',
  `score` int(11) DEFAULT '0' COMMENT '用户积分',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_funds`
--

LOCK TABLES `user_funds` WRITE;
/*!40000 ALTER TABLE `user_funds` DISABLE KEYS */;
INSERT INTO `user_funds` VALUES (1,0.00,0.00,50000);
/*!40000 ALTER TABLE `user_funds` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_score_detail`
--

DROP TABLE IF EXISTS `user_score_detail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_score_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT '用户ID',
  `type` int(11) DEFAULT '0' COMMENT '0 收入  1 支出',
  `score` int(11) NOT NULL COMMENT '增益积分量',
  `source` int(11) DEFAULT '0' COMMENT '来源[ 值由配置文件中定 ]',
  `value` varchar(200) DEFAULT '' COMMENT 'value[来源值    ]',
  `time` int(11) NOT NULL COMMENT '时间',
  `content` varchar(200) DEFAULT NULL COMMENT '描述',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_score_detail`
--

LOCK TABLES `user_score_detail` WRITE;
/*!40000 ALTER TABLE `user_score_detail` DISABLE KEYS */;
INSERT INTO `user_score_detail` VALUES (1,1,1,56,0,'2',1515144890,'积分商城，商品兑换抵扣'),(2,1,1,56,0,'2',1515144897,'积分商城，商品兑换抵扣'),(3,1,1,56,0,'2',1515145001,'积分商城，商品兑换抵扣'),(4,1,1,56,0,'2',1515145004,'积分商城，商品兑换抵扣'),(5,1,1,56,0,'2',1515145591,'积分商城，商品兑换抵扣');
/*!40000 ALTER TABLE `user_score_detail` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-01-22 14:05:15
