DROP TABLE IF EXISTS `#__comments`;
CREATE TABLE IF NOT EXISTS `#__comments` (
  `id` int(11) NOT NULL auto_increment,
  `ip` varchar(23) character set utf8 NOT NULL,
  `article_id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `author` text character set utf8 NOT NULL,
  `mail` varchar(255) collate utf8_unicode_ci NOT NULL,
  `comment` text character set utf8 NOT NULL,
  `added` datetime NOT NULL,
  `published` tinyint(1) NOT NULL,
  `checked_out` int(11) NOT NULL,
  `checked_out_time` datetime NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `userid` (`userid`),
  KEY `container` (`article_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;