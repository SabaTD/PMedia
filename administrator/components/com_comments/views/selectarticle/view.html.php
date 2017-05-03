<?PHP
/**
* @version		$Id: view.html.php  2008-07-29
*Teimuraz Kevlishvili
*/

// პირდაპირი წვდომის აკრძალვა
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.view');
 



class commentsViewSelectarticle extends JView
{
	function display($tmpl=NULL)   
	{ 

		$object = Jrequest::getVar('object');

		
		$model = $this->getModel();

		 
		$categories = $model->getCategories();
		$data = $model->getArticles();


		$types = array();
		$types[] = JHTML::_('select.option',  '0', '- '.JText::_('Select Category').' -' );
		foreach($categories as $obj)
		{
			$types[] = JHTML::_('select.option', $obj->id, $obj->title);
		}
		$lists['catfilter'] = JHTML::_('select.genericlist', $types, 'catfilter', 'class="inputbox" size="1" onchange="document.adminForm.submit( );"', 'value', 'text', $data->catfilter );




		$this->assignRef('lists', $lists);
		$this->assignRef('datefrom', $data->datefrom);
		$this->assignRef('datetill', $data->datetill);
		$this->assignRef('articles', $data->data);
		$this->assignRef('asearch', $data->asearch);
		$this->assignRef('catfilter', $data->catfilter );
		$this->assignRef('pagination', $data->pagination);
		$this->assignRef('object', $object );
		parent::display($tmpl);
	}	
}