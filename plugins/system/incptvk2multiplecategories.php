<?php
/**
 * @version		1.1
 * @package		Inceptive Mutliple Categories for K2
 * @author		Inceptive Design Labs - http://www.inceptive.gr
 * @copyright	Copyright (c) 2006 - 2012 Inceptive GP. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

defined('JPATH_BASE') or die ;

class plgSystemIncptvk2multiplecategories extends JPlugin 
{
    public function __construct(&$subject, $config)
    {
        parent::__construct($subject, $config);
    }
	
    public function onAfterRoute()
    {
	$mainframe = JFactory::getApplication();
	if(JRequest::getCMD('option') == 'com_k2' && JRequest::getCMD('view')  == 'categories' && $mainframe->isAdmin())
	{
	       JLoader::import( 'category', JPATH_PLUGINS . DS . 'k2' . DS . 'incptvk2multiplecategories' . DS . 'models' );
	}

	if(JRequest::getCMD('option') == 'com_k2' && JRequest::getCMD('view')  == 'itemlist'  && JRequest::getCMD('task')=='category' && !$mainframe->isAdmin())
	{
	       JLoader::import( 'itemlist', JPATH_PLUGINS . DS . 'k2' . DS . 'incptvk2multiplecategories' . DS . 'models' );			
	}
	
	if ($mainframe->isAdmin())
	{
	    $file = JPATH_ROOT . DS . 'components' . DS . 'com_k2' . DS . 'models'. DS . 'itemlist.php';
	    $itemListFileMD5 = md5_file($file); 
	    $savedItemListFileMD5 = $this->params->get('itemlistMD5','');
	    
	    if($savedItemListFileMD5 != $itemListFileMD5)
	    {
		$oldClass = file_get_contents(JPATH_ROOT . DS . 'components' . DS . 'com_k2' . DS . 'models'. DS . 'itemlist.php');
		$countCategoryItemsPosition = strpos($oldClass, 'countCategoryItems');
		$pos1 = strpos($oldClass, 'SELECT COUNT(*)', $countCategoryItemsPosition);
		$pos3 = strpos($oldClass, ';', $pos1);
		$newQueryStart = "SELECT COUNT(*) FROM #__k2_multiple_categories mc RIGHT JOIN #__k2_items as i ON i.id = mc.itemID WHERE mc.catid IN (\".implode(',', \$categories).\") AND published=1 AND trash=0\"";
		$newClass = substr_replace($oldClass, $newQueryStart, $pos1, $pos3-$pos1);
		$file = JPATH_PLUGINS . DS . 'k2' . DS . 'incptvk2multiplecategories' . DS . 'models' . DS . 'itemlist.php';
		file_put_contents($file, $newClass);
		
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		
		// Fields to update.
		$fields = array( 'params=\'{"itemlistMD5":"'.$itemListFileMD5.'"}\'' );

		// Conditions for which records should be updated.
		$conditions = array(
			'element=\'incptvk2multiplecategories\'', 
			'folder=\'system\'');

		$query->update($db->quoteName('#__extensions'))->set($fields)->where($conditions);

		$db->setQuery($query);

		try
		{
		    $result = $db->query(); // Use $db->execute() for Joomla 3.0.
		} 
		catch (Exception $e)
		{
		    // Catch the error.
		}
		
	    }
	}
     }
}
