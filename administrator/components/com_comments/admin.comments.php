<?php
/**
 * Media Controller for JMultimedia Component
 * 
 * @package  			Joomla
 * @subpackage 	JMultimedia Suite
 * @link 				http://3den.org
 * @license		GNU/GPL
 */
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

// Require the base controller
require_once( JPATH_COMPONENT.DS.'controller.php' );

// Require Helpers
//require_once( JPATH_COMPONENT.DS.'helpers'.DS.'comments.php' );

// Create the controller
$controller   = new CommentsController( );
// Perform the Request task
$controller->execute( JRequest::getVar('task') );
$controller->redirect();
