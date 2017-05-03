<?php
/**
* @version		$Id: article.php 10381 2008-06-01 03:35:53Z pasamio $
*/

defined('_JEXEC') or die( 'Restricted access' );

class JElementArticle extends JElement
{
	/**
	 * Element name
	 *
	 * @access	protected
	 * @var		string
	 */
	var	$_name = 'Article';

	function fetchElement($name, $value, &$node, $control_name, $order)
	{
		global $mainframe;
		$db			=& JFactory::getDBO();
		$doc 		=& JFactory::getDocument();
		$template 	= $mainframe->getTemplate();
		$fieldName	= $control_name.'['.$name.']';
		$article =& JTable::getInstance('content');
		if ($value) {
			$article->load($value);
		} else {
			$article->title = '';
		}
		$js = "
			function jSelectArticle(id, title, object) {
			document.getElementById(object + '_id').value = id;
			document.getElementById(object + '_name').value = title;
			document.getElementById('sbox-window').close();
		}		
		function jclearArticle(id, title, object) 
		{
			document.getElementById(object + '_id').value = '0';
			document.getElementById(object + '_name').value = '';
		}
		
		function moveUpDown(num, dir)
		{
			if(dir)
			{	
				tonum = num+1;
				var tonameid = 'a'+tonum+'_name';
				var fromnameid = 'a'+num+'_name';
				var fromname = document.getElementById(fromnameid);
				var toname = document.getElementById(tonameid);
				var ftname = toname.value;
				toname.value = fromname.value;
				fromname.value = ftname;
				
				var toidid = 'a'+tonum+'_id';
				var fromidid = 'a'+num+'_id';
				var fromid = document.getElementById(fromidid);
				var toid = document.getElementById(toidid);
				var ftid = toid.value;
				toid.value = fromid.value;
				fromid.value = ftid;
			}
			else
			{
				tonum = num-1;
				var tonameid = 'a'+tonum+'_name';
				var fromnameid = 'a'+num+'_name';
				var fromname = document.getElementById(fromnameid);
				var toname = document.getElementById(tonameid);
				var ftname = toname.value;
				toname.value = fromname.value;
				fromname.value = ftname;
				
				var toidid = 'a'+tonum+'_id';
				var fromidid = 'a'+num+'_id';
				var fromid = document.getElementById(fromidid);
				var toid = document.getElementById(toidid);
				var ftid = toid.value;
				toid.value = fromid.value;
				fromid.value = ftid;
			}
		}
		
		";
		$doc->addScriptDeclaration($js);
		$link = 'index.php?option=com_comments&amp;view=selectarticle&amp;tmpl=component&amp;object='.$name;
		JHTML::_('behavior.modal', 'a.modal');
		$html = "\n".'<table border="0" cellspacing="0" cellpadding="0"> <tr><td valign="middle"><input style="background: #ffffff;" type="text" id="'.$name.'_name" value="'.htmlspecialchars($article->title, ENT_QUOTES, 'UTF-8').'" disabled="disabled" size="45" /></td><td>';
		$html .= '<div class="button2-left"><div class="blank"><a class="modal" title="'.JText::_('Select an Article').'" id="modal"  href="'.$link.'" rel="{handler: \'iframe\', size: {x: 650, y: 375}}">'.JText::_('Select').'</a></div></div>
		<div class="button2-left">
		<div class="blank">
		<a class="modal2" title="'.JText::_('Clear').'" id="modal2"  href="#" 
		onclick="jclearArticle(\'\', \'\', \''.$name.'\'); return false; ">'
		.JText::_('Clear').'</a></div></div>'."\n";

		$html .= "\n".'</td><td><input type="hidden" id="'.$name.'_id" name="'.$fieldName.'" value="'.(int)$value.'" /></td> </tr></table>';
		
		return $html;
	}
}
