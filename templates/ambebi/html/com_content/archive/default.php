<?php // no direct access
defined('_JEXEC') or die('Restricted access'); ?>
<?php  /*?><form id="jForm" action="<?php JRoute::_('index.php')?>" method="post">
*/
$month_ = array('','JANUARY', 'FEBRUARY','MARCH','APRIL','MAY','JUNE','JULY','AUGUST','SEPTEMBER','OCTOBER','NOVEMBER','DECEMBER');
$date = '';
$year =  intval(JRequest::getVar('year'));
$month = intval(JRequest::getVar('month'));
$day =  intval(JRequest::getVar('day'));
if(!empty($day) and $day>0 and $day<32)
{
	$date .=$day.' ' ;
}
if(!empty($month) and $month>0 and $month<13)
{
	$date .=JText::_($month_ [$month]).', ';
}
if(!empty($year))
{
	$date .=$year.JText::_("Y");
}
?>
<div id="archive_page">
<?php if ($this->params->get('show_page_title', 1)) : ?>
	<div class="componentheading<?php echo $this->params->get('pageclass_sfx')?>"><?php echo $this->escape($this->params->get('page_title'));  if(!empty($date)){ echo ' - '; print($date);}?></div>
	<div class="archive_content">
<?php endif; /*?>
	<p>
		<?php if ($this->params->get('filter')) : ?>
		<?php echo JText::_('Filter').'&nbsp;'; ?>
		<input type="text" name="filter" value="<?php echo $this->escape($this->filter); ?>" class="inputbox" onchange="document.jForm.submit();" />
		<?php endif; ?>
		<?php echo $this->form->monthField; ?>
		<?php echo $this->form->yearField; ?>
		<?php echo $this->form->limitField; ?>
		<button type="submit" class="button"><?php echo JText::_('Filter'); ?></button>
	</p>

<?php*/ echo $this->loadTemplate('items'); /*?>

	<input type="hidden" name="view" value="archive" />
	<input type="hidden" name="option" value="com_content" />
</form>
*/?>
</div></div>