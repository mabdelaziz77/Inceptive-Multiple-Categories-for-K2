<?php
/**
 * @version		1.0
 * @package		Inceptive Mutliple Categories for K2
 * @author		Inceptive Design Labs - http://www.inceptive.gr
 * @copyright	Copyright (c) 2006 - 2012 Inceptive GP. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.model');

JTable::addIncludePath(JPATH_COMPONENT.DS.'tables');

class K2ModelCategory extends K2Model
{
    function countCategoryItems($catid, $trash = 0)
	{
        $db = JFactory::getDBO();
        $catid = (int)$catid;
        //$query = "SELECT COUNT(*) FROM #__k2_items WHERE catid={$catid} AND trash = ".(int)$trash;
		$query = "SELECT COUNT(*)  FROM #__k2_multiple_categories mc RIGHT JOIN #__k2_items as i ON i.id = mc.itemID WHERE mc.catid={$catid} AND trash= ".(int)$trash;
        $db->setQuery($query);
        $result = $db->loadResult();
        return $result;

    }

}
