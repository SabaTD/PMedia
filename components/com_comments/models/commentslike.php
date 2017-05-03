<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.model' );

class commentsModelCommentslike extends JModel
{
	function get_vote( $id )
	{
		$db = JFactory::getDBO();
//comments_valid
		$query = '#com_comments commentslike - model 1   Query' . "\n"
						. ' SELECT `votes_up`, `votes_down` FROM `#__comments` WHERE `id` = ' . $id . ' LIMIT 1';
		$db->setQuery( $query );
		$data = $db->loadObject();
		return $data;

	}

	function update_answer_vote( $id, $hash )
	{
		$db = JFactory::getDBO();
		$hash = md5( $_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT'] );
		$query = '#com_comments commentslike - model 2   Query' . "\n"
						. ' UPDATE `#__comments` '
						. ' SET `votes_up` = `votes_up` + 1 '
						. ' WHERE `id` = "' . $id . '"';

		$db->setQuery( $query );
		$db->query();

		$query_2 = '#com_comments commentslike - model 3   Query' . "\n"
						. ' INSERT `#__comments_valid` '
						. ' (`id_comment` , `hash` ) '
						. ' VALUES (' . "'" . $id . "'" . ',' . "'" . $hash . "'" . ' )';

		$db->setQuery( $query_2 );
		$db->query();

	}
        
        function update_answer_down_vote( $id, $hash )
	{
		$db = JFactory::getDBO();
		$hash = md5( $_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT'] );
		$query = '#com_comments commentslike - model 2   Query' . "\n"
						. ' UPDATE `#__comments` '
						. ' SET `votes_down` = `votes_down` + 1 '
						. ' WHERE `id` = "' . $id . '"';

		$db->setQuery( $query );
		$db->query();

		$query_2 = '#com_comments commentslike - model 3   Query' . "\n"
						. ' INSERT `#__comments_valid` '
						. ' (`id_comment` , `hash` ) '
						. ' VALUES (' . "'" . $id . "'" . ',' . "'" . $hash . "'" . ' )';

		$db->setQuery( $query_2 );
		$db->query();

	}

	function validation( $id, $hash )
	{
		$hash = md5( $_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT'] );
		$db = JFactory::getDBO();
		$query = '#com_comments commentslike - model 4   Query' . "\n"
						. ' SELECT  * '
						. ' FROM  `#__comments_valid`  '
						. ' WHERE `id_comment` = "' . $id . '" AND `hash` =' . "'" . $hash . "'"
		;

		$db->setQuery( $query );
		$result = $db->loadObject();
		return $result;

	}

}
