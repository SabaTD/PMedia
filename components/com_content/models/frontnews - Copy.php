<?PHP
/**
 * @version		$Id: controller.php  2008-07-29
 * Teimuraz Kevlishvili
 */
// პირდაპირი წვდომის აკრძალვა
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.model' );

class contentModelfrontnews extends JModel
{
	function __construct()
	{
		parent::__construct();

	}

	function getList()
	{
		$db = & JFactory::getDBO();
		$query = '#FrontNews 
		select * from `#__frontnews` where `status`=1 ORDER BY `ordering` ASC';
		$item = WSCache::getDBCache( $query, 'loadObjectList', 'FrontNews_list', 10 );
//		$db->setQuery($query);
//		$item=$db->loadObjectList();
		return $item;

	}

	function getData( $sec_cat_id, $main_news, $comment, $conference, $inneradvert, $big_advert, $main_advert, $right_advert, $gallery, $galleryitem )
	{
		$sec_cat = explode( '.', $sec_cat_id );
		$data = $this->getArticle( $sec_cat, $main_news );
		$main_advert = explode( '.', $main_advert );
		if ( !empty( $main_advert[0] ) )
		{
			$data['main_advert'] = $this->getBanner( $main_advert );
		}
		else
		{
			$data['main_advert'] = '';
		}

		$big_advert = explode( '.', $big_advert );
		if ( !empty( $big_advert[0] ) )
		{
			$data['big_advert'] = $this->getBanner( $big_advert );
		}
		else
		{
			$data['big_advert'] = '';
		}

		$right_advert = explode( '.', $right_advert );
		if ( !empty( $right_advert[0] ) )
		{
			$data['right_advert'] = $this->getBanner( $right_advert );
		}
		else
		{
			$data['right_advert'] = '';
		}

		$inneradvert = explode( '.', $inneradvert );
		if ( !empty( $inneradvert[0] ) )
		{
			$data['inneradvert'] = $this->getBanner( $inneradvert );
			$data['inneradvertpos'] = $inneradvert[5];
		}
		else
		{
			$data['inneradvert'] = '';
			$data['inneradvertpos'] = '';
		}

		if ( !empty( $conference ) )
		{
			$data['conference'] = $this->getConference( $sec_cat[0], $sec_cat[1], $conference );
		}
		else
		{
			$data['conference'] = '';
		}

		if ( !empty( $comment ) )
		{
			$data['comment'] = $this->getComment( $sec_cat[0], $sec_cat[1], $comment );
		}
		else
		{
			$data['comment'] = '';
		}

		if ( !empty( $gallery ) )
		{
			$data['gallery'] = $this->getGallery( $galleryitem );
		}
		else
		{
			$data['gallery'] = '';
		}
		return $data;

	}

