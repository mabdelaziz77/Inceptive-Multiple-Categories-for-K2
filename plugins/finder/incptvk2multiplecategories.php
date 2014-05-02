<?php
/**
 * @version		1.0
 * @package		Inceptive Multiple Categories for K2
 * @author		Inceptive Design Labs - http://www.inceptive.gr
 * @copyright	Copyright (c) 2014 Inceptive Design Labs. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

defined('JPATH_BASE') or die ;

jimport('joomla.application.component.helper');

// Load the base adapter.
require_once JPATH_ADMINISTRATOR.'/components/com_finder/helpers/indexer/adapter.php';

class plgFinderIncptvk2multiplecategories extends FinderIndexerAdapter
{
    public function __construct(&$subject, $config)
    {
        parent::__construct($subject, $config);
        $this->loadLanguage();
    }

    public function onFinderAfterDelete($context, $table)
    {
        $db = JFactory::getDbo();
 
	$query = $db->getQuery(true);

	$conditions = array('itemID='.$table->id);

	$query->delete($db->quoteName('#__k2_multiple_categories'));
	$query->where($conditions);

	$db->setQuery($query);

	try {
	   $result = $db->query(); // $db->execute(); for Joomla 3.0.
	} catch (Exception $e) {
	   // catch the error.
	}
    }

    protected function index(\FinderIndexerResult $item) {
	
    }

    protected function setup() {
	
    }
}
