CREATE TABLE `sign_kind` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `title` varchar(80) NOT NULL DEFAULT '',
  `doc` text,
  `beg_date` date NOT NULL DEFAULT '0000-00-00',
  `end_date` date NOT NULL DEFAULT '0000-00-00',
  `input_classY` varchar(40) DEFAULT '0',
  `stud_get` int(11) NOT NULL,
  `stud_get_more` int(11) NOT NULL,
  `get_data_item` varchar(200) NOT NULL,
  `input_data_item` varchar(200) DEFAULT '0',
  `admin` varchar(40) DEFAULT NULL,
  `is_hide` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM   COMMENT='校園報名類別';

CREATE TABLE `sign_data` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `kind` bigint(20) NOT NULL DEFAULT '0',
  `order_pos` tinyint(4) NOT NULL DEFAULT '0',
  `stud_name` varchar(30) NOT NULL DEFAULT '',
  `data_get` tinytext,
  `data_input` TEXT  NOT NULL,
  `class_id` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `myindex` (`class_id`,`kind`,`order_pos`)
) ENGINE=MyISAM    COMMENT='校園報名資料';