	function getArticle( $sec_cat, $main_news )
	{
		global $mainframe;
		$db = & JFactory::getDBO();
		$count = 5;
		$catid = trim( $sec_cat[1] );
		$secid = trim( $sec_cat[0] );
		$now = $mainframe->get( 'requestTime' );
		$nullDate = $this->_db->getNullDate();
		if ( !empty( $sec_cat[1] ) )
		{
			$sql = '#FrontNews  Articles
		SELECT * FROM `#__categories` where id = ' . $sec_cat[1];
			$query = '#FrontNews 
		(SELECT `a`.`id` , `a`.`title` , `a`.`alias` , `a`.`introtext` , `a`.`fulltext` , `a`.`publish_up` , `a`.`sectionid` , `c`.`id` as `catslug`, `s`.`title` as `sec_title` , `c`.`title` as `cat_title`, `a`.`attribs` '
							. ' FROM `#__content` AS `a`'
							. ' INNER JOIN `#__categories` AS `c` ON `c`.`id` = `a`.`catid`'
							. ' INNER JOIN `#__sections` AS `s` ON `c`.`section` = `s`.`id`'
							. ' WHERE `a`.`id` = "'
							. $main_news
							. '"	'
							. ' AND ( `a`.`publish_up` = ' . $this->_db->Quote( $nullDate )
							. ' OR `a`.`publish_up` <= ' . $this->_db->Quote( $now ) . ' )'
							. ' AND ( `a`.`publish_down` = ' . $this->_db->Quote( $nullDate )
							. ' OR `a`.`publish_down` >= ' . $this->_db->Quote( $now ) . ' )'
							. ')'
							. ' UNION ALL '
							. ' (SELECT `a`.`id` , `a`.`title` , `a`.`alias` , `a`.`introtext` , `a`.`fulltext` , `a`.`publish_up` , `a`.`sectionid` , `c`.`id` as `catslug`, `s`.`title` as `sec_title` , `c`.`title` as `cat_title`, `a`.`attribs`'
							. ' FROM `#__content` AS `a`'
							. ' INNER JOIN `#__categories` AS `c` ON `c`.`id` = `a`.`catid`'
							. 'RIGHT JOIN `#__newsconfig` AS `nc` ON (`nc`.`exclusive` <> `a`.`catid` or `nc`.`conference` <> `a`.`catid`)'
							. ' INNER JOIN `#__sections` AS `s` ON `c`.`section` = `s`.`id`'
							. ' WHERE `a`.`state` ="1" and `nc`.`exclusive` <>`a`.`catid`and `nc`.`conference` <> `a`.`catid` '
							//	.' AND (`a`.`catid` = "' 
							. ' AND `a`.`catid` = "'
							. $sec_cat[1]
							//	.'" OR `a`.`attribs` LIKE "%|'.$sec_cat[1].'|%")'
							. '"  AND `a`.`id` <> "'
							. $main_news
							. '"	'
							. ' AND ( `a`.`publish_up` = ' . $this->_db->Quote( $nullDate )
							. ' OR `a`.`publish_up` <= ' . $this->_db->Quote( $now ) . ' )'
							. ' AND ( `a`.`publish_down` = ' . $this->_db->Quote( $nullDate )
							. ' OR `a`.`publish_down` >= ' . $this->_db->Quote( $now ) . ' )'
							. 'ORDER BY `a`.`publish_up` DESC	LIMIT 0 , 4) LIMIT 0 , 5';
			$table = '#__categories';
			$id = $sec_cat[1];
		}
		else
		{
			return false;
		}
//		$db->setQuery( $sql );
//		$r = $db->loadObjectList();
		$r = WSCache::getDBCache( $sql, 'loadObjectList', '_FrontNews_list_sql_' . $sec_cat[1], 5 );
		$catslug = $r[0]->id . ':' . $r[0]->alias;
//		$db->setQuery( $query );
//		$rows = $db->loadObjectList();
		$rows = WSCache::getDBCache( $query, 'loadObjectList', '_FrontNews_list_cat_' . $sec_cat[1], 5 );

		$i = 0;
		$lists = array( );
		if ( !is_array( $rows ) )
		{
			return false;
		}

		$sql = 'select  `title` from `' . $table . '` where `id` = "' . $id . '"';
		$db->setQuery( $sql );
		$Title = $db->loadResult();

		jimport( 'wslib.media.multipic' );
		$multipic = new wsMultiPic();
		$multipic->setCacheDir( 'pictures' );

		foreach ( $rows as $row )
		{
			$artParams = new JParameter( $row->attribs );
			$isFirst = $i == 0 and $row->id == $main_news;

			$image1 = $artParams->get( 'image' );
			$image2 = $artParams->get( 'image2' );
			$image = $image2 ? $image2 : $image1;

			if ( $isFirst )
			{
				$image = $image1;
			}

			$add = false;

			if ( $image )
			{
				$TImg = $isFirst ? $multipic->getImage( 'image6', $image ) : $multipic->getImage( 'image1', $image );
				$add = true;
			}
			else
			{
				$TImg = '';
			}

			if ( $i == 0 and $row->id != $main_news )
			{
				$i = 1;
			}
			else if ( $i == 0 and $row->id == $main_news )
			{
				$lists[$i]->id = $row->id;
				$lists[$i]->title = htmlspecialchars( $row->title, ENT_QUOTES );
				$lists[$i]->link = JRoute::_( ContentHelperRoute::getArticleRoute( $row->id . ':' . $row->alias, $catslug, $row->sectionid ) );
				$lists[$i]->text = $row->introtext;
				$lists[$i]->Time = JHTML::_( 'date', $row->publish_up, JText::_( 'DATE_FORMAT_LC5' ) );
				$lists[$i]->add = $add;
				$lists[$i]->titleimg = $TImg;
				$i++;
				continue;
			}

			$lists[$i]->id = $row->id;
			$lists[$i]->title = htmlspecialchars( $row->title, ENT_QUOTES );
			$lists[$i]->link = JRoute::_( ContentHelperRoute::getArticleRoute( $row->id . ':' . $row->alias, $catslug, $row->sectionid ) );
			$lists[$i]->text = $row->introtext;
			$lists[$i]->Time = JHTML::_( 'date', $row->publish_up, JText::_( 'DATE_FORMAT_LC5' ) );
			$lists[$i]->titleimg = $TImg;
			$i++;
		}

		$lists['blocktitle'] = $r[0]->title;
		$lists['titleurl'] = ContentHelperRoute::getCategoryRoute( $r[0]->id, $r[0]->section );

		return $lists;

	}

	function ChangeIMG( $intro, $full )
	{
		return $intro;
		preg_match( '#(?:<img )([^>]*?)(?:/?>)#is', $intro, $intro_img );
		preg_match( '#(?:<img )([^>]*?)(?:/?>)#is', $full, $full_img );
		if ( empty( $full_img[0] ) )
		{
			if ( empty( $intro_img[0] ) )
			{
				$intro = '{title} ' . $intro;
			}
			else
			{
				$img = str_replace( '/>', '/> {title} ', $intro_img[0] );
				$intro = str_replace( $intro_img[0], $img, $intro );
			}
		}
		else
		{
			if ( empty( $intro_img[0] ) )
			{
				$img = str_replace( '/>', '/> {title} ', $full_img[0] );
				$intro = $img . $intro;
			}
			else
			{
				$img = str_replace( '/>', '/> {title} ', $full_img[0] );
				$intro = str_replace( $intro_img[0], $img, $intro );
			}
		}
		return $intro;

	}

	function getBanner( $params )
	{
		require_once(JPATH_SITE . DS . 'modules' . DS . 'mod_banners' . DS . 'helper.php');
		$paramString = "target=" . $params[1] . "\n"
						. "cid=" . $params[2] . "\n"
						. "catid=" . $params[3] . "\n";

		if ( isset( $params[4] ) and $params[4] > 0 )
		{
			$paramString .="count=" . $params[4];
		}
		else
		{
			$paramString .="count=1";
		}
		$banerParams = new JParameter( $paramString );
		$list = modBannersHelper::getList( $banerParams );
		$Banners = '';
		foreach ( $list as $row )
		{
			$Banners .='<div class="banner_item_f">';
			$Banners .= modBannersHelper::renderBanner( $banerParams, $row );
			$Banners .='</div>';
		}
		$Banners = str_replace( '&amp;', '&', $Banners );
		$Banners = str_replace( '&', '&amp;', $Banners );
		return $Banners;

	}

	function getComment( $sec, $cat, $num )
	{
		global $mainframe;
		$db = & JFactory::getDBO();
		$now = $mainframe->get( 'requestTime' );
		$nullDate = $this->_db->getNullDate();

		if ( !empty( $cat ) )
		{
			$query = '#FrontNews  Exclusive
		SELECT `a`.`id` , `a`.`title` , `a`.`alias` , `a`.`introtext` , `a`.`fulltext` , `a`.`publish_up` , `a`.`sectionid` , `c`.`id` as `catid` , `c`.`alias` as `slug`,  `c`.`title` as `cat_title`, `a`.`attribs`,`nc`.`exclusive_title`'
							. ' FROM `#__content` AS `a`'
							. ' right JOIN `#__newsconfig` AS `nc` on `nc`.`exclusive`= `a`.`catid` '
							. ' INNER JOIN `#__categories` AS `c` ON `c`.`id` = `a`.`catid`'
							. ' WHERE `a`.`state` =1'
							. '  AND `a`.`attribs` LIKE "%|'
							. $cat
							. '|%" 	'
							. ' AND ( `a`.`publish_up` = ' . $this->_db->Quote( $nullDate )
							. ' OR `a`.`publish_up` <= ' . $this->_db->Quote( $now ) . ' )'
							. ' AND ( `a`.`publish_down` = ' . $this->_db->Quote( $nullDate )
							. ' OR `a`.`publish_down` >= ' . $this->_db->Quote( $now ) . ' )'
							. 'ORDER BY `a`.`publish_up` DESC	LIMIT 0 , ' . $num;
			$db->setQuery( $query );
			$rows = $db->loadObjectList();
			$lists = array( );
			$i = 0;
			jimport( 'wslib.media.multipic' );
			$multipic = new wsMultiPic();
			$multipic->setCacheDir( 'pictures' );
			foreach ( $rows as $row )
			{
				$artParams = new JParameter( $row->attribs );

				$image1 = $artParams->get( 'image' );
				$image2 = $artParams->get( 'image2' );
				$image = $image2 ? $image2 : $image1;

				if ( $image )
				{
					$TImg = $multipic->getImage( 'image7', $image );
				}
				else
				{
					$TImg = '';
				}

				$lists[$i]->id = $row->id;
				$lists[$i]->title = $row->title;
				$lists[$i]->exclusive_title = $row->exclusive_title;
				$lists[$i]->link = JRoute::_( ContentHelperRoute::getArticleRoute( $row->id . ':' . $row->alias, $row->catid . ':' . $row->slug, $row->sectionid ) );
				$lists[$i]->catlink = JRoute::_( ContentHelperRoute::getCategoryRoute( $row->catid . ':' . $row->slug, $row->sectionid ) );
				$lists[$i]->text = $row->introtext;
				$lists[$i]->Time = JHTML::_( 'date', $row->publish_up, JText::_( 'DATE_FORMAT_LC5' ) );
				$lists[$i]->TImg = $TImg;
				$i++;
			}
		}
		else
		{
			return false;
		}
		return $lists;

	}

	function getConference( $sec, $cat, $num )
	{
		global $mainframe;
		$db = & JFactory::getDBO();
		$now = $mainframe->get( 'requestTime' );
		$nullDate = $this->_db->getNullDate();

		if ( !empty( $cat ) )
		{
			$query = '#FrontNews Conference
		 SELECT `a`.`id` , `a`.`title` , `a`.`alias` , `a`.`introtext` , `a`.`fulltext` , `a`.`publish_up` , `a`.`sectionid` , `c`.`id` as `catid` , `c`.`alias` as `slug`,  `c`.`title` as `cat_title`, `a`.`attribs`,`nc`.`conference_title`'
							. ' FROM `#__content` AS `a`'
							. ' right JOIN `#__newsconfig` AS `nc` on `nc`.`conference`= `a`.`catid` '
							. ' INNER JOIN `#__categories` AS `c` ON `c`.`id` = `a`.`catid`'
							. ' WHERE `a`.`state` =1'
							. '  AND `a`.`attribs` LIKE "%|'
							. $cat
							. '|%" 	'
							. ' AND ( `a`.`publish_up` = ' . $this->_db->Quote( $nullDate )
							. ' OR `a`.`publish_up` <= ' . $this->_db->Quote( $now ) . ' )'
							. ' AND ( `a`.`publish_down` = ' . $this->_db->Quote( $nullDate )
							. ' OR `a`.`publish_down` >= ' . $this->_db->Quote( $now ) . ' )'
							. 'ORDER BY `a`.`publish_up` DESC	LIMIT 0 , ' . $num;
			$db->setQuery( $query );
			$rows = $db->loadObjectList();
			$lists = array( );
			$i = 0;
			jimport( 'wslib.media.multipic' );
			$multipic = new wsMultiPic();
			$multipic->setCacheDir( 'pictures' );
			foreach ( $rows as $row )
			{
				$artParams = new JParameter( $row->attribs );

				$image1 = $artParams->get( 'image' );
				$image2 = $artParams->get( 'image2' );
				$image = $image2 ? $image2 : $image1;
				if ( $image )
				{
					$TImg = $multipic->getImage( 'image9', $image );
				}
				else
				{
					$TImg = '';
				}


				$lists[$i]->id = $row->id;
				$lists[$i]->title = $row->title;
				$lists[$i]->conference_title = $row->conference_title;
				$lists[$i]->link = JRoute::_( ContentHelperRoute::getArticleRoute( $row->id . ':' . $row->alias, $row->catid . ':' . $row->slug, $row->sectionid ) );
				$lists[$i]->catlink = JRoute::_( ContentHelperRoute::getCategoryRoute( $row->catid . ':' . $row->slug, $row->sectionid ) );
				$lists[$i]->text = $row->introtext;
				$lists[$i]->Time = JHTML::_( 'date', $row->publish_up, JText::_( 'DATE_FORMAT_LC5' ) );
				$lists[$i]->TImg = $TImg;
				$i++;
			}
		}
		else
		{
			return false;
		}
		return $lists;

	}

	function getGallery( $id )
	{
		if ( $id )
		{
			global $mainframe;
			$db = & JFactory::getDBO();
			$query = '#FrontNews Gallery
		SELECT `g`.`id`, `g`.`parent` ,  `g`.`name` ,`t`.`name` as `tname`, `nc`.`galleryname` '
							. ' FROM `#__rsgallery2_galleries` AS `g`'
							. ' LEFT JOIN `#__rsgallery2_files` AS `t` on  1 = 1 '
							. ' LEFT JOIN `#__newsconfig` AS `nc` ON 1 =1'
							. ' WHERE  CASE WHEN `g`.`thumb_id` = 0 THEN 
					`g`.`id` = `t`.`gallery_id` 
				  ELSE
				   `t`.`id` = `g`.`thumb_id`
				  END
				and `g`.`published` =1'
							. ' and (`g`.`parent` ='
							. $id
							. ') ORDER BY `g`.`date` DESC
				limit 0, 1';
			$db->setQuery( $query );
			$rows = $db->loadObjectList();
			if ( empty( $rows ) )
			{
				return false;
			}

			$lists = array( );
			$itemid = $this->_findItem();
			$lists = new stdClass();
			foreach ( $rows as $row )
			{
				if ( $row->tname )
				{
					$lists->id = $row->id;
					$lists->name = $row->name;
					$lists->link = JRoute::_( 'index.php?option=com_rsgallery2&gid=' . $row->id . '&Itemid=' . $itemid );
					$lists->parent = JRoute::_( 'index.php?option=com_rsgallery2&gid=' . $row->parent . '&Itemid=' . $itemid );
					$lists->thrumb = 'images/rsgallery/thumb/' . $row->tname . '.jpg';
				}
			}
			$lists->galleryname = $rows[0]->galleryname;
			$lists->galleryurl = JRoute::_( 'index.php?option=com_rsgallery2&Itemid=' . $itemid );
			return $lists;
		}
		else
		{
			return false;
		}

	}

	function _findItem()
	{
		$component = & JComponentHelper::getComponent( 'com_rsgallery2' );
		$menus = &JApplication::getMenu( 'site', array( ) );
		$items = $menus->getItems( 'componentid', $component->id );
		$match = null;
		if ( $items )
		{
			foreach ( $items as $item )
			{
				if ( !empty( $item->id ) )
				{
					$match = $item->id;
					break;
				}
			}
		}
		return $match;

	}

}

?>