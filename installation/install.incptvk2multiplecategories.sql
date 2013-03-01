--
-- version 1.0.0
-- package Inceptive Mutliple Categories for K2
-- author Inceptive Design Labs <info@inceptive.gr>
-- link http://www.inceptive.gr
-- copyright Copyright (c) 2012 inceptive.gr
-- license GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
--
 
--
-- Table structure for table `#__k2_multiple_categories`
--

CREATE TABLE IF NOT EXISTS `#__k2_multiple_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `itemID` int(11) NOT NULL DEFAULT '0',
  `catID` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

INSERT INTO `#__k2_multiple_categories`  (`#__k2_multiple_categories`.itemID, `#__k2_multiple_categories`.catID)
SELECT `#__k2_items`.id, `#__k2_items`.catid
FROM `#__k2_items`;