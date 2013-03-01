<?php

// no direct access
defined('_JEXEC') or die;

class TableIncptvK2MultipleCategories extends JTable
{
	/**
	 * @param	JDatabase	A database connector object
	 */
	function __construct(&$db){
		parent::__construct('#__k2_multiple_categories', 'itemID', $db);
	}
	
	public function change_key($key, $db){
		parent::__construct('#__k2_multiple_categories', $key, $db);
	}

	/**
	 * Overloaded bind function
	 *
	 * @param	array		Named array
	 * @return	null|string	null is operation was satisfactory, otherwise returns an error
	 * @since	1.6
	 */
	public function bind($array, $ignore = '')
	{
		return parent::bind($array, $ignore);
	}

	/**
	 * Overloaded store function
	 *
	 * @param	boolean	True to update fields even if they are null.
	 * @return	boolean	True on success, false on failure.
	 * @since	1.6
	 */
	public function store($updateNulls = false)
	{
		// Attempt to store the data.
		return parent::store($updateNulls);
	}

	/**
	 * Overloaded check function
	 *
	 * @return boolean
	 * @see JTable::check
	 * @since 1.5
	 */
	function check()
	{
		return true;
	}
	
	function getSomeObjectsList($query){
	    $this->_db->setQuery($query);
	    $rows = $this->_db->loadObjectList();
	    return $rows;
	}
	
}