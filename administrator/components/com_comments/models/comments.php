<?php
/**
 * Comments Model for JMultimedia Component
 * 
 * @package    Joomla.Tutorials
 * @subpackage Components
 * @link http://dev.joomla.org/component/option,com_jd-wiki/Itemid,31/id,tutorials:modules/
 * @license    GNU/GPL
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

jimport( 'joomla.application.component.model' );

/**
 * Reviews Model 
 *
 * @package    Joomla.Tutorials
 * @subpackage Components
 */

class CommentsModelComments extends JModel
{
 	/**
     * Media data array
     *
     * @var array
     */
    var $_data = null;
	var $_total = null;
	
	/** @var object Pagination object */
	var $_pagination = null;
	
	/**
	 * Constructor
	 *
	 * @since 1.5
	 */
	function __construct()
	{
		parent::__construct();
		global $mainframe, $option;

		// Get the pagination request variables
		$limit		= $mainframe->getUserStateFromRequest( $option.'.list.limit', 'limit', 	$mainframe->getCfg('list_limit'), 'int' );
		$limitstart		= $mainframe->getUserStateFromRequest( $option.'.list.limitstart', 'limitstart', 	0, 'int' );


		// In case limit has been changed, adjust limitstart accordingly
		$limitstart = ($limit != 0 ? (floor($limitstart / $limit) * $limit) : 0);

		$this->setState('limit', $limit);
		$this->setState('limitstart', $limitstart);	
	}
	
	
	/**
	 * Method to get weblinks item data
	 *
	 * @access public
	 * @return array
	 */
	function &getData()
	{
		// Lets load the content if it doesn't already exist
		if (empty($this->_data))
		{
			$query = $this->_buildQuery();
			$this->_data = $this->_getList($query, $this->getState('limitstart'), $this->getState('limit'));
		}
		return $this->_data;
	}

	/**TODO build a better query
	 * Method to get the total number of weblink items
	 * @access public
	 * @return integer
	 */
	function &getTotal()
	{
		$db = $this->_db;
		// Lets load the content if it doesn't already exist
		if (empty($this->_total))
		{
		
			$query = 'SELECT COUNT(*) FROM #__comments AS a '
				. $this->_buildWhere();
			$db->setQuery($query);
			$this->_total = $db->loadResult();
		}
		return $this->_total;
	}

	/**
	 * Method to get a pagination object for the weblinks
	 *
	 * @access public
	 * @return integer
	 */
	function getPagination()
	{
		// Lets load the content if it doesn't already exist
		if (empty($this->_pagination))
		{
			jimport('joomla.html.pagination');
			$this->_pagination = new JPagination( 
				$this->getTotal(), 
				$this->getState('limitstart'), 
				$this->getState('limit') );
		}
		return $this->_pagination;
	}

	/**
	 * Returns the query
	 * @return string The query to be used to retrieve the rows from the database
	 */	
	function _buildQuery()
	{
		// Get the WHERE and ORDER BY clauses for the query
		$where		= $this->_buildWhere();
		$orderby	= $this->_buildOrderBy();
		$query = ' SELECT a.id AS id, a.userid AS userid, a.author AS author, a.article_id AS article_id, '
			. ' a.ip AS ip, '
			. ' a.mail AS mail, a.comment AS comment, '
			. ' a.added AS added, '
			. ' a.published AS published,' 
			. ' a.checked_out AS checked_out, a.checked_out_time AS checked_out_time, '
			. ' cc.title AS container '
			. ' FROM #__comments AS a '
			. ' LEFT JOIN #__content AS cc ON cc.id = a.article_id '
			. $where
			. $orderby;
		return $query;
	}

	function _buildOrderBy()
	{
		global $mainframe, $option;

		$filter_order			= $mainframe->getUserStateFromRequest( $option.'filter_order', 'filter_order', '', 'cmd' );
		$filter_order_Dir	= $mainframe->getUserStateFromRequest( $option.'filter_order_Dir', 'filter_order_Dir',	'desc',	'word' );

		switch($filter_order){
			case 'a.published':
			case 'a.added':
			case 'container':
			case 'a.userid':
			case 'author':
			case 'a.comment':
			case 'a.hits':
			case 'a.id':
				$orderby = ' ORDER BY '.$filter_order.' '.$filter_order_Dir;				
				break;
			default:
				$orderby = ' ORDER BY   a.added '.$filter_order_Dir;	
				break;			
		}
		return $orderby;
	}

	function _buildWhere()
	{
		global $mainframe, $option;
		$db =& JFactory::getDBO();
		$filter_state = $mainframe->getUserStateFromRequest( $option.'filter_state', 'filter_state', '', 'word' ); 
		$search = $mainframe->getUserStateFromRequest( $option.'search', 'search', '',	'string' );
		$search = JString::strtolower( $search );
		$article_id = JRequest::getint('article_id');
		$filter_userid = JRequest::getint('uid', 0);

		$where = array();		

		if ($filter_userid) {
			$where[] = 'a.userid='.$filter_userid;
		}		
		if ($article_id) {
			$where[] = 'a.article_id='.$article_id;
		}
		if ($search) {
			$where[] = 'LOWER(a.comment) LIKE '.$db->Quote( '%'.$db->getEscaped( $search, true ).'%', false );
		}
		if ($filter_state) {
			if ( $filter_state == 'P' ) {
				$where[] = 'a.published = 1';
			} else if ($filter_state == 'U' ) {
				$where[] = 'a.published = 0';
			}
		}
		$where 		= ( count( $where ) ? ' WHERE '. implode( ' AND ', $where ) : '' );
		return $where;
	}
}
