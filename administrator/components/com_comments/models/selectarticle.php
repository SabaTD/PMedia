<?PHP
/**
* @version		$Id: controller.php  2008-07-29
*Teimuraz Kevlishvili
*/

// პირდაპირი წვდომის აკრძალვა
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.model');

class commentsModelSelectarticle extends JModel
{
	function __construct()
	{
		parent::__construct();
	}
	
	
	function getCategories()
	{
		$db =& JFactory::getDBO();
		$query = 'SELECT * 
			FROM `#__categories` 
			WHERE `published`="1" 
			ORDER BY `title` ASC ';
		$db->setQuery($query);
		$list = $db->loadObjectList();
		return $list;
	}	
	
	function getArticles()
	{
		global $mainframe, $option;
		$db =& JFactory::getDBO();			
		
		$catfilter 				= $mainframe->getUserStateFromRequest( $option.".catfilter", 'catfilter', 0, 'string' );
		$asearch 				= $mainframe->getUserStateFromRequest( $option.".asearch", 'asearch', '', 'string' );
		$limit		= $mainframe->getUserStateFromRequest( $option.'.list.limit', 'limit', 	$mainframe->getCfg('list_limit'), 'int' );
		$limitstart		= $mainframe->getUserStateFromRequest( $option.'.list.limitstart', 'limitstart', 	0, 'int' );
		$datefrom 				= $mainframe->getUserStateFromRequest( $option.".datefrom", 'datefrom', 0, 'string' );
		$datetill 					= $mainframe->getUserStateFromRequest( $option.".datetill", 'datetill', 0, 'string' );

		$where = array();
		
		if ($catfilter)
		{
			$where[] = ' a.catid='.$catfilter.' ';
		}		
		
		if (isset($asearch) && $asearch != '')
		{
			$searchEscaped = $db->Quote('%'.$db->getEscaped($asearch, true).'%', false);
			$where[] = ' (a.title LIKE  '.$searchEscaped.') ';
		}		
		
		if (isset($datefrom) && $datefrom != '')
		{
			$where[] = ' a.publish_up >= "'.$datefrom.' 00:00:00" ';
		}
		
		if (isset($datetill) && $datetill != '')
		{
			$where[] = ' a.publish_up <= "'.$datetill.' 23:59:59" ';
		}	

		$where = count($where) ? ' AND ('.implode(') AND (', $where).')' : '';
		
		
	 	$query = 'SELECT COUNT(a.id)
			FROM `#__content` as a
			LEFT JOIN  `#__categories` as c ON a.catid=c.id
			LEFT JOIN  `#__sections` as s ON a.sectionid=s.id			 
			WHERE a.state="1" '
			.$where;
		$db->setQuery($query);	
		$total = $db->loadResult();

		jimport('joomla.html.pagination');
		$pagination = new JPagination( $total, $limitstart, $limit );
				
	 	$query = 'SELECT a.id, a.title, a.sectionid, a.catid, a.created, a.publish_up, c.title as cattitle, s.title as sectitle 
			FROM `#__content` as a 
			LEFT JOIN  `#__categories` as c ON a.catid=c.id
			LEFT JOIN  `#__sections` as s ON a.sectionid=s.id	
			WHERE a.state="1" '
			.$where.
		' ORDER BY  a.created DESC';
		$db->setQuery($query, $pagination->limitstart, $pagination->limit);
		$data = $db->loadObjectList();

		$items->data  	  = $data;		
		$items->asearch = $asearch;
		$items->catfilter = $catfilter;
		$items->datefrom = $datefrom;
		$items->datetill = $datetill;
		$items->pagination = $pagination;	
		return $items;
	}
	
	function getSections()
	{
		$db =& JFactory::getDBO();
		$query = 'SELECT * 
			FROM `#__sections` 
			WHERE `published`="1" 
			ORDER BY `title` ASC ';
		$db->setQuery($query);
		$list = $db->loadObjectList();

		return $list;	
	}
}

?>