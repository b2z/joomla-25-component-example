DROP TABLE IF EXISTS `#__helloworld`;

CREATE TABLE `#__helloworld` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `asset_id` INT(10) NOT NULL DEFAULT '0',
 `greeting` varchar(25) NOT NULL,
 `catid` int(11) NOT NULL DEFAULT '0',
 `params` TEXT NOT NULL DEFAULT '',
 PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
 
INSERT INTO `#__helloworld` (`greeting`) VALUES
 ('Hello World!'),
 ('Good bye World!');