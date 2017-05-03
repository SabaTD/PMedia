<?php
/**
 * All Streams Helper of JMultimedia Component
 * @package			Joomla
 * @subpackage	JMultimedia
 * @copyright	Copyright (C) 2005 - 2008 Open Source Matters. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 */

class comCommentsHelper
{
	/**
	 * Create HTML select list with conteiners
	 * 
	 * @static
	 * @return void
	 * @param string $tbl
	 * @param string $name [optional]
	 */ 
	function selectList( $selected=0 )
	{
		$name='article_id';
		$db		=& JFactory::getDBO();
		$query = 'SELECT id AS value, title AS text'
			. ' FROM #__content'
			. ' ORDER BY text'; 
		$db->setQuery($query);
		mb_internal_encoding("UTF-8");
		$options = $db->loadObjectList();	
		$opt = array();
		foreach($options as $option)
		{
			if(mb_strlen($option->text)>50)
			{
				$str = mb_substr($option->text,0,25);
				$str .= ' ... ';
				$str .=  substr($option->text,25);
				$option->text = $str;
			}
			$opt[] = $option;
		}
		$attr = array();
		array_unshift( $opt, array('value'=>0, 'text'=>JText::_(' - Select Item - ')) );
		return JHTML::_('select.genericlist', $opt, $name, 
			$attr, 	//Additional list attributes
			'value',//The value key in the associative arrays or objects, normally value
			'text', 	//The text key in the associative arrays or objects, normally text
			$selected,//Key value of the currently selected option; default is null
			null, 	//List ID, default is null
			false );	//Translate text using JText; default is false
	}
}