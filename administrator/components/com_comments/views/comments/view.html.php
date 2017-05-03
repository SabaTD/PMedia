<?php
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

jimport( 'joomla.application.component.view' );
class CommentsViewComments extends JView
{
    function display($tpl = NULL)
    {
		global $mainframe, $option;
		// Define
		$db		=& JFactory::getDBO();
		$uri	=& JFactory::getURI(); 
		// Get data from the model
	
		$items		=& $this->get( 'Data');
		$total		=& $this->get( 'Total');
		$pagination =& $this->get( 'Pagination' );

		// build lists
		$lists =& $this->_buildLists();
		// Action
		$action = JRoute::_('index.php?option='.$option);
		
		// Assign References
		$this->assignRef('action',	$action);
		$this->assignRef('user',		JFactory::getUser());
		$this->assignRef('lists',		$lists);
		$this->assignRef('items',		$items);
		$this->assignRef('pagination',	$pagination);	
	
		// Display
		parent::display($tpl);
    }
	

	/**
	 * Build sort list
	 * 
	 * @access private
	 * @return 
	 */
	function &_buildLists()
	{
		global $mainframe, $option;
		// Request data
		$filter_state		= $mainframe->getUserStateFromRequest( $option.'filter_state','filter_state','','word' );
		$article_id	= $mainframe->getUserStateFromRequest( $option.'article_id','article_id');
		$filter_order		= $mainframe->getUserStateFromRequest( $option.'filter_order','filter_order','','cmd' );
		$filter_order_Dir = $mainframe->getUserStateFromRequest( $option.'filter_order_Dir','filter_order_Dir',	'desc','word' );
		
		$search = $mainframe->getUserStateFromRequest( $option.'search', 'search', '', 'string' );
		$search = JString::strtolower( $search );
		// declare lists
		$lists = array();
		
		// state filter
		$lists['state']	= JHTML::_('grid.state',  $filter_state );
		
		// container
		$attr['onchange'] = 'document.adminForm.submit();';
		$lists['article_id'] = $article_id;
			
		// table ordering
		$lists['order_Dir'] = $filter_order_Dir;
		$lists['order'] = $filter_order;
		$lists['search']= $search;
		return $lists;
	}
}