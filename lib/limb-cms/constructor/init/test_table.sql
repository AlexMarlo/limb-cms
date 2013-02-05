CREATE TABLE `test_table` (
  `id` int(11) NOT NULL auto_increment,
  `priority` int(6) DEFAULT 0,
  `title` varchar(255) DEFAULT NULL,
  `identifier` varchar(128) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `is_published` tinyint(1) DEFAULT 0,
  `ctime` int(11) DEFAULT NULL,
  `utime` int(11) DEFAULT NULL,
  PRIMARY KEY  (`id`),
  KEY `id` (`id`),
  KEY `identifier` (`identifier`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;