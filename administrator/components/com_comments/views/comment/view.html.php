<?php
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

jimport( 'joomla.application.component.view' );

class CommentsViewComment extends JView
{
    function display($tpl = null)
    {
		global $mainframe, $option; 
		$db		=& JFactory::getDBO();
		$uri 	=& JFactory::getURI();
		$user 	=& JFactory::getUser();
		$model	=& $this->getModel();
		$lists = array();
		//get the data
		$item		=& $this->get('Data');
		// fail if checked out not by 'me'
		if ( $model->isCheckedOut( $user->get('id') ) )
		{
			$msg = JText::sprintf( 'DESCBEINGEDITTED', JText::_( 'item' ), $item->comment );
			$mainframe->redirect( 'index.php?option='. $option, $msg );
		}
		// build the html select list for ordering

		// build the html select list
		$lists['published'] 	= JHTML::_('select.booleanlist',  'published', 'class="inputbox"', $item->published );
		//clean weblink data
		JFilterOutput::objectHTMLSafe( $item, ENT_QUOTES, 'comment' );
		// parameters
		
		require_once(JPATH_COMPONENT.DS.'lib'.DS.'article.php' );
		$element = new JElementArticle;

		if (!empty($item->article_id))
		{
			$lists['article'] = $element->fetchElement('a', $item->article_id, $xmlParameter, 'article', 1 );
		}
		else
		{
			$lists['article'] = $element->fetchElement('a', '0', $xmlParameter, 'article', 1 );
		}		
		
	
		// Action
		$action = JRoute::_('index.php?option='.$option);
		// Assign References
		$this->assignRef('action',	$action);
		$this->assignRef('lists', 	$lists);
		$this->assignRef('item',	$item);
		parent::display($tpl);
	}
	
	
}