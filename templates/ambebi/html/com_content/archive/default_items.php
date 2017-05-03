<?php // no direct access
defined('_JEXEC') or die('Restricted access');
if(empty($this->items))
{
	$msg=JText::_('Archive Error');
	$link = JRoute::_('index.php');
	ContentController::setRedirect($link, $msg);
	ContentController::redirect();
}
function limitword($text, $num=50)
{
	$words = explode(' ', $text);
	if(count($words)>$num)
	{
		$lText = '';
		for($a=0; $a<=$num; $a++)
		{
			$lText .= ' '.$words[$a];
		}
		$lText .='...';
	}
	else
	{
		$lText = $text;
	}
	return $lText;
}

 ?>
<div id="archive-list">
<?php foreach ($this->items as $item) : ?>
	<div class="archive_row<?php echo ($item->odd +1 ); ?>">
		<div class="archive_news_item">
			<div class="article-meta">
				<?php if ($this->params->get('show_create_date')) : ?>
					<span class="article_time_cat">
						<?php echo JHTML::_('date', $item->publish_up, JText::_('DATE_FORMAT_LC5')) ?>
					</span>
				<?php endif; ?>
			</div>
			<a href="<?php echo JRoute::_(ContentHelperRoute::getArticleRoute($item->slug,$item->catslug, $item->sectionid)); ?>">
				<?php echo $this->escape($item->title); ?>
			</a>

		</div>
		<div class="article-content">
			<?php echo limitword(strip_tags($item->introtext), 20);  ?>
		</div>
	</div>
<?php endforeach; ?>
</div>
<div id="navigation">
	<span><?php echo $this->pagination->getPagesLinks(); ?></span>
</div>