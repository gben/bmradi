/*
SQLyog Ultimate v11.11 (64 bit)
MySQL - 5.6.17 : Database - germinit_mradi_dbx
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

/*Table structure for table `permission` */

DROP TABLE IF EXISTS `permission`;

CREATE TABLE `permission` (
  `ID` int(5) NOT NULL AUTO_INCREMENT,
  `title` varchar(64) NOT NULL,
  `module` enum('System','Dashboard','Master Records','Reports','Reconciliation','User Management','Finance','Accounts Administration','MailBox','Notification','Investors','Entrepreneurs','Campaigns') NOT NULL DEFAULT 'System',
  `description` varchar(255) DEFAULT NULL,
  `is_menu` int(4) DEFAULT '0',
  `menu_level` int(4) DEFAULT NULL,
  `menu_pos` int(4) DEFAULT NULL,
  `child_of` int(4) DEFAULT NULL,
  `menu_name` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `creationTime` int(10) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `title` (`title`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;

/*Data for the table `permission` */

insert  into `permission`(`ID`,`title`,`module`,`description`,`is_menu`,`menu_level`,`menu_pos`,`child_of`,`menu_name`,`url`,`creationTime`) values (1,'basic.select.permission','Dashboard','Dashboard-Admin',2,1,1,NULL,'Dashboard','dashboard',1343412676),(3,'actrpt.select.permission','Reports','Activity Reports',1,1,1,NULL,'Activity Logs','activity_reports',1343412676),(4,'campaignrpt.select.permission','Campaigns','Campaigns',2,1,1,NULL,'Campaigns','campaigns_list',1343412676),(5,'all.select.permission','Reports','All Campaigns',1,1,1,5,'All Campaigns','all_cp_report',1343412676),(6,'ongoing.select.permission','Reports','Ongoing Campaigns',1,1,2,5,'Ongoing Campaigns','ongoing_cp_report',1343412676),(7,'closed.select.permission','Reports','Closed Campaigns',1,1,3,5,'Closed Campaigns','closed_cp_report',1343412676),(8,'shelved.select.permission','Reports','Shelved Campaigns',1,1,4,5,'Shelved Campaigns','shelved_cp_report',1343412676),(9,'finance.select.permission','Finance','Finance',0,1,1,NULL,'Finance',NULL,1343412676),(10,'incomegen.select.permission','Finance','Income Generated',1,1,1,10,'Income Generated','income_gen',1343412676),(11,'shares.select.permission','Finance','Shares',1,1,2,10,'Shares','shares',1343412676),(12,'subscr.select.permission','Accounts Administration','Subscription',1,1,1,NULL,'Subscription','subscriptions',1343412676),(13,'inv.acc.select.permission','Accounts Administration','Investors',1,1,1,13,'Investors','investor_acc',1343412676),(14,'entr.acc.select.permission','Accounts Administration','Entrepreneurs',1,1,2,13,'Entrepreneurs','entre_acc',1343412676),(15,'mailbox.select.permission','MailBox','MailBox',0,1,1,NULL,'MailBox',NULL,1343412676),(16,'outbox.select.permission','MailBox','Outbox',1,1,2,16,'Outbox','outbox',1343412676),(17,'conv.select.permission','MailBox','Conversation',1,1,3,16,'Conversation','conversation',1343412676),(18,'compose.select.permission','MailBox','Compose Message',1,1,4,16,'Compose Message','compose',1343412676),(19,'inbox.select.permission','MailBox','Inbox',1,1,1,16,'Inbox','inbox',1343412676),(20,'noti.select.permission','Notification','Notification',2,1,1,NULL,'Notification','notification',1343412676),(21,'inv.select.permission','Investors','Investors Menu',2,1,1,NULL,'Investors','investors',1343412676),(22,'entre.select.permission','Entrepreneurs','Entrepreneurs Menu',2,1,1,NULL,'Entrepreneurs','entrepreneur',1343412676),(23,'master.select.permission','Master Records','Master Records',2,1,1,NULL,'Master Records','master_records',1343412676),(24,'role.select.permission','Accounts Administration','Roles',1,1,4,NULL,'Roles','roles',134212344),(25,'role.insert.permission','Accounts Administration','Add New Roles',0,NULL,NULL,NULL,'Add New Role',NULL,13434234),(26,'role.update.permission','Accounts Administration','Update Roles',0,NULL,NULL,NULL,'Edit Role',NULL,122324353),(27,'role.delete.permission','Accounts Administration','Delete Roles',0,NULL,NULL,NULL,'Delete Role',NULL,2147483647);

/*Table structure for table `permissionmap` */

DROP TABLE IF EXISTS `permissionmap`;

CREATE TABLE `permissionmap` (
  `ID` int(20) NOT NULL AUTO_INCREMENT,
  `site` int(20) NOT NULL,
  `role` int(20) NOT NULL,
  `permission` int(5) NOT NULL,
  `creationTime` int(10) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `site` (`site`),
  KEY `role` (`role`),
  KEY `permission` (`permission`)
) ENGINE=InnoDB AUTO_INCREMENT=87 DEFAULT CHARSET=latin1;

/*Data for the table `permissionmap` */

insert  into `permissionmap`(`ID`,`site`,`role`,`permission`,`creationTime`) values (1,1,1,12,12233333),(2,1,1,3,12233333),(3,1,1,5,12233333),(4,1,1,1,12233333),(5,1,1,4,12233333),(6,1,1,7,12233333),(7,1,1,18,12233333),(8,1,1,17,12233333),(9,1,1,14,12233333),(10,1,1,22,12233333),(11,1,1,9,12233333),(12,1,1,19,12233333),(13,1,1,10,12233333),(14,1,1,13,12233333),(15,1,1,21,12233333),(16,1,1,15,12233333),(17,1,1,23,12233333),(18,1,1,20,12233333),(19,1,1,6,12233333),(20,1,1,16,12233333),(21,1,1,11,12233333),(22,1,1,8,12233333),(32,1,2,3,12233333),(33,1,2,5,12233333),(34,1,2,1,12233333),(35,1,2,4,12233333),(36,1,2,7,12233333),(37,1,2,18,12233333),(38,1,2,17,12233333),(39,1,2,14,12233333),(40,1,2,22,12233333),(41,1,2,9,12233333),(42,1,2,19,12233333),(43,1,2,10,12233333),(44,1,2,13,12233333),(45,1,2,21,12233333),(46,1,2,15,12233333),(47,1,2,23,12233333),(48,1,2,20,12233333),(49,1,2,6,12233333),(50,1,2,16,12233333),(51,1,2,11,12233333),(52,1,2,8,12233333),(53,1,2,12,12233333),(63,1,3,3,12233333),(64,1,3,5,12233333),(65,1,3,1,12233333),(66,1,3,4,12233333),(67,1,3,7,12233333),(68,1,3,18,12233333),(69,1,3,17,12233333),(70,1,3,14,12233333),(71,1,3,22,12233333),(72,1,3,9,12233333),(73,1,3,19,12233333),(74,1,3,10,12233333),(75,1,3,13,12233333),(76,1,3,21,12233333),(77,1,3,15,12233333),(78,1,3,23,12233333),(79,1,3,20,12233333),(80,1,3,6,12233333),(81,1,3,16,12233333),(82,1,3,11,12233333),(83,1,3,8,12233333),(84,1,3,12,12233333),(85,1,6,24,1212222),(86,1,1,24,1212222);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
