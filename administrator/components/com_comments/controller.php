<?php
/**
 * Controller for JMultimedia Component
 * 
 * @package  			JMultimedia Suite
 * @subpackage 	Components
 * @link 				http://3den.org
 * @license		GNU/GPL
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

jimport('joomla.application.component.controller');

/** TODO
 * JMultimedia Controller
 *
 * @package		Joomla
 * @subpackage	JMultimedia
 * @since 1.5
 */
class CommentsController extends JController
{
	function __construct($config = array())
	{
		parent::__construct($config);
		$this->registerTask( 'apply', 	'save' );
		$this->registerTask( 'add',		'edit' );
	}

	/**
	 * Save Comment
	 * 
	 * @return void
	 */
	function save()
	{
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );
		
		// get Model
		$model = $this->getModel('comment');
				
		// get Request data 
		$post	= JRequest::get('post');
		$post['comment'] = JRequest::getVar('comment', '', 'post', 'string', JREQUEST_ALLOWRAW);

		$post['article_id'] = isset($post['article']['a']) ? (int) $post['article']['a'] : 0;
		$post['userid'] = 0;


		// Save Success or Error
		if ( $model->store($post) )
		{
			$msg = JText::_( 'Successfully saved changes' );
			$type = 'message';
		}
		else
		{// error			
			$msg = JText::_( $model->getError() );
			$type = 'error';
		} 

		$link =  'index.php?option=com_comments&view=comments';	
		$this->setRedirect($link, $msg, $type);			
	}
	
	/**
	 * display the edit form 
	 * @return void
	 */
	function edit()
	{	
		// Set vars
		JRequest::setVar('view', 'comment');
		JRequest::setVar( 'layout', 'form'  );
		JRequest::setVar('hidemainmenu', 1);
		
		$model = $this->getModel('comment');
		$model->checkout();
		
		$this->display();
	}
	
	/**
	 * display items list 
	 * @return void
	 */
	function showList()
	{	
		// Set vars
		//JRequest::setVar( 'view', 'comments' );
		JRequest::setVar( 'layout', 'default'  );
		JRequest::setVar('hidemainmenu', 0);
		
		$this->display();
	}	
	
	/**
	 * Configure comments plugin
	 * 
	 *  @return void
	 */
	function confPlugin()
	{
		$db =& JFactory::getDBO();
		$query = 'SELECT id '
			. ' FROM #__plugins '
			. ' WHERE '
				. ' folder='.$db->Quote('content')
				. ' AND element = '. $db->Quote('comments');
		$db->setQuery($query);
		$id = $db->loadResult();		
		$link = 'index.php?option=com_plugins&view=plugin&client=site&task=edit&cid[]='.$id;
		$this->setRedirect($link);
	}
	

	/**
	 * Remove selected Items
	 * 
	 * @return void 
	 */
	function remove()
	{
		global $option;
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );

		// IDs
		$cid = JRequest::getVar( 'cid', array(0), 'post', 'array' );
	
		if (count( $cid ) < 1) {
			JError::raiseError(500, JText::_('Select an item to delete') );
		}

		$model = $this->getModel('comment');
		if( $model->delete($cid) ){// success
			$msg = JText::_( 'Successfully saved changes' );
			$type = 'message';
		}
		else{// error			
			$msg = JText::_( $model->getError() );
			$type = 'error';
		} 
		
		$link =  'index.php?option='.$option.'&view=comments';	
		$this->setRedirect($link, $msg, $type);				
	}

	/**
	 * Publish selected Items
	 * 
	 * @return 
	 */
	function publish()
	{
		global $option;
				
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );

		$cid = JRequest::getVar( 'cid', array(), 'post', 'array' );

		if (count( $cid ) < 1) {
			JError::raiseError(500, JText::_( 'Select an item to publish' ) );
		}

		$model = $this->getModel('comment');
		if( $model->publish($cid, 1) ){// success
			$msg = JText::_( 'Successfully saved changes' );
			$type = 'message';
		}
		else{// error			
			$msg = JText::_( $model->getError() );
			$type = 'error';
		} 		
		$link =  'index.php?option='.$option.'&view=comments';	
		$this->setRedirect($link, $msg, $type);			
	}

	
	/**
	 * Unpublish selected Items
	 * 
	 * @return 
	 */
	function unpublish()
	{
		global $option;		
		
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );
		
		$cid = JRequest::getVar( 'cid', array(), 'post', 'array' );
		JArrayHelper::toInteger($cid);
		
		if (count( $cid ) < 1) {
			JError::raiseError(500, JText::_( 'Select an item to unpublish' ) );
		}
		
		$model = $this->getModel('comment');
		if( $model->publish($cid, 0) ){// success
			$msg = JText::_( 'Successfully saved changes' );
			$type = 'message';
		}
		else{// error			
			$msg = JText::_( $model->getError() );
			$type = 'error';
		} 
		$link =  'index.php?option='.$option.'&view=comments';	
		$this->setRedirect($link, $msg, $type);			
	}
	

	/**
	 * Cancel Editing
	 * 
	 * @return void
	 */
	function cancel()
	{	
		global $option;
		JRequest::checkToken() or jexit( 'Invalid Token' );
		// Checkin the weblink
		$model = $this->getModel('comment');
		$model->checkin();
		$link =  'index.php?option='.$option.'&view=comments';	
		$this->setRedirect($link, $msg, $type);			
	}		
}