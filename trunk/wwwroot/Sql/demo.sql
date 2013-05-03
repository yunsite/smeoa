# Host: localhost  (Version: 5.1.41)
# Date: 2013-05-02 17:06:27
# Generator: MySQL-Front 5.3  (Build 2.28)

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='UTC' */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE */;
/*!40101 SET SQL_MODE='' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES */;
/*!40103 SET SQL_NOTES='ON' */;

#
# Source for table "think_class"
#

DROP TABLE IF EXISTS `think_class`;
CREATE TABLE `think_class` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL,
  `type` varchar(20) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `admin` varchar(200) NOT NULL,
  `write` varchar(200) NOT NULL,
  `read` varchar(200) NOT NULL,
  `sort` varchar(20) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `remark` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

#
# Data for table "think_class"
#

INSERT INTO `think_class` VALUES (1,0,'contact',1,'ABC','','','','',1,''),(2,0,'contact',1,'123123','','','','',1,''),(3,0,'contact',1,'abc','','','','',1,''),(4,0,'contact',1,'abc','','','','',1,''),(5,0,'contact',1,'qqqq','','','','',1,''),(6,0,'contact',1,'sssss','','','','',1,''),(7,0,'contact',1,'xxxxx','','','','',1,''),(8,0,'contact',1,'zzzz','','','','',1,''),(9,0,'contact',1,'vvvvvv','','','','',1,''),(10,0,'contact',1,'asdfasdf','','','','',1,''),(11,0,'contact',1,'1234','','','','',1,''),(12,0,'supplier',1,'ABC','','','','',1,''),(13,0,'customer',1,'AAAA','','','','',1,'');

#
# Source for table "think_class_data"
#

