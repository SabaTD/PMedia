<?php
/**
 * Media Table for JMultimedia Component 
 * @package		Joomla
 * @subpackage	JMultimedia Suite
 * @license	GNU/GPL, see LICENSE.php
 * @link http://3den.org
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

/**
* Weblink Table class
*
* @package		Joomla
* @subpackage	Weblinks
* @since 1.0
*/
class TableComments extends JTable
{
	var $id = NULL;
	var $ip = NULL;
	var $article_id = NULL;
        var $parent_id = NULL;
        var $level = NULL;
	
	var $userid = NULL;
	var $author = '';
	var $mail = '';	
	var $comment= '';
	var $added = NULL;
	
	var $params = NULL;
	var $checked_out = 0;
	var $checked_out_time = 0;
	var $published = 0;
	
	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 * @since 1.0
	 */
	function __construct(& $db) {
			parent::__construct('#__comments', 'id', $db);	
	}

	/**
	 * Overloaded check method to ensure data integrity
	 *
	 * @access public
	 * @return boolean True on success
	 * @since 1.0
	 */
	function check(){ 
		// check for valid name 
		if (trim($this->comment) == '')
		{
			$this->setError(JText::_('ROW_WAS_NOT_FOUND'));
			return false;
		}
		$this->comment = nl2br( $this->comment );
		$this->article_id = intval($this->article_id);
		// check for valid name 
		if( !$this->article_id )
		{
			$this->setError(JText::_('SYSTEM ERROR!!!'));
			return false;
		}	// check for valid name 

		/*if( !$this->check_email_address($this->mail) )
		{
			$this->setError(JText::_('Your E-Mail is Incorrect!'));
			return false;
		}*/	// check for valid name 
		return true;
	}

	
	/**
	 * Overloaded blindmethod
	 * 
	 * @todo improvements 
	 * @param array
	 * @return boolean	True on success
	 */
	function bind($data){
		// try to Blind data
		if( !parent::bind($data) ){
			return false;
		}
		
		$params = new JParameter( $this->params );
			
		// Set date
		$datenow =& JFactory::getDate($this->added);
		$this->added = $datenow->toMySQL();
		
		//Fix uid
		if(empty($this->userid) and empty($this->author))
		{
			$user	=& JFactory::getUser();
			$this->userid=$user->get('id');
			$params->set('author', $user->get('name') );
		}
		if( !$this->id )
		{	
			$config	=& JFactory::getConfig();
			$tzoffset = $config->getValue('config.offset');
			$date = & JFactory::getDate('', $tzoffset);
			$this->added = $date->toFormat();
		}
		if( !$this->ip )
		{
			$this->ip = getenv("REMOTE_ADDR"); 
		}
		return true;
	}
	
	function check_email_address($email)
	{
		// First, we check that there's one @ symbol, and that the lengths are right
		if (!ereg("^[^@]{1,64}@[^@]{1,255}$", $email))
		{
			// Email invalid because wrong number of characters in one section, or wrong number of @ symbols.
			return false;
		}
		// Split it into sections to make life easier
		$email_array = explode("@", $email);
		$local_array = explode(".", $email_array[0]);
		for ($i = 0; $i < sizeof($local_array); $i++)
		{
			if (!ereg("^(([A-Za-z0-9!#$%&'*+/=?^_`{|}~-][A-Za-z0-9!#$%&'*+/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$", $local_array[$i]))
			{
				return false;
			}
		}
		if (!ereg("^\[?[0-9\.]+\]?$", $email_array[1]))
		{ // Check if domain is IP. If not, it should be valid domain name
			$domain_array = explode(".", $email_array[1]);
			if (sizeof($domain_array) < 2)
			{
				return false; // Not enough parts to domain
			}
			for ($i = 0; $i < sizeof($domain_array); $i++)
			{
				if (!ereg("^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|([A-Za-z0-9]+))$", $domain_array[$i]))
				{
					return false;
				}
			}
		}
		return true;
	}
}
