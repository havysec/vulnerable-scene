CREATE TABLE `mob_potd` (
  `potd_id` int(10) NOT NULL auto_increment,
  `potd_img_id` int(10) NOT NULL default '0',
  `potd_date` date NOT NULL default '0000-00-00',
  PRIMARY KEY  (`potd_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;