DROP TABLE IF EXISTS `think_class_data`;
CREATE TABLE `think_class_data` (
  `obj_id` int(11) NOT NULL DEFAULT '0',
  `class_id` int(11) NOT NULL DEFAULT '0',
  `type` varchar(20) NOT NULL DEFAULT '',
  KEY `obj_id` (`obj_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Data for table "think_class_data"
#

INSERT INTO `think_class_data` VALUES (11,2,'contact'),(10,2,'contact'),(11,1,'contact'),(10,1,'contact'),(11,3,'contact'),(10,3,'contact'),(8,4,'contact'),(9,8,'contact'),(10,5,'contact'),(8,3,'contact'),(9,4,'contact'),(10,6,'contact'),(8,11,'contact'),(18,13,'customer'),(18,12,'supplier');

#
# Source for table "think_config"
#

DROP TABLE IF EXISTS `think_config`;
CREATE TABLE `think_config` (
  `id` int(11) NOT NULL DEFAULT '0',
  `home_sort` varchar(255) DEFAULT NULL,
  `list_rows` int(11) DEFAULT '20',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Data for table "think_config"
#

INSERT INTO `think_config` VALUES (1,'1,2,3,4,5,6,',13);

#
# Source for table "think_contact"
#

DROP TABLE IF EXISTS `think_contact`;
CREATE TABLE `think_contact` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `letter` varchar(50) DEFAULT '',
  `company` varchar(30) DEFAULT '',
  `dept` varchar(20) DEFAULT '',
  `position` varchar(20) DEFAULT '',
  `email` varchar(255) DEFAULT NULL,
  `office_tel` varchar(20) DEFAULT NULL,
  `mobile_tel` varchar(20) DEFAULT '',
  `website` varchar(50) DEFAULT '',
  `im` varchar(20) DEFAULT '',
  `address` varchar(50) DEFAULT '',
  `user_id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `remark` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COMMENT='think_user_info';

#
# Data for table "think_contact"
#

INSERT INTO `think_contact` VALUES (8,'才','C','我','qqqqq','','','123132123','','','','2',1,1,''),(9,'他','T','是','部门：','职位：','','公电话','手机','','','2',1,1,''),(10,'啊','A','公司公司公司公司','吧','公司公司','yyyyy@yy.com','0532-86910038','139-1234-1234','www.sohu.com','1234567','',1,1,''),(11,'张三','ZS','张三','IT','CEO','zhang@zhang.com','654','321','','12356','1',1,1,'');

#
# Source for table "think_customer"
#

DROP TABLE IF EXISTS `think_customer`;
CREATE TABLE `think_customer` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `letter` varchar(50) DEFAULT '',
  `biz_license` varchar(30) DEFAULT '',
  `short` varchar(20) DEFAULT '',
  `contact` varchar(20) DEFAULT '',
  `email` varchar(255) DEFAULT NULL,
  `office_tel` varchar(20) DEFAULT NULL,
  `mobile_tel` varchar(20) DEFAULT '',
  `fax` varchar(20) DEFAULT NULL,
  `salesman` varchar(50) DEFAULT '',
  `im` varchar(20) DEFAULT '',
  `address` varchar(50) DEFAULT '',
  `user_id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `remark` text,
  `payment` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

#
# Data for table "think_customer"
#

INSERT INTO `think_customer` VALUES (18,'123123','','2342342','123123','lianxiren','abc@sdof.com','123125123','','','yewu','','',1,0,'',''),(19,'123123','','2342342','123123','lianxiren','abc@sdof.com','123125123',NULL,NULL,'yewu',NULL,NULL,0,0,NULL,NULL);

#
# Source for table "think_dept"
#

DROP TABLE IF EXISTS `think_dept`;
CREATE TABLE `think_dept` (
  `id` smallint(3) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL,
  `code` varchar(20) NOT NULL,
  `dept_grade_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `short` varchar(20) NOT NULL,
  `sort` varchar(20) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `remark` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

#
# Data for table "think_dept"
#

INSERT INTO `think_dept` VALUES (1,0,'A1',5,'小微企业','','',1,''),(2,1,'YY',9,'运营部','运营','5',1,''),(3,1,'PD',9,'产品部','产品','4',1,''),(4,6,'软件',9,'人事科','人事','',0,''),(5,1,'B12',0,'总经理','总经','1',1,''),(6,1,'B2',6,'行政部','行政','2',1,''),(7,1,'B3',6,'销售部','销售','3',1,''),(8,1,'B4',6,'开发部','开发','2',1,''),(9,7,'C1',7,'销售1科','销售1','',1,''),(10,6,'D2',8,'会计科','会计','',1,''),(11,7,'E1',0,'销售2科','销售2','',1,''),(12,8,'E2',9,'开发二科','开二','',1,''),(13,8,'C4',9,'开发一科','开一','',1,'');

#
# Source for table "think_dept_grade"
#

DROP TABLE IF EXISTS `think_dept_grade`;
CREATE TABLE `think_dept_grade` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(10) NOT NULL DEFAULT '',
  `name` varchar(20) NOT NULL,
  `sort` varchar(10) NOT NULL,
  `status` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

#
# Data for table "think_dept_grade"
#

INSERT INTO `think_dept_grade` VALUES (5,'DG1','总经理','10',1),(6,'DG10','本部','20',1),(7,'DG20','部','30',1),(8,'DG30','处','40',1),(9,'DG40','科','50',1);

#
# Source for table "think_doc"
#

DROP TABLE IF EXISTS `think_doc`;
CREATE TABLE `think_doc` (
  `id` smallint(4) unsigned NOT NULL AUTO_INCREMENT,
  `doc_no` varchar(20) NOT NULL,
  `type` varchar(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `folder` int(11) NOT NULL,
  `add_file` varchar(200) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_name` varchar(20) NOT NULL,
  `create_time` int(11) unsigned NOT NULL,
  `update_time` int(11) unsigned NOT NULL,
  `status` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=63 DEFAULT CHARSET=utf8;

#
# Data for table "think_doc"
#

INSERT INTO `think_doc` VALUES (59,'2013-0001','/doc/common/','ZZZZZZZZZ','<p>\r\n\txxxxxxxxxxxxxxxxxxxxxxxxx\r\n</p>',7,'578;580;',1,'管理员',1366620599,1366623014,1),(60,'2013-0001','/doc/common/','aaaaaaaaaaaa','aaaaaaaaaaaaaaaaaaaaa',7,'587;588;',1,'管理员',1366623496,0,1),(61,'2013-0001','/doc/personal/','XXXX','XXXXXXXX',1,'589;590;591;',1,'管理员',1366709016,0,1),(62,'2013-0001','/doc/common/','文档上传','XXXXXXXXXXXXX',7,'593;594;595;',1,'管理员',1367022627,0,1);

#
# Source for table "think_duty"
#

DROP TABLE IF EXISTS `think_duty`;
CREATE TABLE `think_duty` (
  `id` smallint(3) NOT NULL AUTO_INCREMENT,
  `code` varchar(20) NOT NULL,
  `name` varchar(50) NOT NULL,
  `sort` varchar(20) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `remark` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

#
# Data for table "think_duty"
#

INSERT INTO `think_duty` VALUES (14,'P001','采购员','',1,'采购员'),(15,'S001','业务员','',1,'');

#
# Source for table "think_file"
#

DROP TABLE IF EXISTS `think_file`;
CREATE TABLE `think_file` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `savename` varchar(100) NOT NULL,
  `size` varchar(20) NOT NULL,
  `extension` varchar(20) NOT NULL,
  `node_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `create_time` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=596 DEFAULT CHARSET=utf8;

#
# Data for table "think_file"
#

INSERT INTO `think_file` VALUES (563,'20130305_080944_2013-03-05_08-09-44-000.jpg','201304/516bf385b22ae.jpg','83751','jpg',0,1,1366029189,0),(564,'20130305_080958_2013-03-05_08-09-58-000.jpg','201304/516bf385d841b.jpg','61663','jpg',0,1,1366029189,0),(565,'20130305_081008_2013-03-05_08-10-08-000.jpg','201304/516bf4c261749.jpg','74636','jpg',0,1,1366029506,0),(566,'20130305_080958_2013-03-05_08-09-58-000.jpg','201304/516c081ac05f5.jpg','61663','jpg',0,1,1366034458,0),(567,'20130305_080944_2013-03-05_08-09-44-000.jpg','201304/516c08441ed88.jpg','83751','jpg',0,1,1366034500,0),(568,'20130305_080958_2013-03-05_08-09-58-000.jpg','201304/516c08442f1f8.jpg','61663','jpg',0,1,1366034500,0),(569,'20130305_081008_2013-03-05_08-10-08-000.jpg','201304/516c08443f9a4.jpg','74636','jpg',0,1,1366034500,0),(570,'20130305_081017_2013-03-05_08-10-16-000.jpg','201304/516c084455e26.jpg','62119','jpg',0,1,1366034500,0),(571,'20130305_081023_2013-03-05_08-10-22-000.jpg','201304/516c08446c329.jpg','61369','jpg',0,1,1366034500,0),(572,'20130323_215634_2013-03-23_21-56-35-000.jpg','201304/516c084485609.jpg','31567','jpg',0,1,1366034500,0),(573,'20130323_215651_2013-03-23_21-56-51-000.jpg','201304/516c08449a390.jpg','31567','jpg',0,1,1366034500,0),(574,'C360_2012-09-21-19-35-05_2012-09-21_19-35-18-000.jpg','201304/516c0844b0602.jpg','258659','jpg',0,1,1366034500,0),(575,'C360_2012-09-21-19-35-12_2012-09-21_19-35-34-000.jpg','201304/516c0844c79bb.jpg','285590','jpg',0,1,1366034500,0),(576,'DSC_0001_2000-01-01_08-04-02-000.jpg','201304/516c0844dd355.jpg','648283','jpg',0,1,1366034500,0),(577,'20130305_081023_2013-03-05_08-10-22-000.jpg','201304/516c08bdf1893.jpg','61369','jpg',0,1,1366034621,0),(578,'2012-12-06_13-12-20_517959_org.jpg','201304/5174f9af1f6d1.jpg','422420','jpg',0,1,1366620591,0),(579,'IMG_20121124_161517.jpg','201304/5174f9af4131d.jpg','171064','jpg',0,1,1366620591,0),(580,'IMG_20121124_162058.jpg','201304/5174f9af60ff4.jpg','73861','jpg',0,1,1366620591,0),(581,'2012-12-06_13-12-20_517959_org.jpg','201304/5174fa5e20eec.jpg','422420','jpg',0,1,1366620766,0),(582,'IMG_20121124_161517.jpg','201304/5174fa5e3e922.jpg','171064','jpg',0,1,1366620766,0),(583,'IMG_20121124_162058.jpg','201304/5174fa5e5d348.jpg','73861','jpg',0,1,1366620766,0),(584,'2012-12-06_13-12-20_517959_org.jpg','201304/5174faddc7b2e.jpg','422420','jpg',0,1,1366620893,0),(585,'IMG_20121124_161517.jpg','201304/5174fadde660a.jpg','171064','jpg',0,1,1366620893,0),(586,'IMG_20121124_162058.jpg','201304/5174fade13ad9.jpg','73861','jpg',0,1,1366620894,0),(587,'IMG_20121124_161517.jpg','file/201304/51750506c0ba4.jpg','171064','jpg',0,1,1366623494,0),(588,'IMG_20121124_162058.jpg','file/201304/51750506e468c.jpg','73861','jpg',0,1,1366623494,0),(589,'2012-12-06_13-12-20_517959_org.jpg','file/201304/517653146e3c5.jpg','422420','jpg',0,1,1366709012,0),(590,'IMG_20121124_161517.jpg','file/201304/517653148c6ff.jpg','171064','jpg',0,1,1366709012,0),(591,'IMG_20121124_162058.jpg','file/201304/51765314b48db.jpg','73861','jpg',0,1,1366709012,0),(592,'image001.png','file/201304/517a2ab91564d.png','2581','png',0,1,1366960825,0),(593,'2.png','file/201304/517b1c1fbf71f.png','26579','png',0,1,1367022623,0),(594,'3.png','file/201304/517b1c1fdf781.png','31899','png',0,1,1367022623,0),(595,'4.png','file/201304/517b1c200fdab.png','22600','png',0,1,1367022624,0);

#
# Source for table "think_flow"
#

DROP TABLE IF EXISTS `think_flow`;
CREATE TABLE `think_flow` (
  `id` smallint(4) unsigned NOT NULL AUTO_INCREMENT,
  `doc_no` varchar(20) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `confirm` varchar(200) NOT NULL,
  `confirm_name` text NOT NULL,
  `consult` varchar(200) NOT NULL,
  `consult_name` text NOT NULL,
  `refer` varchar(200) NOT NULL,
  `refer_name` text NOT NULL,
  `type` varchar(20) NOT NULL,
  `add_file` varchar(200) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_name` varchar(20) NOT NULL,
  `dept_id` int(11) NOT NULL,
  `dept_name` varchar(20) NOT NULL,
  `create_date` varchar(10) NOT NULL,
  `create_time` int(11) unsigned NOT NULL,
  `update_time` int(11) unsigned NOT NULL,
  `step` int(11) NOT NULL,
  `status` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  FULLTEXT KEY `refer_name` (`refer_name`)
) ENGINE=MyISAM AUTO_INCREMENT=71 DEFAULT CHARSET=utf8;

#
# Data for table "think_flow"
#

INSERT INTO `think_flow` VALUES (66,'生产2起案2013-0001','1111111111111','起案1111111111111111111111','leader|test1|','\r\n\t\t\t\t\t\t\t\t\t\t&nbsp;\r\n\t\t\t\t\t\t\t\t\t<span title=\"leader@smeoa.com\" emp_no=\"leader\">领导 <leader@smeoa.com> </leader@smeoa.com><b>→</b>\t</span><span title=\"test1@smeoa.com\" emp_no=\"test1\">test <test1@smeoa.com> </test1@smeoa.com>\t</span>','','\r\n\t\t\t\t\t\t\t\t\t\t\t&nbsp;\r\n\t\t\t\t\t\t\t\t\t','','\r\n\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t','1','',1,'管理员',12,'生产2科','',1365687773,0,20,1),(67,'生产2起案2013-0002','xxxxxxxxxx','起案xxxxxxxxxxxxxxxxxxxxxxxx','admin|demo|','\r\n\t\t\t\t\t\t\t\t\t\t&nbsp;\r\n\t\t\t\t\t\t\t\t\t<span title=\"\" emp_no=\"admin\">管理员 / 经理1 &lt;&gt; <b>→</b>\t</span><span title=\"demo@smeoa.com\" emp_no=\"demo\">演示 / 部长 <demo@smeoa.com> </demo@smeoa.com>\t</span>','','\r\n\t\t\t\t\t\t\t\t\t\t\t&nbsp;\r\n\t\t\t\t\t\t\t\t\t','','\r\n\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t','1','',1,'管理员',12,'生产2科','',1366362033,0,21,1),(68,'生产20003','固定流程111','固定流程xxxxxxxxxxxxxxxxxxxx','','\r\n\t\t\t\t\t\t\t\t\t\t<span emp_no=\"dgp_5_2\">总经理-副总经理 <b>→</b>   </span><span emp_no=\"dp_5_2\">总经理-副总经理 <b>→</b>   </span><span emp_no=\"dept_10\">会计科    </span>&nbsp;\r\n\t\t\t\t\t\t\t\t\t','','\r\n\t\t\t\t\t\t\t\t\t\t\t&nbsp;\r\n\t\t\t\t\t\t\t\t\t','','\r\n\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t','5','',1,'管理员',12,'生产2科','',1366363268,0,20,1),(69,'生产2起案2013-003','qqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqq','起案qqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqq','leader|','\r\n\t\t\t\t\t\t\t\t\t\t<span emp_no=\"dgp_5_2\">总经理-副总经理 <b>→</b>   </span><span emp_no=\"dp_6_2\">财务部-副总经理    </span>&nbsp;\r\n\t\t\t\t\t\t\t\t\t','','\r\n\t\t\t\t\t\t\t\t\t\t\t&nbsp;\r\n\t\t\t\t\t\t\t\t\t','','\r\n\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t','1','581;582;583;',1,'管理员',12,'生产2科','',1366620771,0,20,1),(70,'生产2起案2013-004','2012-04-22','2012-04-22','leader|','\r\n\t\t\t\t\t\t\t\t\t\t<span emp_no=\"dgp_5_2\">总经理-副总经理 <b>→</b>   </span><span emp_no=\"dp_6_2\">财务部-副总经理    </span>&nbsp;\r\n\t\t\t\t\t\t\t\t\t','','\r\n\t\t\t\t\t\t\t\t\t\t\t&nbsp;\r\n\t\t\t\t\t\t\t\t\t','','\r\n\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t','1','584;585;586;',1,'管理员',12,'生产2科','',1366620935,0,20,1);

#
# Source for table "think_flow_log"
#

DROP TABLE IF EXISTS `think_flow_log`;
CREATE TABLE `think_flow_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `flow_id` int(11) NOT NULL,
  `emp_no` varchar(20) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_name` varchar(20) NOT NULL,
  `step` int(11) NOT NULL,
  `result` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `comment` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=89 DEFAULT CHARSET=utf8;

#
# Data for table "think_flow_log"
#

INSERT INTO `think_flow_log` VALUES (84,66,'leader',NULL,'',21,NULL,1,1365687773,0,''),(85,67,'admin',1,'管理员',21,1,1,1366362033,1366857372,'ccccc'),(86,69,'leader',NULL,'',21,NULL,1,1366620771,0,''),(87,70,'leader',NULL,'',21,NULL,1,1366620935,0,''),(88,67,'demo',NULL,'',22,NULL,1,1366857372,0,'');

#
# Source for table "think_flow_type"
#

DROP TABLE IF EXISTS `think_flow_type`;
CREATE TABLE `think_flow_type` (
  `id` smallint(3) unsigned NOT NULL AUTO_INCREMENT,
  `group` varchar(20) NOT NULL,
  `type` int(11) NOT NULL,
  `doc_no_format` varchar(50) NOT NULL,
  `name` varchar(25) NOT NULL,
  `short` varchar(20) NOT NULL,
  `content` text NOT NULL,
  `confirm` varchar(100) NOT NULL,
  `confirm_name` text NOT NULL,
  `consult` varchar(100) NOT NULL,
  `consult_name` text NOT NULL,
  `refer` varchar(100) NOT NULL,
  `refer_name` text NOT NULL,
  `create_time` int(11) unsigned NOT NULL,
  `update_time` int(11) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `sort` smallint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

#
# Data for table "think_flow_type"
#

INSERT INTO `think_flow_type` VALUES (1,'起案',0,'{DEPT}{SHORT}{YYYY}-{###}','起案','起案','起案','dgp_5_2|dp_6_2|','<span emp_no=\"dgp_5_2\">总经理-副总经理 <b>→</b>   </span><span emp_no=\"dp_6_2\">财务部-副总经理    </span>','','','','',0,1366708126,1,0),(5,'固定',1,'{DEPT}{####}','固定流程','固定','固定流程','dgp_5_2|dp_5_2|dept_10|','<span emp_no=\"dgp_5_2\">总经理-副总经理 <b>→</b>   </span><span emp_no=\"dp_5_2\">总经理-副总经理 <b>→</b>   </span><span emp_no=\"dept_10\">会计科    </span>','','','','',1346553291,1366708686,1,0);

#
# Source for table "think_folder"
#

DROP TABLE IF EXISTS `think_folder`;
CREATE TABLE `think_folder` (
  `id` smallint(3) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL,
  `folder` varchar(20) NOT NULL,
  `public` int(11) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `admin` varchar(200) NOT NULL,
  `write` varchar(200) NOT NULL,
  `read` varchar(200) NOT NULL,
  `sort` varchar(20) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `remark` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

#
# Data for table "think_folder"
#

INSERT INTO `think_folder` VALUES (1,0,'/doc/personal/',2,1,'学习资料','','','','',1,''),(2,0,'/doc/personal/',2,1,'微博营销','','','','',1,''),(3,0,'/doc/personal/',2,1,'客户管理','','','','',1,''),(7,0,'/doc/common/',1,1,'公司规定','管理员 / 经理1  |admin;演示 / 部长  |demo;员工 / 经理1  |member;领导 / 副总经理  |leader;','','','',1,''),(8,0,'mail/mail_list',2,1,'重要','','','','1',1,''),(9,0,'mail/mail_list',2,1,'已完成','','','','2',1,''),(10,0,'mail/mail_list',2,1,'供应商','','','','3',1,''),(11,0,'/doc/common/',1,1,'abc','','','','',1,''),(14,0,'/notice/folder/',1,1,'公司新闻','','','','',1,''),(15,0,'/notice/folder/',1,1,'通告','管理员 / 经理1  |admin;演示 / 部长  |demo;','','','',1,''),(16,0,'/notice/folder/',1,1,'其他等等','','','','',1,''),(17,0,'/forum/folder/',1,1,'论坛1','管理员  |admin;','','','',1,''),(18,0,'/forum/folder/',1,1,'论坛2','','','','',1,''),(19,0,'/doc/personal/',2,2,'演示用户个人文件夹','','','','',1,'');

#
# Source for table "think_forum"
#

DROP TABLE IF EXISTS `think_forum`;
CREATE TABLE `think_forum` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `folder` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_name` varchar(20) NOT NULL,
  `title` varchar(20) NOT NULL,
  `content` text NOT NULL,
  `views` int(11) NOT NULL,
  `reply` int(11) NOT NULL,
  `order` int(11) NOT NULL,
  `add_file` varchar(200) NOT NULL,
  `last_post` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

#
# Data for table "think_forum"
#

INSERT INTO `think_forum` VALUES (8,17,1,'管理员','发表主题 ','<span>发表主题</span>',7,0,0,'',0,1,1366872802,0);

#
# Source for table "think_gi"
#

DROP TABLE IF EXISTS `think_gi`;
CREATE TABLE `think_gi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gi_no` varchar(20) NOT NULL DEFAULT '',
  `po_no` varchar(20) DEFAULT NULL,
  `supplier` int(11) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `status` tinyint(3) DEFAULT NULL,
  `warehouse` int(10) DEFAULT NULL,
  `gi_date` date DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_name` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;

#
# Data for table "think_gi"
#


#
# Source for table "think_gi_item"
#

DROP TABLE IF EXISTS `think_gi_item`;
CREATE TABLE `think_gi_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gi_no` varchar(20) DEFAULT NULL,
  `mat_no` varchar(255) DEFAULT NULL,
  `in_qty` decimal(10,3) DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `order_qty` decimal(10,3) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=36 DEFAULT CHARSET=utf8;

#
# Data for table "think_gi_item"
#


#
# Source for table "think_mail"
#

DROP TABLE IF EXISTS `think_mail`;
CREATE TABLE `think_mail` (
  `id` smallint(4) unsigned NOT NULL AUTO_INCREMENT,
  `folder` int(11) NOT NULL,
  `mid` varchar(200) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `add_file` varchar(200) DEFAULT NULL,
  `from` varchar(2000) DEFAULT NULL,
  `to` varchar(2000) DEFAULT NULL,
  `reply_to` varchar(2000) DEFAULT NULL,
  `cc` varchar(2000) DEFAULT NULL,
  `read` tinyint(1) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_name` varchar(20) NOT NULL,
  `create_time` int(11) unsigned NOT NULL,
  `update_time` int(11) unsigned NOT NULL,
  `status` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `mid` (`mid`)
) ENGINE=MyISAM AUTO_INCREMENT=1029 DEFAULT CHARSET=utf8;

#
# Data for table "think_mail"
#

INSERT INTO `think_mail` VALUES (1018,1,'<2987885b0c49e7b8fedc014d1ba41f0e@demo.smeoa.com>','省顿饭','随碟附送地方是',NULL,'smeoa_admin|smeoa_admin@163.com;','管理员 / 经理1|smeoa_admin@163.com;','smeoa_admin|smeoa_admin@163.com;',NULL,1,1,'',1366703880,0,1),(1019,1,'<010b23244c813eef30ed3f5aab9b25ec@demo.smeoa.com>','阿斯达','阿斯达',NULL,'smeoa_admin|smeoa_admin@163.com;','管理员|smeoa_admin@163.com;','smeoa_admin|smeoa_admin@163.com;',NULL,1,1,'',1366698505,0,1),(1020,1,'<5167AD70.AC0F83.19561@163smtp10>','系统退信','<!-- saved from url=(0022)http://internet.e-mail --> \r\n<html> \r\n<head> \r\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=gb2312\" /> \r\n<meta name=\"Keywords\" content=\"\" /> \r\n<meta name=\"Description\" content=\"\" /> \r\n<title></title> \r\n \r\n<style type=\"text/css\"> \r\n<!--\r\n \r\nbody,div,dl,dt,dd,h1,h2,h3,h4,h5,h6,pre,form,fieldset,input,textarea,p,blockquote,th,td{padding:0; margin:0; }\r\nfieldset,img{border:0; }\r\ntable{border-collapse:collapse; border-spacing:0; }\r\nol,ul{}\r\naddress,caption,cite,code,dfn,em,strong,th,var{font-weight:normal; font-style:normal; }\r\ncaption,th{text-align:left; }\r\nh1,h2,h3,h4,h5,h6{font-weight:bold; font-size:100%; }\r\nq:before,q:after{content:\'\'; }\r\nabbr,acronym{border:0; }\r\n \r\na:link,a:visited{}\r\na:hover{}\r\n \r\n.Bdy{font-size:14px; font-family:verdana,Arial,Helvetica,sans-serif; padding:20px;}\r\nh1{font-size:24px; color:#cd0021; padding-bottom:30px;}\r\np{}\r\n \r\n.Tb_mWp{border:1px solid #ddd; border-right:none; border-bottom:none; table-layout:fixed;}\r\n    .Tb_mWp th,.Tb_mWp td{border-right:1px solid #ddd; border-bottom:1px solid #ddd; padding:8px 4px;}\r\n    .Tb_mWp th{font-size:14px; text-align:right; width:130px; font-weight:bold; background:#f6f6f6; color:#666;}\r\n    .Tb_mWp td{font-size:14px; padding-left:10px; word-break:break-all;}\r\n \r\n.Tb_miWp{ margin-top:-2px; margin-left:-1px; float:left; table-layout:fixed;}\r\n    .Tb_miWp th,.Tb_miWp td{border-left:1px solid #eee; border-top:1px solid #eee; border-right:none; border-bottom:none; font-size:12px;}\r\n    .Tb_miWp th{width:68px; background:#f8f8f8;}\r\n \r\n.tr_Mi{}\r\n    .tr_Mi th{}\r\n    .tr_Mi td{}\r\n \r\n.tr_Rz{}\r\n    .tr_Rz th{}\r\n    .tr_Rz td{ background:#fff4f6;}\r\n        .tr_Rz .infoTt{ color:#cd0021; font-weight:bold; line-height:18px;}\r\n        .tr_Rz .infoDcr{ padding-top:4px; color:#999; line-height:18px;}\r\n \r\n.tr_Sr{}\r\n    .tr_Sr th{}\r\n    .tr_Sr td{background:#f4fff4;}\r\n \r\n.ul_lstWp{margin-left:-20px;}\r\n.ul_lst{padding-top:0px; padding-bottom:0px; margin-top:6px; margin-bottom:6px;}\r\n.ul_lst li{padding-top:3px; padding-bottom:3px;}\r\n \r\n \r\n \r\n \r\n-->\r\n</style> \r\n \r\n</head> \r\n \r\n<body class=\"Bdy\"> \r\n \r\n<h1>抱歉，您的邮件被退回来了……</h1> \r\n \r\n<div class=\"Con\"> \r\n<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"Tb_mWp\"> \r\n    \r\n    <!-- 原邮件信息 --> \r\n    <tr class=\"tr_Mi\"> \r\n        <th nowrap>原邮件信息：</th> \r\n        <td style=\"padding:0px; font-size:1px; line-height:1px; overflow:hidden; vertical-align:top;\"> \r\n\r\n            <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"Tb_miWp\"> \r\n                <tr> \r\n                    <th nowrap>时　间：</th> \r\n                    <td>2013-04-11 14:29:05</td> \r\n                </tr> \r\n　                <tr> \r\n                    <th nowrap>主　题：</th> \r\n                    <td>fsfd</td>\r\n                </tr> \r\n                <tr> \r\n                    <th nowrap>收件人：</th> \r\n                    <td>leader@smeoa.com</td> \r\n                </tr> \r\n                <tr style=\"display:none;\"><!--  --> \r\n                    <th nowrap>抄　送：</th> \r\n                    <td>xxx</td> \r\n                </tr> \r\n                <tr style=\"display:none;\"> \r\n                    <th nowrap>密　送：</th><!--  --> \r\n                    <td>yyy</td> \r\n                </tr> \r\n            </table> \r\n            <!-- 原邮件信息列表 End --> \r\n \r\n \r\n \r\n \r\n        </td> \r\n    </tr> \r\n \r\n    <!-- 退信原因 --> \r\n    <tr class=\"tr_Rz\"> \r\n        <th nowrap>退信原因：</th> \r\n        <td> \r\n            <!-- wayhome 2009-3-9 --> \r\n            <div class=\"infoTt\">邮差小易抱歉地通知您，不知道是什么原因，对方退信了。</div> \r\n            <div class=\"infoDcr\">英文说明:rcpt handle timeout.(rcpt&nbsp;handle&nbsp;timeout)</div> \r\n        </td> \r\n    </tr> \r\n \r\n    <!-- 解决方案 --> \r\n    <tr class=\"tr_Sr\"> \r\n        <th nowrap>建议解决方案：</th> \r\n        <td> \r\n            <div class=\"ul_lstWp\"> \r\n            <ul class=\"ul_lst\"> \r\n                <li>邮差小易温馨提示：建议您联系对方的管理员，请他高抬贵手帮您解决吧。</li> \r\n                <li>如果您有其他退信问题，欢迎向网易邮件中心<a href=\"http://feedback.mail.126.com/antispam/report.php?&BounceReason=rcpt+handle+timeout.%28rcpt%26nbsp%3Bhandle%26nbsp%3Btimeout%29&BouncedRcpt=leader%40smeoa.com&ClusterID=&OrgSubject=fsfd&SendDate=1365661745&Sender=smeoa_admin%40163.com&TransID=DsCowEDpnE8wWGZRA_z1AA--.1558S2.B22940\" target=\"_blank\">发送退信报告</a></li>\r\n            </ul> \r\n            </div>        \r\n        </td> \r\n    </tr> \r\n\r\n</table> \r\n \r\n</div> \r\n \r\n\r\n<!-- footer -->\r\n<span>\r\n<br>----------------<br>This message is generated by Coremail.<br>您收到的是来自 Coremail 专业邮件系统的信件.<br><br>\r\n</span>\r\n</body> \r\n</html>\r\n',NULL,'Postmaster|Postmaster@163.com;','smeoa_admin|smeoa_admin@163.com;','Postmaster|Postmaster@163.com;',NULL,1,1,'',1365749104,0,1),(1021,1,'<51667590.9D86DF.26923@163smtp11>','系统退信','<!-- saved from url=(0022)http://internet.e-mail --> \r\n<html> \r\n<head> \r\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=gb2312\" /> \r\n<meta name=\"Keywords\" content=\"\" /> \r\n<meta name=\"Description\" content=\"\" /> \r\n<title></title> \r\n \r\n<style type=\"text/css\"> \r\n<!--\r\n \r\nbody,div,dl,dt,dd,h1,h2,h3,h4,h5,h6,pre,form,fieldset,input,textarea,p,blockquote,th,td{padding:0; margin:0; }\r\nfieldset,img{border:0; }\r\ntable{border-collapse:collapse; border-spacing:0; }\r\nol,ul{}\r\naddress,caption,cite,code,dfn,em,strong,th,var{font-weight:normal; font-style:normal; }\r\ncaption,th{text-align:left; }\r\nh1,h2,h3,h4,h5,h6{font-weight:bold; font-size:100%; }\r\nq:before,q:after{content:\'\'; }\r\nabbr,acronym{border:0; }\r\n \r\na:link,a:visited{}\r\na:hover{}\r\n \r\n.Bdy{font-size:14px; font-family:verdana,Arial,Helvetica,sans-serif; padding:20px;}\r\nh1{font-size:24px; color:#cd0021; padding-bottom:30px;}\r\np{}\r\n \r\n.Tb_mWp{border:1px solid #ddd; border-right:none; border-bottom:none; table-layout:fixed;}\r\n    .Tb_mWp th,.Tb_mWp td{border-right:1px solid #ddd; border-bottom:1px solid #ddd; padding:8px 4px;}\r\n    .Tb_mWp th{font-size:14px; text-align:right; width:130px; font-weight:bold; background:#f6f6f6; color:#666;}\r\n    .Tb_mWp td{font-size:14px; padding-left:10px; word-break:break-all;}\r\n \r\n.Tb_miWp{ margin-top:-2px; margin-left:-1px; float:left; table-layout:fixed;}\r\n    .Tb_miWp th,.Tb_miWp td{border-left:1px solid #eee; border-top:1px solid #eee; border-right:none; border-bottom:none; font-size:12px;}\r\n    .Tb_miWp th{width:68px; background:#f8f8f8;}\r\n \r\n.tr_Mi{}\r\n    .tr_Mi th{}\r\n    .tr_Mi td{}\r\n \r\n.tr_Rz{}\r\n    .tr_Rz th{}\r\n    .tr_Rz td{ background:#fff4f6;}\r\n        .tr_Rz .infoTt{ color:#cd0021; font-weight:bold; line-height:18px;}\r\n        .tr_Rz .infoDcr{ padding-top:4px; color:#999; line-height:18px;}\r\n \r\n.tr_Sr{}\r\n    .tr_Sr th{}\r\n    .tr_Sr td{background:#f4fff4;}\r\n \r\n.ul_lstWp{margin-left:-20px;}\r\n.ul_lst{padding-top:0px; padding-bottom:0px; margin-top:6px; margin-bottom:6px;}\r\n.ul_lst li{padding-top:3px; padding-bottom:3px;}\r\n \r\n \r\n \r\n \r\n-->\r\n</style> \r\n \r\n</head> \r\n \r\n<body class=\"Bdy\"> \r\n \r\n<h1>抱歉，您的邮件被退回来了……</h1> \r\n \r\n<div class=\"Con\"> \r\n<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"Tb_mWp\"> \r\n    \r\n    <!-- 原邮件信息 --> \r\n    <tr class=\"tr_Mi\"> \r\n        <th nowrap>原邮件信息：</th> \r\n        <td style=\"padding:0px; font-size:1px; line-height:1px; overflow:hidden; vertical-align:top;\"> \r\n\r\n            <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"Tb_miWp\"> \r\n                <tr> \r\n                    <th nowrap>时　间：</th> \r\n                    <td>2013-04-10 16:18:07</td> \r\n                </tr> \r\n　                <tr> \r\n                    <th nowrap>主　题：</th> \r\n                    <td>test</td>\r\n                </tr> \r\n                <tr> \r\n                    <th nowrap>收件人：</th> \r\n                    <td>zhang@zhang.com</td> \r\n                </tr> \r\n                <tr style=\"display:none;\"><!--  --> \r\n                    <th nowrap>抄　送：</th> \r\n                    <td>xxx</td> \r\n                </tr> \r\n                <tr style=\"display:none;\"> \r\n                    <th nowrap>密　送：</th><!--  --> \r\n                    <td>yyy</td> \r\n                </tr> \r\n            </table> \r\n            <!-- 原邮件信息列表 End --> \r\n \r\n \r\n \r\n \r\n        </td> \r\n    </tr> \r\n \r\n    <!-- 退信原因 --> \r\n    <tr class=\"tr_Rz\"> \r\n        <th nowrap>退信原因：</th> \r\n        <td> \r\n            <!-- wayhome 2009-3-9 --> \r\n            <div class=\"infoTt\">邮差小易抱歉地通知您，不知道是什么原因，对方退信了。</div> \r\n            <div class=\"infoDcr\">英文说明:rcpt handle timeout.(rcpt&nbsp;handle&nbsp;timeout)</div> \r\n        </td> \r\n    </tr> \r\n \r\n    <!-- 解决方案 --> \r\n    <tr class=\"tr_Sr\"> \r\n        <th nowrap>建议解决方案：</th> \r\n        <td> \r\n            <div class=\"ul_lstWp\"> \r\n            <ul class=\"ul_lst\"> \r\n                <li>邮差小易温馨提示：建议您联系对方的管理员，请他高抬贵手帮您解决吧。</li> \r\n                <li>如果您有其他退信问题，欢迎向网易邮件中心<a href=\"http://feedback.mail.126.com/antispam/report.php?&BounceReason=rcpt+handle+timeout.%28rcpt%26nbsp%3Bhandle%26nbsp%3Btimeout%29&BouncedRcpt=zhang%40zhang.com&ClusterID=&OrgSubject=test&SendDate=1365581887&Sender=smeoa_admin%40163.com&TransID=D8CowED5b3o_IGVRr%2BOYAA--.1305S2.B86898\" target=\"_blank\">发送退信报告</a></li>\r\n            </ul> \r\n            </div>        \r\n        </td> \r\n    </tr> \r\n\r\n</table> \r\n \r\n</div> \r\n \r\n\r\n<!-- footer -->\r\n<span>\r\n<br>----------------<br>This message is generated by Coremail.<br>您收到的是来自 Coremail 专业邮件系统的信件.<br><br>\r\n</span>\r\n</body> \r\n</html>\r\n',NULL,'Postmaster|Postmaster@163.com;','smeoa_admin|smeoa_admin@163.com;','Postmaster|Postmaster@163.com;',NULL,1,1,'',1365669264,0,1),(1022,1,'<7ed32f64dfb19951f302bcb42f035f23@demo.smeoa.com>','fsfd','sdfsdf',NULL,'smeoa_admin|smeoa_admin@163.com;','管理员|smeoa_admin@163.com;','smeoa_admin|smeoa_admin@163.com;',NULL,1,1,'',1365661743,0,1),(1023,1,'<303222035.56665658.1365469563830.JavaMail.phone@service.netease.com>','全新体验，手机也能玩转网易邮箱','<table width=\"606\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" background=\"http://mimg.127.net/xm/mail_res/common/bg.png\" style=\"font-family:verdana;font-size:14px;line-height:180%\">\r\n  <tbody>\r\n\t<!-- banner -->\r\n    <tr>\r\n      \t<td colspan=\"3\" style=\"font-size:0;line-height:0\">\r\n\t\t\t<table width=\"606\" height=\"66\" background=\"http://mimg.127.net/xm/mail_res/common/top.png\"  cellpadding=\"0\" cellspacing=\"0\" border=\"0\">\r\n\t\t\t\t<tr>\r\n\t\t\t\t\t<td width=\"40\">&nbsp;</td>\r\n\t\t\t\t\t<td height=\"61\" valign=\"top\">\r\n\t\t\t\t\t\t<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" height=\"61\">\r\n\t\t\t\t\t\t\t<tr>\r\n\t\t\t\t\t\t\t\t<td height=\"25\">&nbsp;</td>\r\n\t\t\t\t\t\t\t\t<td>&nbsp;</td>\r\n\t\t\t\t\t\t\t\t<td>&nbsp;</td>\r\n\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t\t<tr>\r\n\t\t\t\t\t\t\t\t<td valign=\"top\" width=\"106\"><a href=\"http://mail.163.com/\" target=\"_blank\"><img src=\"http://mimg.127.net/logo/163logo-s.gif\" alt=\"163网易免费邮\" border=\"0\"/></a></td>\r\n\t\t\t\t\t\t\t\t<td valign=\"top\" width=\"106\"><a href=\"http://www.126.com/\" target=\"_blank\"><img src=\"http://mimg.127.net/logo/126logo-s.gif\" alt=\"126网易免费邮\" border=\"0\"/></a></td>\r\n\t\t\t\t\t\t\t\t<td valign=\"top\" width=\"106\"><a href=\"http://www.yeah.net/\" target=\"_blank\"><img src=\"http://mimg.127.net/logo/yeahlogo-s.gif\" alt=\"yeah.net网易免费邮\" border=\"0\"/></a></td>\r\n\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t</table>\r\n\t\t\t\t\t</td>\r\n\t\t\t\t<td width=\"40\">&nbsp;</td>\r\n\t\t\t\t</tr>\r\n\t\t\t</table>\r\n        </td>\r\n    </tr>\r\n\t<tr>\r\n\t\t<td height=\"161\" colspan=\"3\">\r\n\t\t\t<table width=\"598\" height=\"161\" valign=\"top\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" background=\"http://mimg.127.net/xm/mail_res/120612_mobilewel/top_1.jpg\">\r\n\t\t\t\t<tbody>\r\n\t\t\t\t\t<tr>\r\n\t\t\t\t\t\t<td valign=\"top\">\r\n\t\t\t\t\t\t\t<div style=\"padding:80px 0 0 0px;\">\t\t\t\t\t\r\n\t\t\t\t\t\t\t<p style=\"padding:0;margin:0;color:#666;font-size:12px;text-align:center;line-height:20px;\">网易邮箱全面登陆掌上设备，只要简单设置，就能玩转网易邮箱！</p>\r\n\t\t\t\t\t\t\t<p style=\"padding:0;margin:0;color:#666;font-size:12px;text-align:center;line-height:20px;\">现在起，邮件跟你走，手指玩不停，立即选择你的玩转方式吧！</p>\r\n\t\t\t\t\t\t\t</div>\r\n\t\t\t\t\t\t</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t</tbody>\r\n\t\t\t</table>\t\t\r\n\t\t</td>\r\n\t </tr>\r\n\t<tr>\r\n\t\t<td height=\"322\" colspan=\"3\">\r\n\t\t\t\t<table width=\"598\" height=\"322\" valign=\"top\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" background=\"http://mimg.127.net/xm/mail_res/120612_mobilewel/pic_1.jpg\">\r\n\t\t\t\t\t<tbody>\r\n\t\t\t\t\t\t<tr>\r\n\t\t\t\t\t\t\t<td valign=\"top\">\r\n\t\t\t\t\t\t\t\t<div style=\"padding:0;\">\t\t\t\t\t\r\n\t\t\t\t\t\t\t\t<p style=\"padding:0;margin:0;display:none;\">1.手机号码就是邮箱号码</p>\r\n\t\t\t\t\t\t\t\t</div>\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t</tbody>\r\n\t\t\t\t</table>\t\t\r\n\t\t\t</td>\r\n\t </tr>\r\n\t<tr>\r\n\t\t<td height=\"215\" colspan=\"3\">\r\n\t\t\t<table width=\"598\" height=\"215\" valign=\"top\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" background=\"http://mimg.127.net/xm/mail_res/120612_mobilewel/pic_2.jpg\">\r\n\t\t\t\t<tbody>\r\n\t\t\t\t\t<tr>\r\n\t\t\t\t\t\t<td valign=\"top\">\r\n\t\t\t\t\t\t\t<div style=\"padding:60px 0 0 60px;\">\t\t\t\t\t\r\n\t\t\t\t\t\t\t<p style=\"padding:0;margin:0;color:#666;font-size:12px;line-height:20px;\">手机号码就是您的邮箱账号</p>\r\n\t\t\t\t\t\t\t<p style=\"padding:0;margin:0;color:#666;font-size:12px;line-height:20px;\">还有免费的邮件到达短信提醒</p>\r\n\t\t\t\t\t\t\t</div>\r\n\t\t\t\t\t\t\t<div style=\"padding:10px 0 0 60px;\">\r\n\t\t\t\t\t\t\t\t<a sys=1 interface=OptionInterface param=optionOutLink.mobile_set_option href=\"http://count.mail.163.com/statistics/NhASrh.do?product=post_mobilewel&domain=163.com&area=mobile_set_option\" target=\"_blank\"><img src=\"http://mimg.127.net/xm/mail_res/120612_mobilewel/btn_1.jpg\" alt=\"立即免费激活\" border=\"0\"/></a>\r\n\t\t\t\t\t\t\t</div>\r\n\t\t\t\t\t\t</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t</tbody>\r\n\t\t\t</table>\t\t\r\n\t\t</td>\r\n\t </tr>\r\n\t<tr>\r\n\t\t<td height=\"247\" colspan=\"3\">\r\n\t\t\t<table width=\"598\" height=\"247\" valign=\"top\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" background=\"http://mimg.127.net/xm/mail_res/120612_mobilewel/pic_3.jpg\">\r\n\t\t\t\t<tbody>\r\n\t\t\t\t\t<tr>\r\n\t\t\t\t\t\t<td valign=\"top\">\r\n\t\t\t\t\t\t\t<div style=\"padding:70px 0 0 60px;\">\r\n\t\t\t\t\t\t\t<p style=\"padding:0;margin:0;display:none;\">2.手机浏览器登陆，智能适配</p>\r\n\t\t\t\t\t\t\t<p style=\"padding:0;margin:0;color:#666;font-size:12px;line-height:20px;\">访问<span style=\"font-weight:bold;color:#AA0000;\">mail.163.com</span></p>\r\n\t\t\t\t\t\t\t<p style=\"padding:0;margin:0;color:#666;font-size:12px;line-height:20px;\">网易邮箱将会根据您的手机自动适配<span style=\"font-weight:bold;color:#AA0000;\">智能版</span>和<span style=\"font-weight:bold;color:#AA0000;\">标准版</span></p>\r\n\t\t\t\t\t\t\t</div>\r\n\t\t\t\t\t\t\t<div style=\"padding:60px 0 0 60px;\">\r\n\t\t\t\t\t\t\t\t<a href=\"http://count.mail.163.com/statistics/59H4zC.do?product=post_mobilewel&domain=163.com\" target=\"_blank\"><img src=\"http://mimg.127.net/xm/mail_res/120612_mobilewel/btn_2.jpg\" alt=\"了解详情\" border=\"0\"/></a>\r\n\t\t\t\t\t\t\t</div>\r\n\t\t\t\t\t\t</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t</tbody>\r\n\t\t\t</table>\t\t\r\n\t\t</td>\r\n\t </tr>\r\n\t<tr>\r\n\t\t<td height=\"214\" colspan=\"3\">\r\n\t\t\t<table width=\"598\" height=\"214\" valign=\"top\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" background=\"http://mimg.127.net/xm/mail_res/120612_mobilewel/pic_4.jpg\">\r\n\t\t\t\t<tbody>\r\n\t\t\t\t\t<tr>\r\n\t\t\t\t\t\t<td valign=\"top\">\r\n\t\t\t\t\t\t\t<div style=\"padding:70px 0 0 60px;\">\r\n\t\t\t\t\t\t\t<p style=\"padding:0;margin:0;display:none;\">3.短信来提醒，邮件随身走</p>\r\n\t\t\t\t\t\t\t<p style=\"padding:0;margin:0;color:#666;font-size:12px;line-height:20px;\">开通随身邮，您可以享受随时短信提醒和发送邮件</p>\r\n\t\t\t\t\t\t\t<p style=\"padding:0;margin:0;color:#666;font-size:12px;line-height:20px;\">可以短信通知收件人的服务</p>\r\n\t\t\t\t\t\t\t</div>\r\n\t\t\t\t\t\t\t<div style=\"padding:30px 0 0 60px;\">\r\n\t\t\t\t\t\t\t\t<a sys=1 interface=OptionInterface param=optionOutLink.mobile_dxyy href=\"http://count.mail.163.com/statistics/NhASrh.do?product=post_mobilewel&domain=163.com&area=mobile_dxyy\" target=\"_blank\"><img src=\"http://mimg.127.net/xm/mail_res/120612_mobilewel/btn_2.jpg\" alt=\"了解详情\" border=\"0\"/></a>\r\n\t\t\t\t\t\t\t</div>\r\n\t\t\t\t\t\t</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t</tbody>\r\n\t\t\t</table>\t\t\r\n\t\t</td>\r\n\t </tr>\r\n\t<tr>\r\n\t\t<td height=\"196\" colspan=\"3\">\r\n\t\t\t<table width=\"598\" height=\"196\" valign=\"top\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" background=\"http://mimg.127.net/xm/mail_res/120612_mobilewel/pic_5.jpg\">\r\n\t\t\t\t<tbody>\r\n\t\t\t\t\t<tr>\r\n\t\t\t\t\t\t<td valign=\"top\">\r\n\t\t\t\t\t\t\t<div style=\"padding:70px 0 0 60px;\">\r\n\t\t\t\t\t\t\t<p style=\"padding:0;margin:0;display:none;\">4.苹果设备，一键轻松同步</p>\r\n\t\t\t\t\t\t\t<p style=\"padding:0;margin:0;color:#666;font-size:12px;line-height:20px;width:270px;\">不管是<span style=\"font-weight:bold;color:#AA0000;\">iPhone</span>还是<span style=\"font-weight:bold;color:#AA0000;\">iPad</span>，只需简单设置，就能实现邮件、日程管理、通讯录在网易邮箱和苹果设备的双向同步。</p>\r\n\t\t\t\t\t\t\t</div>\r\n\t\t\t\t\t\t\t<div style=\"padding:30px 0 0 60px;\">\r\n\t\t\t\t\t\t\t\t<a href=\"http://count.mail.163.com/statistics/hm5BB9.do?product=post_mobilewel&domain=163.com\" target=\"_blank\"><img src=\"http://mimg.127.net/xm/mail_res/120612_mobilewel/btn_2.jpg\" alt=\"了解详情\" border=\"0\"/></a>\r\n\t\t\t\t\t\t\t</div>\r\n\t\t\t\t\t\t</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t</tbody>\r\n\t\t\t</table>\t\t\r\n\t\t</td>\r\n\t </tr>\r\n\t<tr>\r\n\t\t<td height=\"20\" colspan=\"3\">\r\n\t\t<p style=\"margin:0;padding:75px 50px 30px 10px;text-align:right;font-size:14px\">网易邮件中心</p>\r\n\t\t</td>\r\n\t</tr>\r\n\t<tr>\r\n\t  <td height=\"20\" style=\"font-size:0;line-height:0\" colspan=\"3\" background=\"http://mimg.127.net/xm/mail_res/common/bottom.jpg\">&nbsp;</td>\r\n\t</tr>\r\n  </tbody>\r\n</table>\r\n<img src=\"http://count.mail.163.com/beacon/edm.gif?no=100180&domain=163.com&date=20120502\" style=\"display:none\" border=\"0\" />\r\n',NULL,'手机号码邮箱官方帐号|phone@service.netease.com;','smeoa_admin|smeoa_admin@163.com;','手机号码邮箱官方帐号|phone@service.netease.com;',NULL,1,1,'',1365469563,0,1),(1024,8,'<517792BF.BF5C21.14775@163smtp9>','系统退信','<!-- saved from url=(0022)http://internet.e-mail --> \r\n<html> \r\n<head> \r\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=gb2312\" /> \r\n<meta name=\"Keywords\" content=\"\" /> \r\n<meta name=\"Description\" content=\"\" /> \r\n<title></title> \r\n \r\n<style type=\"text/css\"> \r\n<!--\r\n \r\nbody,div,dl,dt,dd,h1,h2,h3,h4,h5,h6,pre,form,fieldset,input,textarea,p,blockquote,th,td{padding:0; margin:0; }\r\nfieldset,img{border:0; }\r\ntable{border-collapse:collapse; border-spacing:0; }\r\nol,ul{}\r\naddress,caption,cite,code,dfn,em,strong,th,var{font-weight:normal; font-style:normal; }\r\ncaption,th{text-align:left; }\r\nh1,h2,h3,h4,h5,h6{font-weight:bold; font-size:100%; }\r\nq:before,q:after{content:\'\'; }\r\nabbr,acronym{border:0; }\r\n \r\na:link,a:visited{}\r\na:hover{}\r\n \r\n.Bdy{font-size:14px; font-family:verdana,Arial,Helvetica,sans-serif; padding:20px;}\r\nh1{font-size:24px; color:#cd0021; padding-bottom:30px;}\r\np{}\r\n \r\n.Tb_mWp{border:1px solid #ddd; border-right:none; border-bottom:none; table-layout:fixed;}\r\n    .Tb_mWp th,.Tb_mWp td{border-right:1px solid #ddd; border-bottom:1px solid #ddd; padding:8px 4px;}\r\n    .Tb_mWp th{font-size:14px; text-align:right; width:130px; font-weight:bold; background:#f6f6f6; color:#666;}\r\n    .Tb_mWp td{font-size:14px; padding-left:10px; word-break:break-all;}\r\n \r\n.Tb_miWp{ margin-top:-2px; margin-left:-1px; float:left; table-layout:fixed;}\r\n    .Tb_miWp th,.Tb_miWp td{border-left:1px solid #eee; border-top:1px solid #eee; border-right:none; border-bottom:none; font-size:12px;}\r\n    .Tb_miWp th{width:68px; background:#f8f8f8;}\r\n \r\n.tr_Mi{}\r\n    .tr_Mi th{}\r\n    .tr_Mi td{}\r\n \r\n.tr_Rz{}\r\n    .tr_Rz th{}\r\n    .tr_Rz td{ background:#fff4f6;}\r\n        .tr_Rz .infoTt{ color:#cd0021; font-weight:bold; line-height:18px;}\r\n        .tr_Rz .infoDcr{ padding-top:4px; color:#999; line-height:18px;}\r\n \r\n.tr_Sr{}\r\n    .tr_Sr th{}\r\n    .tr_Sr td{background:#f4fff4;}\r\n \r\n.ul_lstWp{margin-left:-20px;}\r\n.ul_lst{padding-top:0px; padding-bottom:0px; margin-top:6px; margin-bottom:6px;}\r\n.ul_lst li{padding-top:3px; padding-bottom:3px;}\r\n \r\n \r\n \r\n \r\n-->\r\n</style> \r\n \r\n</head> \r\n \r\n<body class=\"Bdy\"> \r\n \r\n<h1>抱歉，您的邮件被退回来了……</h1> \r\n \r\n<div class=\"Con\"> \r\n<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"Tb_mWp\"> \r\n    \r\n    <!-- 原邮件信息 --> \r\n    <tr class=\"tr_Mi\"> \r\n        <th nowrap>原邮件信息：</th> \r\n        <td style=\"padding:0px; font-size:1px; line-height:1px; overflow:hidden; vertical-align:top;\"> \r\n\r\n            <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"Tb_miWp\"> \r\n                <tr> \r\n                    <th nowrap>时　间：</th> \r\n                    <td>2013-04-23 15:57:46</td> \r\n                </tr> \r\n　                <tr> \r\n                    <th nowrap>主　题：</th> \r\n                    <td>省顿饭</td>\r\n                </tr> \r\n                <tr> \r\n                    <th nowrap>收件人：</th> \r\n                    <td>leader@smeoa.com</td> \r\n                </tr> \r\n                <tr style=\"display:none;\"><!--  --> \r\n                    <th nowrap>抄　送：</th> \r\n                    <td>xxx</td> \r\n                </tr> \r\n                <tr style=\"display:none;\"> \r\n                    <th nowrap>密　送：</th><!--  --> \r\n                    <td>yyy</td> \r\n                </tr> \r\n            </table> \r\n            <!-- 原邮件信息列表 End --> \r\n \r\n \r\n \r\n \r\n        </td> \r\n    </tr> \r\n \r\n    <!-- 退信原因 --> \r\n    <tr class=\"tr_Rz\"> \r\n        <th nowrap>退信原因：</th> \r\n        <td> \r\n            <!-- wayhome 2009-3-9 --> \r\n            <div class=\"infoTt\">邮差小易抱歉地通知您，不知道是什么原因，对方退信了。</div> \r\n            <div class=\"infoDcr\">英文说明:rcpt handle timeout.(rcpt&nbsp;handle&nbsp;timeout)</div> \r\n        </td> \r\n    </tr> \r\n \r\n    <!-- 解决方案 --> \r\n    <tr class=\"tr_Sr\"> \r\n        <th nowrap>建议解决方案：</th> \r\n        <td> \r\n            <div class=\"ul_lstWp\"> \r\n            <ul class=\"ul_lst\"> \r\n                <li>邮差小易温馨提示：建议您联系对方的管理员，请他高抬贵手帮您解决吧。</li> \r\n                <li>如果您有其他退信问题，欢迎向网易邮件中心<a href=\"http://feedback.mail.126.com/antispam/report.php?&BounceReason=rcpt+handle+timeout.%28rcpt%26nbsp%3Bhandle%26nbsp%3Btimeout%29&BouncedRcpt=leader%40smeoa.com&ClusterID=&OrgSubject=%CA%A1%B6%D9%B7%B9&SendDate=1366703866&Sender=smeoa_admin%40163.com&TransID=DcCowECpcWX6PnZRf8EqAw--.1375S2.B35947\" target=\"_blank\">发送退信报告</a></li>\r\n            </ul> \r\n            </div>        \r\n        </td> \r\n    </tr> \r\n\r\n</table> \r\n \r\n</div> \r\n \r\n\r\n<!-- footer -->\r\n<span>\r\n<br>----------------<br>This message is generated by Coremail.<br>您收到的是来自 Coremail 专业邮件系统的信件.<br><br>\r\n</span>\r\n</body> \r\n</html>\r\n',NULL,'Postmaster|Postmaster@163.com;','smeoa_admin|smeoa_admin@163.com;','Postmaster|Postmaster@163.com;',NULL,1,1,'',1366790847,0,1),(1025,1,'<517792BE.BF5C16.14775@163smtp9>','系统退信','<!-- saved from url=(0022)http://internet.e-mail --> \r\n<html> \r\n<head> \r\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=gb2312\" /> \r\n<meta name=\"Keywords\" content=\"\" /> \r\n<meta name=\"Description\" content=\"\" /> \r\n<title></title> \r\n \r\n<style type=\"text/css\"> \r\n<!--\r\n \r\nbody,div,dl,dt,dd,h1,h2,h3,h4,h5,h6,pre,form,fieldset,input,textarea,p,blockquote,th,td{padding:0; margin:0; }\r\nfieldset,img{border:0; }\r\ntable{border-collapse:collapse; border-spacing:0; }\r\nol,ul{}\r\naddress,caption,cite,code,dfn,em,strong,th,var{font-weight:normal; font-style:normal; }\r\ncaption,th{text-align:left; }\r\nh1,h2,h3,h4,h5,h6{font-weight:bold; font-size:100%; }\r\nq:before,q:after{content:\'\'; }\r\nabbr,acronym{border:0; }\r\n \r\na:link,a:visited{}\r\na:hover{}\r\n \r\n.Bdy{font-size:14px; font-family:verdana,Arial,Helvetica,sans-serif; padding:20px;}\r\nh1{font-size:24px; color:#cd0021; padding-bottom:30px;}\r\np{}\r\n \r\n.Tb_mWp{border:1px solid #ddd; border-right:none; border-bottom:none; table-layout:fixed;}\r\n    .Tb_mWp th,.Tb_mWp td{border-right:1px solid #ddd; border-bottom:1px solid #ddd; padding:8px 4px;}\r\n    .Tb_mWp th{font-size:14px; text-align:right; width:130px; font-weight:bold; background:#f6f6f6; color:#666;}\r\n    .Tb_mWp td{font-size:14px; padding-left:10px; word-break:break-all;}\r\n \r\n.Tb_miWp{ margin-top:-2px; margin-left:-1px; float:left; table-layout:fixed;}\r\n    .Tb_miWp th,.Tb_miWp td{border-left:1px solid #eee; border-top:1px solid #eee; border-right:none; border-bottom:none; font-size:12px;}\r\n    .Tb_miWp th{width:68px; background:#f8f8f8;}\r\n \r\n.tr_Mi{}\r\n    .tr_Mi th{}\r\n    .tr_Mi td{}\r\n \r\n.tr_Rz{}\r\n    .tr_Rz th{}\r\n    .tr_Rz td{ background:#fff4f6;}\r\n        .tr_Rz .infoTt{ color:#cd0021; font-weight:bold; line-height:18px;}\r\n        .tr_Rz .infoDcr{ padding-top:4px; color:#999; line-height:18px;}\r\n \r\n.tr_Sr{}\r\n    .tr_Sr th{}\r\n    .tr_Sr td{background:#f4fff4;}\r\n \r\n.ul_lstWp{margin-left:-20px;}\r\n.ul_lst{padding-top:0px; padding-bottom:0px; margin-top:6px; margin-bottom:6px;}\r\n.ul_lst li{padding-top:3px; padding-bottom:3px;}\r\n \r\n \r\n \r\n \r\n-->\r\n</style> \r\n \r\n</head> \r\n \r\n<body class=\"Bdy\"> \r\n \r\n<h1>抱歉，您的邮件被退回来了……</h1> \r\n \r\n<div class=\"Con\"> \r\n<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"Tb_mWp\"> \r\n    \r\n    <!-- 原邮件信息 --> \r\n    <tr class=\"tr_Mi\"> \r\n        <th nowrap>原邮件信息：</th> \r\n        <td style=\"padding:0px; font-size:1px; line-height:1px; overflow:hidden; vertical-align:top;\"> \r\n\r\n            <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"Tb_miWp\"> \r\n                <tr> \r\n                    <th nowrap>时　间：</th> \r\n                    <td>2013-04-23 15:57:46</td> \r\n                </tr> \r\n　                <tr> \r\n                    <th nowrap>主　题：</th> \r\n                    <td>省顿饭</td>\r\n                </tr> \r\n                <tr> \r\n                    <th nowrap>收件人：</th> \r\n                    <td>demo@smeoa.com</td> \r\n                </tr> \r\n                <tr style=\"display:none;\"><!--  --> \r\n                    <th nowrap>抄　送：</th> \r\n                    <td>xxx</td> \r\n                </tr> \r\n                <tr style=\"display:none;\"> \r\n                    <th nowrap>密　送：</th><!--  --> \r\n                    <td>yyy</td> \r\n                </tr> \r\n            </table> \r\n            <!-- 原邮件信息列表 End --> \r\n \r\n \r\n \r\n \r\n        </td> \r\n    </tr> \r\n \r\n    <!-- 退信原因 --> \r\n    <tr class=\"tr_Rz\"> \r\n        <th nowrap>退信原因：</th> \r\n        <td> \r\n            <!-- wayhome 2009-3-9 --> \r\n            <div class=\"infoTt\">邮差小易抱歉地通知您，不知道是什么原因，对方退信了。</div> \r\n            <div class=\"infoDcr\">英文说明:rcpt handle timeout.(rcpt&nbsp;handle&nbsp;timeout)</div> \r\n        </td> \r\n    </tr> \r\n \r\n    <!-- 解决方案 --> \r\n    <tr class=\"tr_Sr\"> \r\n        <th nowrap>建议解决方案：</th> \r\n        <td> \r\n            <div class=\"ul_lstWp\"> \r\n            <ul class=\"ul_lst\"> \r\n                <li>邮差小易温馨提示：建议您联系对方的管理员，请他高抬贵手帮您解决吧。</li> \r\n                <li>如果您有其他退信问题，欢迎向网易邮件中心<a href=\"http://feedback.mail.126.com/antispam/report.php?&BounceReason=rcpt+handle+timeout.%28rcpt%26nbsp%3Bhandle%26nbsp%3Btimeout%29&BouncedRcpt=demo%40smeoa.com&ClusterID=&OrgSubject=%CA%A1%B6%D9%B7%B9&SendDate=1366703866&Sender=smeoa_admin%40163.com&TransID=DcCowECpcWX6PnZRf8EqAw--.1375S2.B35945\" target=\"_blank\">发送退信报告</a></li>\r\n            </ul> \r\n            </div>        \r\n        </td> \r\n    </tr> \r\n\r\n</table> \r\n \r\n</div> \r\n \r\n\r\n<!-- footer -->\r\n<span>\r\n<br>----------------<br>This message is generated by Coremail.<br>您收到的是来自 Coremail 专业邮件系统的信件.<br><br>\r\n</span>\r\n</body> \r\n</html>\r\n',NULL,'Postmaster|Postmaster@163.com;','smeoa_admin|smeoa_admin@163.com;','Postmaster|Postmaster@163.com;',NULL,1,1,'',1366790846,0,1),(1026,1,'<517792BF.BF5C2A.14775@163smtp9>','系统退信','<!-- saved from url=(0022)http://internet.e-mail --> \r\n<html> \r\n<head> \r\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=gb2312\" /> \r\n<meta name=\"Keywords\" content=\"\" /> \r\n<meta name=\"Description\" content=\"\" /> \r\n<title></title> \r\n \r\n<style type=\"text/css\"> \r\n<!--\r\n \r\nbody,div,dl,dt,dd,h1,h2,h3,h4,h5,h6,pre,form,fieldset,input,textarea,p,blockquote,th,td{padding:0; margin:0; }\r\nfieldset,img{border:0; }\r\ntable{border-collapse:collapse; border-spacing:0; }\r\nol,ul{}\r\naddress,caption,cite,code,dfn,em,strong,th,var{font-weight:normal; font-style:normal; }\r\ncaption,th{text-align:left; }\r\nh1,h2,h3,h4,h5,h6{font-weight:bold; font-size:100%; }\r\nq:before,q:after{content:\'\'; }\r\nabbr,acronym{border:0; }\r\n \r\na:link,a:visited{}\r\na:hover{}\r\n \r\n.Bdy{font-size:14px; font-family:verdana,Arial,Helvetica,sans-serif; padding:20px;}\r\nh1{font-size:24px; color:#cd0021; padding-bottom:30px;}\r\np{}\r\n \r\n.Tb_mWp{border:1px solid #ddd; border-right:none; border-bottom:none; table-layout:fixed;}\r\n    .Tb_mWp th,.Tb_mWp td{border-right:1px solid #ddd; border-bottom:1px solid #ddd; padding:8px 4px;}\r\n    .Tb_mWp th{font-size:14px; text-align:right; width:130px; font-weight:bold; background:#f6f6f6; color:#666;}\r\n    .Tb_mWp td{font-size:14px; padding-left:10px; word-break:break-all;}\r\n \r\n.Tb_miWp{ margin-top:-2px; margin-left:-1px; float:left; table-layout:fixed;}\r\n    .Tb_miWp th,.Tb_miWp td{border-left:1px solid #eee; border-top:1px solid #eee; border-right:none; border-bottom:none; font-size:12px;}\r\n    .Tb_miWp th{width:68px; background:#f8f8f8;}\r\n \r\n.tr_Mi{}\r\n    .tr_Mi th{}\r\n    .tr_Mi td{}\r\n \r\n.tr_Rz{}\r\n    .tr_Rz th{}\r\n    .tr_Rz td{ background:#fff4f6;}\r\n        .tr_Rz .infoTt{ color:#cd0021; font-weight:bold; line-height:18px;}\r\n        .tr_Rz .infoDcr{ padding-top:4px; color:#999; line-height:18px;}\r\n \r\n.tr_Sr{}\r\n    .tr_Sr th{}\r\n    .tr_Sr td{background:#f4fff4;}\r\n \r\n.ul_lstWp{margin-left:-20px;}\r\n.ul_lst{padding-top:0px; padding-bottom:0px; margin-top:6px; margin-bottom:6px;}\r\n.ul_lst li{padding-top:3px; padding-bottom:3px;}\r\n \r\n \r\n \r\n \r\n-->\r\n</style> \r\n \r\n</head> \r\n \r\n<body class=\"Bdy\"> \r\n \r\n<h1>抱歉，您的邮件被退回来了……</h1> \r\n \r\n<div class=\"Con\"> \r\n<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"Tb_mWp\"> \r\n    \r\n    <!-- 原邮件信息 --> \r\n    <tr class=\"tr_Mi\"> \r\n        <th nowrap>原邮件信息：</th> \r\n        <td style=\"padding:0px; font-size:1px; line-height:1px; overflow:hidden; vertical-align:top;\"> \r\n\r\n            <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"Tb_miWp\"> \r\n                <tr> \r\n                    <th nowrap>时　间：</th> \r\n                    <td>2013-04-23 15:57:46</td> \r\n                </tr> \r\n　                <tr> \r\n                    <th nowrap>主　题：</th> \r\n                    <td>省顿饭</td>\r\n                </tr> \r\n                <tr> \r\n                    <th nowrap>收件人：</th> \r\n                    <td>test@smeoa.com</td> \r\n                </tr> \r\n                <tr style=\"display:none;\"><!--  --> \r\n                    <th nowrap>抄　送：</th> \r\n                    <td>xxx</td> \r\n                </tr> \r\n                <tr style=\"display:none;\"> \r\n                    <th nowrap>密　送：</th><!--  --> \r\n                    <td>yyy</td> \r\n                </tr> \r\n            </table> \r\n            <!-- 原邮件信息列表 End --> \r\n \r\n \r\n \r\n \r\n        </td> \r\n    </tr> \r\n \r\n    <!-- 退信原因 --> \r\n    <tr class=\"tr_Rz\"> \r\n        <th nowrap>退信原因：</th> \r\n        <td> \r\n            <!-- wayhome 2009-3-9 --> \r\n            <div class=\"infoTt\">邮差小易抱歉地通知您，不知道是什么原因，对方退信了。</div> \r\n            <div class=\"infoDcr\">英文说明:rcpt handle timeout.(rcpt&nbsp;handle&nbsp;timeout)</div> \r\n        </td> \r\n    </tr> \r\n \r\n    <!-- 解决方案 --> \r\n    <tr class=\"tr_Sr\"> \r\n        <th nowrap>建议解决方案：</th> \r\n        <td> \r\n            <div class=\"ul_lstWp\"> \r\n            <ul class=\"ul_lst\"> \r\n                <li>邮差小易温馨提示：建议您联系对方的管理员，请他高抬贵手帮您解决吧。</li> \r\n                <li>如果您有其他退信问题，欢迎向网易邮件中心<a href=\"http://feedback.mail.126.com/antispam/report.php?&BounceReason=rcpt+handle+timeout.%28rcpt%26nbsp%3Bhandle%26nbsp%3Btimeout%29&BouncedRcpt=test%40smeoa.com&ClusterID=&OrgSubject=%CA%A1%B6%D9%B7%B9&SendDate=1366703866&Sender=smeoa_admin%40163.com&TransID=DcCowECpcWX6PnZRf8EqAw--.1375S2.B35949\" target=\"_blank\">发送退信报告</a></li>\r\n            </ul> \r\n            </div>        \r\n        </td> \r\n    </tr> \r\n\r\n</table> \r\n \r\n</div> \r\n \r\n\r\n<!-- footer -->\r\n<span>\r\n<br>----------------<br>This message is generated by Coremail.<br>您收到的是来自 Coremail 专业邮件系统的信件.<br><br>\r\n</span>\r\n</body> \r\n</html>\r\n',NULL,'Postmaster|Postmaster@163.com;','smeoa_admin|smeoa_admin@163.com;','Postmaster|Postmaster@163.com;',NULL,1,1,'',1366790847,0,1),(1027,1,'<517792BF.BF5C27.14775@163smtp9>','系统退信','<!-- saved from url=(0022)http://internet.e-mail --> \r\n<html> \r\n<head> \r\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=gb2312\" /> \r\n<meta name=\"Keywords\" content=\"\" /> \r\n<meta name=\"Description\" content=\"\" /> \r\n<title></title> \r\n \r\n<style type=\"text/css\"> \r\n<!--\r\n \r\nbody,div,dl,dt,dd,h1,h2,h3,h4,h5,h6,pre,form,fieldset,input,textarea,p,blockquote,th,td{padding:0; margin:0; }\r\nfieldset,img{border:0; }\r\ntable{border-collapse:collapse; border-spacing:0; }\r\nol,ul{}\r\naddress,caption,cite,code,dfn,em,strong,th,var{font-weight:normal; font-style:normal; }\r\ncaption,th{text-align:left; }\r\nh1,h2,h3,h4,h5,h6{font-weight:bold; font-size:100%; }\r\nq:before,q:after{content:\'\'; }\r\nabbr,acronym{border:0; }\r\n \r\na:link,a:visited{}\r\na:hover{}\r\n \r\n.Bdy{font-size:14px; font-family:verdana,Arial,Helvetica,sans-serif; padding:20px;}\r\nh1{font-size:24px; color:#cd0021; padding-bottom:30px;}\r\np{}\r\n \r\n.Tb_mWp{border:1px solid #ddd; border-right:none; border-bottom:none; table-layout:fixed;}\r\n    .Tb_mWp th,.Tb_mWp td{border-right:1px solid #ddd; border-bottom:1px solid #ddd; padding:8px 4px;}\r\n    .Tb_mWp th{font-size:14px; text-align:right; width:130px; font-weight:bold; background:#f6f6f6; color:#666;}\r\n    .Tb_mWp td{font-size:14px; padding-left:10px; word-break:break-all;}\r\n \r\n.Tb_miWp{ margin-top:-2px; margin-left:-1px; float:left; table-layout:fixed;}\r\n    .Tb_miWp th,.Tb_miWp td{border-left:1px solid #eee; border-top:1px solid #eee; border-right:none; border-bottom:none; font-size:12px;}\r\n    .Tb_miWp th{width:68px; background:#f8f8f8;}\r\n \r\n.tr_Mi{}\r\n    .tr_Mi th{}\r\n    .tr_Mi td{}\r\n \r\n.tr_Rz{}\r\n    .tr_Rz th{}\r\n    .tr_Rz td{ background:#fff4f6;}\r\n        .tr_Rz .infoTt{ color:#cd0021; font-weight:bold; line-height:18px;}\r\n        .tr_Rz .infoDcr{ padding-top:4px; color:#999; line-height:18px;}\r\n \r\n.tr_Sr{}\r\n    .tr_Sr th{}\r\n    .tr_Sr td{background:#f4fff4;}\r\n \r\n.ul_lstWp{margin-left:-20px;}\r\n.ul_lst{padding-top:0px; padding-bottom:0px; margin-top:6px; margin-bottom:6px;}\r\n.ul_lst li{padding-top:3px; padding-bottom:3px;}\r\n \r\n \r\n \r\n \r\n-->\r\n</style> \r\n \r\n</head> \r\n \r\n<body class=\"Bdy\"> \r\n \r\n<h1>抱歉，您的邮件被退回来了……</h1> \r\n \r\n<div class=\"Con\"> \r\n<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"Tb_mWp\"> \r\n    \r\n    <!-- 原邮件信息 --> \r\n    <tr class=\"tr_Mi\"> \r\n        <th nowrap>原邮件信息：</th> \r\n        <td style=\"padding:0px; font-size:1px; line-height:1px; overflow:hidden; vertical-align:top;\"> \r\n\r\n            <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"Tb_miWp\"> \r\n                <tr> \r\n                    <th nowrap>时　间：</th> \r\n                    <td>2013-04-23 15:57:46</td> \r\n                </tr> \r\n　                <tr> \r\n                    <th nowrap>主　题：</th> \r\n                    <td>省顿饭</td>\r\n                </tr> \r\n                <tr> \r\n                    <th nowrap>收件人：</th> \r\n                    <td>test1@smeoa.com</td> \r\n                </tr> \r\n                <tr style=\"display:none;\"><!--  --> \r\n                    <th nowrap>抄　送：</th> \r\n                    <td>xxx</td> \r\n                </tr> \r\n                <tr style=\"display:none;\"> \r\n                    <th nowrap>密　送：</th><!--  --> \r\n                    <td>yyy</td> \r\n                </tr> \r\n            </table> \r\n            <!-- 原邮件信息列表 End --> \r\n \r\n \r\n \r\n \r\n        </td> \r\n    </tr> \r\n \r\n    <!-- 退信原因 --> \r\n    <tr class=\"tr_Rz\"> \r\n        <th nowrap>退信原因：</th> \r\n        <td> \r\n            <!-- wayhome 2009-3-9 --> \r\n            <div class=\"infoTt\">邮差小易抱歉地通知您，不知道是什么原因，对方退信了。</div> \r\n            <div class=\"infoDcr\">英文说明:rcpt handle timeout.(rcpt&nbsp;handle&nbsp;timeout)</div> \r\n        </td> \r\n    </tr> \r\n \r\n    <!-- 解决方案 --> \r\n    <tr class=\"tr_Sr\"> \r\n        <th nowrap>建议解决方案：</th> \r\n        <td> \r\n            <div class=\"ul_lstWp\"> \r\n            <ul class=\"ul_lst\"> \r\n                <li>邮差小易温馨提示：建议您联系对方的管理员，请他高抬贵手帮您解决吧。</li> \r\n                <li>如果您有其他退信问题，欢迎向网易邮件中心<a href=\"http://feedback.mail.126.com/antispam/report.php?&BounceReason=rcpt+handle+timeout.%28rcpt%26nbsp%3Bhandle%26nbsp%3Btimeout%29&BouncedRcpt=test1%40smeoa.com&ClusterID=&OrgSubject=%CA%A1%B6%D9%B7%B9&SendDate=1366703866&Sender=smeoa_admin%40163.com&TransID=DcCowECpcWX6PnZRf8EqAw--.1375S2.B35948\" target=\"_blank\">发送退信报告</a></li>\r\n            </ul> \r\n            </div>        \r\n        </td> \r\n    </tr> \r\n\r\n</table> \r\n \r\n</div> \r\n \r\n\r\n<!-- footer -->\r\n<span>\r\n<br>----------------<br>This message is generated by Coremail.<br>您收到的是来自 Coremail 专业邮件系统的信件.<br><br>\r\n</span>\r\n</body> \r\n</html>\r\n',NULL,'Postmaster|Postmaster@163.com;','smeoa_admin|smeoa_admin@163.com;','Postmaster|Postmaster@163.com;',NULL,1,1,'',1366790847,0,1),(1028,1,'<517792BF.BF5C19.14775@163smtp9>','系统退信','<!-- saved from url=(0022)http://internet.e-mail --> \r\n<html> \r\n<head> \r\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=gb2312\" /> \r\n<meta name=\"Keywords\" content=\"\" /> \r\n<meta name=\"Description\" content=\"\" /> \r\n<title></title> \r\n \r\n<style type=\"text/css\"> \r\n<!--\r\n \r\nbody,div,dl,dt,dd,h1,h2,h3,h4,h5,h6,pre,form,fieldset,input,textarea,p,blockquote,th,td{padding:0; margin:0; }\r\nfieldset,img{border:0; }\r\ntable{border-collapse:collapse; border-spacing:0; }\r\nol,ul{}\r\naddress,caption,cite,code,dfn,em,strong,th,var{font-weight:normal; font-style:normal; }\r\ncaption,th{text-align:left; }\r\nh1,h2,h3,h4,h5,h6{font-weight:bold; font-size:100%; }\r\nq:before,q:after{content:\'\'; }\r\nabbr,acronym{border:0; }\r\n \r\na:link,a:visited{}\r\na:hover{}\r\n \r\n.Bdy{font-size:14px; font-family:verdana,Arial,Helvetica,sans-serif; padding:20px;}\r\nh1{font-size:24px; color:#cd0021; padding-bottom:30px;}\r\np{}\r\n \r\n.Tb_mWp{border:1px solid #ddd; border-right:none; border-bottom:none; table-layout:fixed;}\r\n    .Tb_mWp th,.Tb_mWp td{border-right:1px solid #ddd; border-bottom:1px solid #ddd; padding:8px 4px;}\r\n    .Tb_mWp th{font-size:14px; text-align:right; width:130px; font-weight:bold; background:#f6f6f6; color:#666;}\r\n    .Tb_mWp td{font-size:14px; padding-left:10px; word-break:break-all;}\r\n \r\n.Tb_miWp{ margin-top:-2px; margin-left:-1px; float:left; table-layout:fixed;}\r\n    .Tb_miWp th,.Tb_miWp td{border-left:1px solid #eee; border-top:1px solid #eee; border-right:none; border-bottom:none; font-size:12px;}\r\n    .Tb_miWp th{width:68px; background:#f8f8f8;}\r\n \r\n.tr_Mi{}\r\n    .tr_Mi th{}\r\n    .tr_Mi td{}\r\n \r\n.tr_Rz{}\r\n    .tr_Rz th{}\r\n    .tr_Rz td{ background:#fff4f6;}\r\n        .tr_Rz .infoTt{ color:#cd0021; font-weight:bold; line-height:18px;}\r\n        .tr_Rz .infoDcr{ padding-top:4px; color:#999; line-height:18px;}\r\n \r\n.tr_Sr{}\r\n    .tr_Sr th{}\r\n    .tr_Sr td{background:#f4fff4;}\r\n \r\n.ul_lstWp{margin-left:-20px;}\r\n.ul_lst{padding-top:0px; padding-bottom:0px; margin-top:6px; margin-bottom:6px;}\r\n.ul_lst li{padding-top:3px; padding-bottom:3px;}\r\n \r\n \r\n \r\n \r\n-->\r\n</style> \r\n \r\n</head> \r\n \r\n<body class=\"Bdy\"> \r\n \r\n<h1>抱歉，您的邮件被退回来了……</h1> \r\n \r\n<div class=\"Con\"> \r\n<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"Tb_mWp\"> \r\n    \r\n    <!-- 原邮件信息 --> \r\n    <tr class=\"tr_Mi\"> \r\n        <th nowrap>原邮件信息：</th> \r\n        <td style=\"padding:0px; font-size:1px; line-height:1px; overflow:hidden; vertical-align:top;\"> \r\n\r\n            <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"Tb_miWp\"> \r\n                <tr> \r\n                    <th nowrap>时　间：</th> \r\n                    <td>2013-04-23 15:57:46</td> \r\n                </tr> \r\n　                <tr> \r\n                    <th nowrap>主　题：</th> \r\n                    <td>省顿饭</td>\r\n                </tr> \r\n                <tr> \r\n                    <th nowrap>收件人：</th> \r\n                    <td>member@smeoa.com</td> \r\n                </tr> \r\n                <tr style=\"display:none;\"><!--  --> \r\n                    <th nowrap>抄　送：</th> \r\n                    <td>xxx</td> \r\n                </tr> \r\n                <tr style=\"display:none;\"> \r\n                    <th nowrap>密　送：</th><!--  --> \r\n                    <td>yyy</td> \r\n                </tr> \r\n            </table> \r\n            <!-- 原邮件信息列表 End --> \r\n \r\n \r\n \r\n \r\n        </td> \r\n    </tr> \r\n \r\n    <!-- 退信原因 --> \r\n    <tr class=\"tr_Rz\"> \r\n        <th nowrap>退信原因：</th> \r\n        <td> \r\n            <!-- wayhome 2009-3-9 --> \r\n            <div class=\"infoTt\">邮差小易抱歉地通知您，不知道是什么原因，对方退信了。</div> \r\n            <div class=\"infoDcr\">英文说明:rcpt handle timeout.(rcpt&nbsp;handle&nbsp;timeout)</div> \r\n        </td> \r\n    </tr> \r\n \r\n    <!-- 解决方案 --> \r\n    <tr class=\"tr_Sr\"> \r\n        <th nowrap>建议解决方案：</th> \r\n        <td> \r\n            <div class=\"ul_lstWp\"> \r\n            <ul class=\"ul_lst\"> \r\n                <li>邮差小易温馨提示：建议您联系对方的管理员，请他高抬贵手帮您解决吧。</li> \r\n                <li>如果您有其他退信问题，欢迎向网易邮件中心<a href=\"http://feedback.mail.126.com/antispam/report.php?&BounceReason=rcpt+handle+timeout.%28rcpt%26nbsp%3Bhandle%26nbsp%3Btimeout%29&BouncedRcpt=member%40smeoa.com&ClusterID=&OrgSubject=%CA%A1%B6%D9%B7%B9&SendDate=1366703866&Sender=smeoa_admin%40163.com&TransID=DcCowECpcWX6PnZRf8EqAw--.1375S2.B35946\" target=\"_blank\">发送退信报告</a></li>\r\n            </ul> \r\n            </div>        \r\n        </td> \r\n    </tr> \r\n\r\n</table> \r\n \r\n</div> \r\n \r\n\r\n<!-- footer -->\r\n<span>\r\n<br>----------------<br>This message is generated by Coremail.<br>您收到的是来自 Coremail 专业邮件系统的信件.<br><br>\r\n</span>\r\n</body> \r\n</html>\r\n',NULL,'Postmaster|Postmaster@163.com;','smeoa_admin|smeoa_admin@163.com;','Postmaster|Postmaster@163.com;',NULL,0,1,'',1366790847,0,1);

#
# Source for table "think_mail_account"
#

DROP TABLE IF EXISTS `think_mail_account`;
CREATE TABLE `think_mail_account` (
  `id` mediumint(6) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `office_tel` varchar(20) DEFAULT NULL,
  `mobile_tel` varchar(20) NOT NULL,
  `website` varchar(50) NOT NULL,
  `im` varchar(20) NOT NULL,
  `mail_name` varchar(50) NOT NULL,
  `pop3svr` varchar(50) NOT NULL,
  `smtpsvr` varchar(50) NOT NULL,
  `mail_id` varchar(50) NOT NULL,
  `mail_pwd` varchar(50) NOT NULL,
  `remark` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='think_user_info';

#
# Data for table "think_mail_account"
#

INSERT INTO `think_mail_account` VALUES (1,'smeoa_admin@163.com',NULL,'','','','smeoa_admin','pop.163.com','smtp.163.com','smeoa_admin','smeoa@188.',NULL);

#
# Source for table "think_mail_organize"
#

DROP TABLE IF EXISTS `think_mail_organize`;
CREATE TABLE `think_mail_organize` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `sort` int(11) NOT NULL,
  `sender_check` int(11) NOT NULL,
  `sender_option` int(11) NOT NULL,
  `sender_key` varchar(50) NOT NULL,
  `domain_check` int(100) NOT NULL,
  `domain_option` int(11) NOT NULL,
  `domain_key` varchar(50) NOT NULL,
  `recever_check` int(11) NOT NULL,
  `recever_option` int(11) NOT NULL,
  `recever_key` varchar(50) NOT NULL,
  `title_check` int(11) NOT NULL,
  `title_option` int(11) NOT NULL,
  `title_key` varchar(50) NOT NULL,
  `to` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

#
# Data for table "think_mail_organize"
#

INSERT INTO `think_mail_organize` VALUES (12,1,1,0,0,1,'',1,1,'1234',0,1,'',0,1,'',8),(13,1,1,0,0,1,'',1,1,'12345',0,1,'',0,1,'',8);

#
# Source for table "think_material"
#

DROP TABLE IF EXISTS `think_material`;
CREATE TABLE `think_material` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `letter` varchar(20) DEFAULT '',
  `mat_no` varchar(20) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `spec` varchar(255) DEFAULT NULL,
  `unit` varchar(20) DEFAULT NULL,
  `buy_price` decimal(10,2) DEFAULT NULL,
  `sell_price` decimal(10,2) DEFAULT NULL,
  `class` int(11) DEFAULT NULL,
  `init_qty` decimal(10,3) DEFAULT NULL,
  `min_qty` decimal(10,3) DEFAULT NULL,
  `max_qty` decimal(10,3) DEFAULT NULL,
  `remark` text,
  `status` tinyint(1) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_name` varchar(20) NOT NULL DEFAULT '',
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

#
# Data for table "think_material"
#

INSERT INTO `think_material` VALUES (1,'DYJ','ZC0001','5200打印机','规格规格','单位',10000.00,12000.00,20,0.000,0.000,0.000,' ',1,NULL,'',NULL,NULL),(3,'DLG','ABCD-3456','DL580 G8','规格规格','单位',20000.00,30000.00,22,0.000,1.000,3.000,'               ',1,NULL,'',NULL,NULL),(12,'LGCXSQ','CODE0009','LG29寸显示器','规格','单位',4000.00,5000.00,29,0.000,5.000,20.000,' 其他',1,NULL,'',NULL,NULL),(13,'RLTYP','CODE0010','日历1T硬盘','规格','单位',400.00,500.00,25,10.000,5.000,20.000,' 其他',1,NULL,'',NULL,NULL),(14,'XSQ','CODE0011','23显示器','规格','单位',1000.00,1200.00,29,0.000,5.000,20.000,' 其他',1,NULL,'',NULL,NULL),(15,'XJG','CODE0012','希捷500G','规格','单位',300.00,350.00,27,0.000,5.000,10.000,' 其他',1,NULL,'',NULL,NULL),(16,'SXGYP','CODE0013','三星500G硬盘','规格','单位',200.00,300.00,27,0.000,5.000,20.000,' 其他',1,NULL,'',NULL,NULL),(17,'XSQ','CODE0014','19显示器','规格','单位',700.00,850.00,29,0.000,10.000,20.000,'   其他',1,NULL,'',NULL,NULL),(18,'JSDGTYPG','CODE0015','金士顿固态硬盘60G','固态硬盘','单位',300.00,350.00,28,15.000,5.000,20.000,'   其他',1,NULL,'',NULL,NULL),(19,'','12315123','','','',12.00,0.00,20,0.000,0.000,0.000,'',NULL,1,'',NULL,NULL);

#
# Source for table "think_material_class"
#

DROP TABLE IF EXISTS `think_material_class`;
CREATE TABLE `think_material_class` (
  `id` smallint(3) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `sort` varchar(20) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `remark` varchar(255) NOT NULL,
  `user_name` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;

#
# Data for table "think_material_class"
#

INSERT INTO `think_material_class` VALUES (20,0,1,'打印机','2',1,'','管理员'),(21,0,1,'电脑','1',1,'','管理员'),(22,0,1,'服务器','3',1,'','管理员'),(23,0,1,'网络设备','4',1,'','管理员'),(24,0,1,'其他','5',1,'','管理员'),(25,21,1,'硬盘','',1,'','管理员'),(26,25,1,'移动硬盘','',1,'','管理员'),(27,25,1,'台式机硬盘','',1,'','管理员'),(28,25,1,'固态硬盘','',1,'','管理员'),(29,21,1,'显示器','',1,'','管理员');

#
# Source for table "think_message"
#

DROP TABLE IF EXISTS `think_message`;
CREATE TABLE `think_message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sender` varchar(20) NOT NULL,
  `owner` varchar(20) NOT NULL,
  `recever` varchar(10) NOT NULL,
  `content` text NOT NULL,
  `read` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `add_file` varchar(100) NOT NULL,
  `create_time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

#
# Data for table "think_message"
#

INSERT INTO `think_message` VALUES (16,'admin','admin','demo','123123',1,1,'',1345770394),(17,'admin','demo','demo','123123',0,1,'',1345770394),(18,'admin','admin','demo','<a href=\"http://www.sohu.com\">www.sohu.com</a>',1,1,'',1347103615),(19,'admin','demo','demo','<a href=\"http://www.sohu.com\">www.sohu.com</a>',0,1,'',1347103615),(20,'admin','admin','leader','<p>\r\n\t消息发送测试\r\n</p>',1,1,'',1347799500),(21,'admin','leader','leader','<p>\r\n\t消息发送测试\r\n</p>',0,1,'',1347799500);

#
# Source for table "think_node"
#

DROP TABLE IF EXISTS `think_node`;
CREATE TABLE `think_node` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `icon` varchar(100) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1',
  `url` varchar(200) NOT NULL,
  `sub_folder` varchar(20) DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `sort` varchar(20) DEFAULT NULL,
  `pid` smallint(6) unsigned NOT NULL,
  `level` tinyint(1) unsigned NOT NULL,
  `check_auth` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `level` (`level`),
  KEY `pid` (`pid`),
  KEY `status` (`status`),
  KEY `name` (`icon`)
) ENGINE=MyISAM AUTO_INCREMENT=175 DEFAULT CHARSET=utf8;

#
# Data for table "think_node"
#

INSERT INTO `think_node` VALUES (2,'','节点管理',1,'node/index',NULL,'','3',1,2,NULL),(83,'','交流',1,'notice/index','','','7',0,1,1),(84,'','管理',1,'user/index','','','999',0,1,1),(85,'','邮件',1,'mail/mail_list?folder=inbox','','','1',0,1,NULL),(87,'','审批',1,'flow/index','','','2',0,1,1),(88,'','文档',1,'doc/index','','','3',0,1,1),(91,'','日程',1,'schedule/index','','','4',0,1,1),(94,'','职位',1,'position/index',NULL,'','',1,0,NULL),(97,'','部门',1,'dept/index',NULL,'','',1,0,NULL),(100,'','写信',1,'mail/add','','','1',85,0,NULL),(101,'','收件箱',1,'mail/index','mail/mail_list','','3',85,0,1),(102,'','邮件设置',1,'','','','4',85,0,NULL),(104,'','垃圾箱',1,'mail/mail_list?folder=spambox',NULL,'','5',101,0,NULL),(105,'','发件箱',1,'mail/mail_list?folder=outbox',NULL,'','2',101,0,NULL),(106,'','已删除',1,'mail/mail_list?folder=delbox',NULL,'','3',101,0,NULL),(107,'','草稿箱',1,'mail/mail_list?folder=darftbox',NULL,'','4',101,0,NULL),(108,'','邮件帐户设置',1,'mailaccount/index',NULL,'','1',102,0,NULL),(110,'','公司信息管理',1,'',NULL,'','1',84,0,NULL),(111,'','员工信息管理',1,'',NULL,'','2',84,0,NULL),(112,'','权限管理',1,'',NULL,'','3',84,0,NULL),(113,'','系统设定',1,'',NULL,'','4',84,0,NULL),(114,'','公司信息',1,'',NULL,'','1',110,0,NULL),(115,'','组织图管理',1,'dept/index',NULL,'','2',110,0,NULL),(116,'','员工登记',1,'user/index',NULL,'','1',111,0,NULL),(118,'','权限编码登记',1,'role/index',NULL,'','1',112,0,NULL),(119,'','权限编码-菜单映射',1,'role/node',NULL,'','2',112,0,NULL),(120,'','权限编码-用户映射',1,'role/user',NULL,'','3',112,0,NULL),(121,'','菜单信息设置',1,'node/index',NULL,'','1',113,0,NULL),(122,'','职级',1,'rank/index',NULL,'','3',113,0,NULL),(123,'','职位',1,'position/index',NULL,'','2',113,0,NULL),(124,'','文件夹设置',1,'mailfolder/index',NULL,'','2',102,0,NULL),(125,'','联系人',1,'contact/index','','','1',157,0,0),(126,'','文件搜索',1,'doc/index','','','1',88,0,NULL),(127,'','文档库管理',1,'',NULL,'','4',88,0,NULL),(128,'','基础资料',1,'refer/index','','','4',113,0,NULL),(130,'','个人文档库管理',1,'docfolder/personal',NULL,'','',127,0,NULL),(131,'','公用文档库管理',1,'docfolder/common',NULL,'','',127,0,NULL),(132,'','公用文档库',1,'','/doc/common/','','2',88,0,NULL),(133,'','个人文档库',1,'','/doc/personal/','','3',88,0,NULL),(134,'','公告',1,'','/notice/folder/','','1',83,0,NULL),(136,'','消息',0,'message/index','','','4',83,0,NULL),(137,'','论坛',1,'','/forum/folder/','','3',83,0,NULL),(138,'','公告管理',1,'noticefolder/index',NULL,'','4',134,0,NULL),(139,'','论坛管理',1,'forumfolder/index',NULL,'','',137,0,NULL),(140,'','按月查看',1,'schedule/index','','','1',91,0,NULL),(141,'','日程查询',1,'schedule/search','','','2',91,0,NULL),(142,'','按日查看',1,'schedule/day_view','','','2',91,0,NULL),(143,'','邮件分类',1,'mailorganize/index',NULL,'','',102,0,NULL),(144,'','起案',1,'flow/index','','','1',87,0,1),(145,'','审批箱',1,'','','','2',87,0,1),(146,'','流程管理',1,'flowtype/index','','','3',87,0,NULL),(147,'','待审批',1,'flow/flow_list?folder=confirm','','','',145,0,NULL),(148,'','已办理',1,'flow/flow_list?folder=finish','','','',145,0,NULL),(149,'','草稿箱',1,'flow/flow_list?folder=darft','','','',145,0,NULL),(150,'','已提交',1,'flow/flow_list?folder=submit','','','',145,0,NULL),(151,'','收信',1,'mail/mail_list?folder=receve','','','2',85,0,1),(152,'','待办事项',1,'todo/index','','','4',91,0,NULL),(153,'','部门级别',1,'deptgrade/index','','','3',110,0,NULL),(154,'','业务权限',1,'duty/index','','','',112,0,NULL),(155,'','权限编码-业务权限',1,'role/duty','','','',112,0,1),(156,'','客户',1,'customer/index','','','2',157,0,0),(157,'','人脉',1,'contact/index','','','5',0,0,0),(158,'','供应商',1,'supplier/index','','','3',157,0,0),(159,'','进销存',1,'psi/index','','','7',0,0,0),(160,'','采购',1,'','','','1',159,0,0),(161,'','销售',1,'sales/index','','','4',159,0,0),(162,'','库存',1,'inventroy/index','','','6',159,0,0),(163,'','资材分类',1,'materialclass/index','','','4',168,0,0),(164,'','资材',1,'material/index','','','',168,0,0),(165,'','入库',1,'gi/index','','','2',160,0,0),(166,'','出库',1,'go/index','','','5',159,0,0),(167,'','加工',1,'gp/index','','','31',159,0,0),(168,'','基础数据',1,'','','','99',159,0,0),(169,'','职员',1,'staff/index','','','',157,0,0),(170,'','仓库',1,'warehouse/index','','','',168,0,0),(171,'','应付',1,'pay/index','','','5',160,0,0),(172,'','订单查询',1,'po/index','','','2',160,0,0),(173,'','新建订单',1,'po/add','','','1',160,0,0),(174,'','待入库订单',1,'gi/wait','','','3',160,0,0);

#
# Source for table "think_notice"
#

DROP TABLE IF EXISTS `think_notice`;
CREATE TABLE `think_notice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `notice_no` varchar(20) NOT NULL,
  `title` varchar(20) NOT NULL,
  `content` text NOT NULL,
  `type` varchar(20) NOT NULL,
  `add_file` varchar(200) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_name` varchar(20) NOT NULL,
  `to` text NOT NULL,
  `confirm` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `folder` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

#
# Data for table "think_notice"
#

INSERT INTO `think_notice` VALUES (24,'2013-0001','sssss','ssssssssssssssssssssssssss','','',1,'管理员','',0,1,1366874793,0,15);

#
# Source for table "think_pay"
#

DROP TABLE IF EXISTS `think_pay`;
CREATE TABLE `think_pay` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `po_no` varchar(10) DEFAULT NULL,
  `gi_no` varchar(10) DEFAULT NULL,
  `prepay` decimal(10,2) DEFAULT NULL,
  `payable` decimal(10,2) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `status` tinyint(3) NOT NULL DEFAULT '1',
  `supplier` int(11) DEFAULT NULL,
  `paid` tinyint(3) NOT NULL DEFAULT '0',
  `paid_time` int(11) DEFAULT '0',
  `user_id` int(11) DEFAULT NULL,
  `user_name` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

#
# Data for table "think_pay"
#

INSERT INTO `think_pay` VALUES (15,'2013-0002',NULL,1200.00,NULL,1367476201,NULL,1,19,1,1367482931,NULL,NULL),(16,'2013-0003',NULL,1500.00,NULL,1367479252,NULL,1,18,1,1367482749,NULL,NULL);

#
# Source for table "think_po"
#

DROP TABLE IF EXISTS `think_po`;
CREATE TABLE `think_po` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `po_no` varchar(20) DEFAULT NULL,
  `supplier` int(11) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `status` tinyint(3) NOT NULL DEFAULT '1',
  `total` decimal(10,2) DEFAULT NULL,
  `po_date` date DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_name` varchar(20) DEFAULT NULL,
  `type` tinyint(1) DEFAULT NULL,
  `payment` tinyint(3) DEFAULT NULL,
  `finish` tinyint(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;

#
# Data for table "think_po"
#

INSERT INTO `think_po` VALUES (42,'2013-0001',18,1367476133,NULL,'',1,10000.00,'2013-05-02',1,'管理员',1,2,0),(43,'2013-0002',19,1367476201,NULL,'',1,1200.00,'2013-05-02',1,'管理员',1,1,0),(44,'2013-0003',18,1367479252,NULL,'',1,1500.00,'2013-05-02',1,'管理员',1,1,0);

#
# Source for table "think_po_item"
#

DROP TABLE IF EXISTS `think_po_item`;
CREATE TABLE `think_po_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `po_no` varchar(20) DEFAULT NULL,
  `mat_no` varchar(255) DEFAULT NULL,
  `qty` decimal(10,3) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `sum` decimal(10,2) DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=46 DEFAULT CHARSET=utf8;

#
# Data for table "think_po_item"
#

INSERT INTO `think_po_item` VALUES (53,'2013-0001','ZC0001',1.000,10000.00,10000.00,''),(54,'2013-0002','CODE0010',3.000,400.00,1200.00,''),(55,'2013-0003','CODE0012',2.000,300.00,600.00,''),(56,'2013-0003','CODE0012',3.000,300.00,900.00,'');

#
# Source for table "think_position"
#

DROP TABLE IF EXISTS `think_position`;
CREATE TABLE `think_position` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(6) NOT NULL,
  `name` varchar(20) NOT NULL,
  `sort` varchar(10) NOT NULL,
  `status` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

#
# Data for table "think_position"
#

INSERT INTO `think_position` VALUES (1,'PG1','总经理','',1),(2,'PG2','副总经理','',1),(3,'PG3','部长','',1),(4,'PG4','经理1','',1),(5,'RG1','总经理','',0);

#
# Source for table "think_post"
#

DROP TABLE IF EXISTS `think_post`;
CREATE TABLE `think_post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tid` int(11) NOT NULL,
  `title` varchar(20) NOT NULL,
  `content` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_name` varchar(20) NOT NULL,
  `add_file` varchar(200) NOT NULL,
  `status` int(11) NOT NULL,
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;

#
# Data for table "think_post"
#


#
# Source for table "think_push"
#

DROP TABLE IF EXISTS `think_push`;
CREATE TABLE `think_push` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `data` text NOT NULL,
  `status` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  `info` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=530 DEFAULT CHARSET=utf8;

#
# Data for table "think_push"
#


#
# Source for table "think_rank"
#

DROP TABLE IF EXISTS `think_rank`;
CREATE TABLE `think_rank` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(6) NOT NULL,
  `name` varchar(20) NOT NULL,
  `sort` varchar(10) NOT NULL,
  `status` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

#
# Data for table "think_rank"
#

INSERT INTO `think_rank` VALUES (1,'RG10','总经理','',1),(2,'RG20','副总经理','',1),(3,'RG30','部长','',1),(4,'RG40','科长','',1);

#
# Source for table "think_recent"
#

DROP TABLE IF EXISTS `think_recent`;
CREATE TABLE `think_recent` (
  `user_id` int(11) NOT NULL,
  `recent` varchar(2000) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Data for table "think_recent"
#

INSERT INTO `think_recent` VALUES (1,'smeoa@qq.com|smeoa@qq.com;');

#
# Source for table "think_refer"
#

DROP TABLE IF EXISTS `think_refer`;
CREATE TABLE `think_refer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `type` varchar(20) NOT NULL,
  `code` varchar(20) NOT NULL,
  `name` varchar(20) NOT NULL,
  `pid` int(11) NOT NULL,
  `sort` smallint(6) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`),
  KEY `id_2` (`id`,`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1031 DEFAULT CHARSET=utf8;

#
# Data for table "think_refer"
#

INSERT INTO `think_refer` VALUES (1004,0,'mail_folder','3','12345',0,123,1),(1005,0,'mail_folder','2','123',0,123,1),(1008,0,'mail_folder','1','222221222',0,32767,1),(1009,0,'work_warn','none','无',0,1,1),(1010,0,'work_warn','m_5','五分钟',0,2,1),(1011,0,'work_warn','m_10','10分钟',0,3,1),(1012,0,'work_warn','h_1','1小时',0,2,1),(1013,0,'work_warn','m_20','20分钟',0,2,1),(1014,0,'work_warn','m_30','30分钟',0,4,1),(1015,0,'work_warn','h_2','2小时',0,2,1),(1016,0,'work_warn','h_3','2小时',0,3,1),(1017,0,'work_warn','h_4','4小时',0,4,1),(1018,0,'work_warn','h_3','3小时',0,3,0),(1019,0,'work_warn','d_1','1天',0,4,1),(1020,0,'work_warn','d_2','2天',0,4,1),(1021,0,'work_warn','d_3','3天',0,4,1),(1022,0,'work_warn','d_4','4天',0,4,1),(1023,0,'work_warn','d_7','一周',0,4,1),(1024,0,'work_warn','d_14','两周',0,4,1),(1025,0,'work_type','1','计划',0,1,1),(1026,0,'work_type','2','日志',0,2,1),(1027,0,'work_type','3','会议',0,3,1),(1028,0,'work_type','4','约会',0,4,1),(1029,0,'work_type','5','任务',0,5,1),(1030,0,'work_type','6','其他',0,6,1);

#
# Source for table "think_role"
#

DROP TABLE IF EXISTS `think_role`;
CREATE TABLE `think_role` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `pid` smallint(6) DEFAULT NULL,
  `status` tinyint(1) unsigned DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `sort` varchar(20) DEFAULT NULL,
  `create_time` int(11) unsigned NOT NULL,
  `update_time` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `parentId` (`pid`),
  KEY `ename` (`sort`),
  KEY `status` (`status`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

#
# Data for table "think_role"
#

INSERT INTO `think_role` VALUES (1,'公司管理员',0,1,'','1',1208784792,1333026192),(2,'基本权限',0,1,'','2',1215496283,1303454233),(7,'测试组',0,1,'','2',1254325787,1303454193);

#
# Source for table "think_role_duty"
#

DROP TABLE IF EXISTS `think_role_duty`;
CREATE TABLE `think_role_duty` (
  `role_id` smallint(6) unsigned NOT NULL,
  `duty_id` smallint(6) unsigned NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Data for table "think_role_duty"
#

INSERT INTO `think_role_duty` VALUES (1,14),(1,15),(2,14),(2,15);

#
# Source for table "think_role_node"
#

DROP TABLE IF EXISTS `think_role_node`;
CREATE TABLE `think_role_node` (
  `role_id` int(11) NOT NULL,
  `node_id` int(11) NOT NULL,
  `admin` tinyint(1) DEFAULT NULL,
  `read` tinyint(1) DEFAULT NULL,
  `write` tinyint(1) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Data for table "think_role_node"
#

INSERT INTO `think_role_node` VALUES (2,136,NULL,NULL,NULL),(2,137,NULL,NULL,NULL),(2,135,NULL,NULL,NULL),(2,134,NULL,NULL,NULL),(1,94,NULL,NULL,NULL),(1,97,NULL,NULL,NULL),(1,98,NULL,NULL,NULL),(1,99,NULL,NULL,NULL),(1,69,NULL,NULL,NULL),(1,6,NULL,NULL,NULL),(1,2,NULL,NULL,NULL),(1,7,NULL,NULL,NULL),(1,126,NULL,NULL,NULL),(1,132,NULL,NULL,NULL),(1,133,NULL,NULL,NULL),(1,127,NULL,NULL,NULL),(1,131,NULL,NULL,NULL),(1,130,NULL,NULL,NULL),(1,139,NULL,NULL,NULL),(1,137,NULL,NULL,NULL),(1,135,NULL,NULL,NULL),(1,138,NULL,NULL,NULL),(1,117,NULL,NULL,NULL),(1,134,NULL,NULL,NULL),(1,136,NULL,NULL,NULL),(2,125,NULL,NULL,NULL),(2,100,NULL,NULL,NULL),(2,101,NULL,NULL,NULL),(2,105,NULL,NULL,NULL),(2,106,NULL,NULL,NULL),(2,107,NULL,NULL,NULL),(2,104,NULL,NULL,NULL),(2,102,NULL,NULL,NULL),(2,108,NULL,NULL,NULL),(2,124,NULL,NULL,NULL),(2,103,NULL,NULL,NULL),(2,100,NULL,NULL,NULL),(2,126,NULL,NULL,NULL),(2,132,NULL,NULL,NULL),(2,133,NULL,NULL,NULL),(2,130,NULL,NULL,NULL),(2,125,NULL,NULL,NULL),(7,124,NULL,NULL,NULL),(7,108,NULL,NULL,NULL),(7,102,NULL,NULL,NULL),(7,104,NULL,NULL,NULL),(7,107,NULL,NULL,NULL),(7,106,NULL,NULL,NULL),(7,105,NULL,NULL,NULL),(7,101,NULL,NULL,NULL),(7,100,NULL,NULL,NULL),(7,125,NULL,NULL,NULL),(1,140,NULL,NULL,NULL),(1,142,NULL,NULL,NULL),(1,141,NULL,NULL,NULL),(2,100,NULL,NULL,NULL),(2,151,NULL,NULL,NULL),(2,101,NULL,NULL,NULL),(2,105,NULL,NULL,NULL),(2,106,NULL,NULL,NULL),(2,107,NULL,NULL,NULL),(2,104,NULL,NULL,NULL),(2,102,NULL,NULL,NULL),(2,108,NULL,NULL,NULL),(2,124,NULL,NULL,NULL),(2,103,NULL,NULL,NULL),(2,125,NULL,NULL,NULL),(1,140,NULL,NULL,NULL),(1,142,NULL,NULL,NULL),(1,141,NULL,NULL,NULL),(2,151,NULL,NULL,NULL),(2,101,NULL,NULL,NULL),(2,105,NULL,NULL,NULL),(2,106,NULL,NULL,NULL),(2,107,NULL,NULL,NULL),(2,104,NULL,NULL,NULL),(2,103,NULL,NULL,NULL),(2,109,NULL,NULL,NULL),(2,102,NULL,NULL,NULL),(2,143,NULL,NULL,NULL),(2,108,NULL,NULL,NULL),(2,124,NULL,NULL,NULL),(2,144,NULL,NULL,NULL),(2,145,NULL,NULL,NULL),(2,149,NULL,NULL,NULL),(2,147,NULL,NULL,NULL),(2,148,NULL,NULL,NULL),(2,150,NULL,NULL,NULL),(2,140,NULL,NULL,NULL),(2,142,NULL,NULL,NULL),(2,141,NULL,NULL,NULL),(2,152,NULL,NULL,NULL),(1,117,NULL,NULL,NULL),(1,117,NULL,NULL,NULL),(1,117,NULL,NULL,NULL),(1,117,NULL,NULL,NULL),(1,103,NULL,NULL,NULL),(1,109,NULL,NULL,NULL),(1,117,NULL,NULL,NULL),(1,117,NULL,NULL,NULL),(1,168,NULL,NULL,NULL),(1,162,NULL,NULL,NULL),(1,156,NULL,NULL,NULL),(1,166,NULL,NULL,NULL),(1,161,NULL,NULL,NULL),(1,128,NULL,NULL,NULL),(1,146,NULL,NULL,NULL),(1,122,NULL,NULL,NULL),(1,123,NULL,NULL,NULL),(1,121,NULL,NULL,NULL),(1,113,NULL,NULL,NULL),(1,120,NULL,NULL,NULL),(1,119,NULL,NULL,NULL),(1,118,NULL,NULL,NULL),(1,154,NULL,NULL,NULL),(1,155,NULL,NULL,NULL),(1,112,NULL,NULL,NULL),(1,116,NULL,NULL,NULL),(1,111,NULL,NULL,NULL),(1,153,NULL,NULL,NULL),(1,125,NULL,NULL,NULL),(1,115,NULL,NULL,NULL),(1,114,NULL,NULL,NULL),(1,110,NULL,NULL,NULL),(1,149,NULL,NULL,NULL),(1,150,NULL,NULL,NULL),(1,148,NULL,NULL,NULL),(1,147,NULL,NULL,NULL),(1,145,NULL,NULL,NULL),(1,144,NULL,NULL,NULL),(1,124,NULL,NULL,NULL),(1,108,NULL,NULL,NULL),(1,143,NULL,NULL,NULL),(1,102,NULL,NULL,NULL),(1,104,NULL,NULL,NULL),(1,107,NULL,NULL,NULL),(1,106,NULL,NULL,NULL),(1,105,NULL,NULL,NULL),(1,101,1,1,1),(1,151,1,1,1),(1,100,NULL,NULL,NULL),(1,169,NULL,NULL,NULL),(1,167,NULL,NULL,NULL),(1,171,NULL,NULL,NULL),(1,165,NULL,NULL,NULL),(1,173,NULL,NULL,NULL),(1,172,NULL,NULL,NULL),(1,158,NULL,NULL,NULL),(1,174,NULL,NULL,NULL),(1,160,NULL,NULL,NULL),(1,164,NULL,NULL,NULL),(1,170,NULL,NULL,NULL),(1,163,NULL,NULL,NULL);

#
# Source for table "think_role_user"
#

DROP TABLE IF EXISTS `think_role_user`;
CREATE TABLE `think_role_user` (
  `role_id` mediumint(9) unsigned DEFAULT NULL,
  `user_id` char(32) DEFAULT NULL,
  KEY `group_id` (`role_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Data for table "think_role_user"
#

INSERT INTO `think_role_user` VALUES (4,'27'),(4,'26'),(5,'31'),(3,'22'),(7,'1'),(1,'4'),(1,'3'),(2,'2'),(1,'35'),(1,'36'),(1,'2'),(2,'1'),(2,'3'),(1,'1'),(7,'36');

#
# Source for table "think_schedule"
#

DROP TABLE IF EXISTS `think_schedule`;
CREATE TABLE `think_schedule` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `content` text NOT NULL,
  `location` varchar(50) NOT NULL,
  `user_id` int(11) NOT NULL,
  `cycle` varchar(20) NOT NULL,
  `type` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_date` date NOT NULL,
  `end_time` time NOT NULL,
  `warn_time` int(11) NOT NULL,
  `feedback` text NOT NULL,
  `actor` varchar(200) NOT NULL,
  `add_file` varchar(200) NOT NULL,
  `status` int(11) NOT NULL,
  `priority` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=45 DEFAULT CHARSET=utf8;

#
# Data for table "think_schedule"
#

INSERT INTO `think_schedule` VALUES (43,'新建事项','','123123',1,'',0,'2013-03-01','05:00:00','2013-03-01','05:00:00',0,'','','',1,3),(44,'qqqqqqqqqqqqqq','','',1,'',0,'2013-04-25','05:00:00','2013-03-13','05:00:00',0,'','','',1,3);

#
# Source for table "think_supplier"
#

DROP TABLE IF EXISTS `think_supplier`;
CREATE TABLE `think_supplier` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `letter` varchar(50) DEFAULT '',
  `short` varchar(30) DEFAULT '',
  `account` varchar(20) DEFAULT '',
  `tax_no` varchar(20) DEFAULT '',
  `payment` varchar(20) DEFAULT NULL,
  `contact` varchar(20) NOT NULL DEFAULT '',
  `office_tel` varchar(20) DEFAULT NULL,
  `mobile_tel` varchar(20) DEFAULT '',
  `email` varchar(50) DEFAULT '',
  `im` varchar(20) DEFAULT '',
  `address` varchar(50) DEFAULT '',
  `user_id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `remark` text,
  `fax` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

#
# Data for table "think_supplier"
#

INSERT INTO `think_supplier` VALUES (18,'供应商2','GYS','供应2','4321','4321','ZZ ','联系人','1234','','ABC@QQ.COM','',' XX',1,1,'',''),(19,'供应商1','GY','供应','1234','4321','ZZ ','联系人','1234','','YY@QQ.COM','',' XX',0,1,NULL,NULL);

#
# Source for table "think_todo"
#

DROP TABLE IF EXISTS `think_todo`;
CREATE TABLE `think_todo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `content` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` varchar(10) DEFAULT NULL,
  `priority` int(11) NOT NULL,
  `add_file` varchar(200) NOT NULL,
  `status` int(11) NOT NULL,
  `sort` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

#
# Data for table "think_todo"
#

INSERT INTO `think_todo` VALUES (11,'邮件整理时显示名称错误','',1,'0000-00-00','',3,'',2,NULL),(12,'日历今天样式颜色','日历今天样式颜色',1,'0000-00-00','',3,'',1,NULL);

#
# Source for table "think_try"
#

DROP TABLE IF EXISTS `think_try`;
CREATE TABLE `think_try` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL DEFAULT '',
  `email` varchar(255) NOT NULL DEFAULT '',
  `phone` varchar(20) DEFAULT NULL,
  `company` varchar(255) DEFAULT NULL,
  `industry` varchar(40) DEFAULT NULL,
  `message` text,
  `qq` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

#
# Data for table "think_try"
#


#
# Source for table "think_user"
#

DROP TABLE IF EXISTS `think_user`;
CREATE TABLE `think_user` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `emp_no` varchar(10) NOT NULL,
  `emp_name` varchar(20) NOT NULL,
  `letter` varchar(20) NOT NULL,
  `password` char(32) NOT NULL,
  `dept_id` int(11) NOT NULL,
  `position_id` int(11) NOT NULL,
  `rank_id` int(11) NOT NULL,
  `sex` varchar(50) NOT NULL,
  `birthday` date DEFAULT NULL,
  `last_login_ip` varchar(40) DEFAULT NULL,
  `login_count` int(8) DEFAULT NULL,
  `pic` varchar(200) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `duty` varchar(2000) NOT NULL,
  `office_tel` varchar(20) NOT NULL,
  `mobile_tel` varchar(20) NOT NULL,
  `create_time` int(11) unsigned NOT NULL,
  `update_time` int(11) unsigned NOT NULL,
  `status` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `account` (`emp_no`)
) ENGINE=MyISAM AUTO_INCREMENT=40 DEFAULT CHARSET=utf8;

#
# Data for table "think_user"
#

INSERT INTO `think_user` VALUES (1,'admin','管理员','GLY','21232f297a57a5a743894a0e4a801fc3',12,4,1,'male','0000-00-00','127.0.0.1',1686,'file/201304/517a2ab91564d.png','smeoa_admin@163.com','asdf','8691-0038','1',1222907803,1366960827,1),(2,'demo','演示','YS','fe01ce2a7fbac8fafaed7c982a04e229',9,3,3,'male','2012-03-09','127.0.0.1',109,'','demo@smeoa.com','asdf','','2',1239783735,1358235897,1),(3,'member','员工','YG','202cb962ac59075b964b07152d234b70',6,4,4,'male','2012-03-15','127.0.0.1',19,'','member@smeoa.com','asd','','3',1253514375,1358235911,1),(4,'leader','领导','LD','c444858e0aaeb727da73d2eae62321ad',6,2,1,'male','2012-03-16','127.0.0.1',15,'','leader@smeoa.com','fa','领导','4',1253514575,1358235923,1),(35,'test1','test','TEST','098f6bcd4621d373cade4e832627b4f6',11,1,1,'male','0000-00-00','127.0.0.1',1,'','test1@smeoa.com','sdfa','tuser1','56',1329984605,1358235934,1),(36,'test','test233','TEST','098f6bcd4621d373cade4e832627b4f6',11,1,1,'male','2012-03-14','127.0.0.1',NULL,'','test@smeoa.com','sdf','1234','6',1331997666,1358235951,1);

#
# Source for table "think_warehouse"
#

DROP TABLE IF EXISTS `think_warehouse`;
CREATE TABLE `think_warehouse` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) DEFAULT NULL,
  `status` tinyint(3) DEFAULT NULL,
  `sort` int(11) DEFAULT NULL,
  `code` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

#
# Data for table "think_warehouse"
#

INSERT INTO `think_warehouse` VALUES (1,'一号仓库',1,1,'CK1'),(2,'二号仓库',1,2,'CK2'),(3,'三号仓库',1,3,'CK3');

/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
