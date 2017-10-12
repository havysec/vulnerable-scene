<?php
/************************************************************************
 * This file is part of Make or Break.					*
 *									*
 * Make or Break is free software: you can redistribute it and/or modify*
 * it under the terms of the GNU General Public License as published by	*
 * the Free Software Foundation, either version 3 of the License, or	*
 * (at your option) any later version.					*
 *									*
 * Make or Break is distributed in the hope that it will be useful,	*
 * but WITHOUT ANY WARRANTY; without even the implied warranty of	*
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the	*
 * GNU General Public License for more details.				*
 *									*
 * You should have received a copy of the GNU General Public License	*
 * along with Make or Break.  If not, see <http://www.gnu.org/licenses>.*
 ************************************************************************/

$sql = ("CREATE TABLE `".$prefix."admin` (
  `id` int(4) NOT NULL auto_increment,
  `username` varchar(65) NOT NULL default '',
  `password` varchar(65) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 AUTO_INCREMENT=2");
mysql_query($sql);

$sql = ("INSERT INTO `".$prefix."admin` VALUES (1, 'admin', 'password')");
mysql_query($sql);

$sql = ("CREATE TABLE `".$prefix."banned` (
  `b_id` int(255) NOT NULL auto_increment,
  `b_date` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `b_ip` varchar(20) NOT NULL default '',
  `b_reason` text NOT NULL,
  `b_message` text NOT NULL,
  `b_link` text NOT NULL,
  PRIMARY KEY  (`b_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 AUTO_INCREMENT=4");
mysql_query($sql);

$sql = ("CREATE TABLE `".$prefix."categories` (
  `cat_id` int(255) NOT NULL auto_increment,
  `cat_name` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`cat_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 AUTO_INCREMENT=3");
mysql_query($sql);

$sql = ("INSERT INTO `".$prefix."categories` VALUES (1, 'Men')"); mysql_query($sql);
$sql = ("INSERT INTO `".$prefix."categories` VALUES (2, 'Woman')"); mysql_query($sql);

$sql = ("CREATE TABLE `".$prefix."comment` (
  `com_id` int(11) NOT NULL auto_increment,
  `com_img_id` int(11) NOT NULL default '0',
  `com_poster_name` varchar(255) NOT NULL default '',
  `com_date` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `com_message` text NOT NULL,
  `com_poster_ip` varchar(15) NOT NULL default '',
  PRIMARY KEY  (`com_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 AUTO_INCREMENT=1");
mysql_query($sql);

$sql = ("CREATE TABLE `".$prefix."images` (
  `img_id` int(11) NOT NULL auto_increment,
  `img_name` varchar(255) NOT NULL default '',
  `img_category` int(11) NOT NULL default '0',
  `img_filename` varchar(255) NOT NULL default '',
  `img_date` date NOT NULL default '0000-00-00',
  `img_uploader` varchar(255) NOT NULL default '',
  `img_uploader_ip` varchar(15) NOT NULL default '',
  `img_total_votes` int(11) NOT NULL default '0',
  `img_total_points` int(11) NOT NULL default '0',
  `img_average` decimal(11,1) NOT NULL default '0.0',
  `img_description` text NOT NULL,
  PRIMARY KEY  (`img_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 AUTO_INCREMENT=5");
mysql_query($sql);

$sql = ("INSERT INTO `".$prefix."images` VALUES (1, 'Gerard Butler', 1, '1_gerard_butler.jpg', '2012-09-29', 'admin', '12.34.56.789', 0, 0, 0.0, '')");
mysql_query($sql);
$sql = ("INSERT INTO `".$prefix."images` VALUES (2, 'Hugh Jackman', 1, '2_hugh_jackman.jpg', '2012-09-29', 'admin', '12.34.56.789', 0, 0, 0.0, '')");
mysql_query($sql);
$sql = ("INSERT INTO `".$prefix."images` VALUES (3, 'Angelina Jolie', 2, '3_angelina_jolie.jpg', '2012-09-30', 'admin', '12.34.56.789', 0, 0, 0.0, '')");
mysql_query($sql);
$sql = ("INSERT INTO `".$prefix."images` VALUES (4, 'Cameron Diaz', 2, '4_cameron_diaz.jpg', '2012-09-30', 'admin', '84.82.13.133', 0, 0, 0.0, 'Cameron Michelle Diaz (born August 30, 1972) is an American actress and former model.\r\nShe rose to prominence during the 1990s with roles in the movies The Mask, My Best Friend''s Wedding and There''s Something About Mary. \r\nOther high-profile credits include the two Charlie''s Angels films, voicing the character Princess Fiona in the Shrek series, The Holiday, The Green Hornet and Bad Teacher. \r\nDiaz received Golden Globe award nominations for her performances in the movies There''s Something About Mary, Being John Malkovich, Vanilla Sky, and Gangs of New York. ')");
mysql_query($sql);

$sql = ("CREATE TABLE `".$prefix."potd` (
  `potd_id` int(10) NOT NULL auto_increment,
  `potd_img_id` int(10) NOT NULL default '0',
  `potd_date` date NOT NULL default '0000-00-00',
  PRIMARY KEY  (`potd_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 AUTO_INCREMENT=1");
mysql_query($sql);

$sql = ("CREATE TABLE `".$prefix."settings` (
  `id` int(10) NOT NULL auto_increment,
  `installed` int(1) NOT NULL default '1',
  `pagename` varchar(255) NOT NULL default '',
  `slogan` varchar(255) NOT NULL default '',
  `script_url` varchar(255) NOT NULL default '',
  `email` varchar(255) NOT NULL default '',
  `filesize` int(200) NOT NULL default '0',
  `template` text NOT NULL,
  `hitcounter` int(15) NOT NULL default '0',
  `hitcounterimg` text NOT NULL,
  `total_votes` int(11) NOT NULL default '0',
  `total_points` int(11) NOT NULL default '0',
  `average` decimal(11,1) NOT NULL default '0.0',
  `topimages` int(11) NOT NULL default '0',
  `advertising` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 AUTO_INCREMENT=2");
mysql_query($sql);

$sql = ("INSERT INTO `".$prefix."settings` VALUES (1, 1, '".$_POST[pagename]."', 'Vote or be voted', '".$_POST[scripturl]."', '".$_POST[email]."', 250, 'basic.css', 0, 'web1', 0, 0, 0.0, 10, '<center>\r\nHere you can show your advertising.<br>\r\nWhen you don''t want to show it you can delete anything in the box. <br>\r\nYou can find this box in the admin menu -> Edit Settings -> Header advertising.\r\n</center>')");
mysql_query($sql);

$sql = ("CREATE TABLE `".$prefix."uploads` (
  `upl_id` int(11) NOT NULL auto_increment,
  `upl_name` varchar(255) NOT NULL default '',
  `upl_category` int(11) NOT NULL default '0',
  `upl_filename` varchar(255) NOT NULL default '',
  `upl_date` date NOT NULL default '0000-00-00',
  `upl_uploader` varchar(255) NOT NULL default '',
  `upl_email` varchar(255) NOT NULL default '',
  `upl_ip` varchar(18) NOT NULL default '',
  `upl_description` text NOT NULL,
  PRIMARY KEY  (`upl_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 AUTO_INCREMENT=1");
mysql_query($sql);

$sql = ("CREATE TABLE `".$prefix."votes` (
  `vote_id` int(11) NOT NULL auto_increment,
  `vote_ip` tinytext NOT NULL,
  `vote_date` date NOT NULL default '0000-00-00',
  `vote_image_id` int(11) NOT NULL default '0',
  `vote_points` decimal(11,1) NOT NULL default '0.0',
  PRIMARY KEY  (`vote_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 AUTO_INCREMENT=1");
mysql_query($sql);
?>