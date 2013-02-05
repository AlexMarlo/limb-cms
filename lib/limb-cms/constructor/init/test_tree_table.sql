CREATE TABLE `test_category` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(255) DEFAULT NULL,
  `identifier` varchar(128) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `is_published` tinyint(1) DEFAULT 0,
  `parent_id` int(11) DEFAULT 0,
  `level` int(11) DEFAULT 0,
  `path` varchar(255) DEFAULT NULL,
  `priority` int(6) DEFAULT 0,
  `ctime` int(11) DEFAULT NULL,
  `utime` int(11) DEFAULT NULL,
  PRIMARY KEY  (`id`),
  KEY `level` (`level`),
  KEY `parent_id` (`parent_id`),
  KEY `id` (`id`,`parent_id`),
  KEY `identifier` (`identifier`,`level`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `test_item` (
  `id` int(11) NOT NULL auto_increment,
  `test_category_id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `article` varchar(255) DEFAULT NULL,
  `is_published` tinyint(1) DEFAULT 0,
  `priority` int(6) DEFAULT 0,
  `ctime` int(11) DEFAULT NULL,
  `utime` int(11) DEFAULT NULL,
  PRIMARY KEY  (`id`),
  KEY `test_category_id` (`test_category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;