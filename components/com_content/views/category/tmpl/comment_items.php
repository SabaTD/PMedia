<?php // no direct access
defined('_JEXEC') or die('Restricted access'); ?>
<div class="comment_category_blockitem">
<?php 


foreach ($this->items as $item) : ?>
	<div class="comment_item">
		<table border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td valign="top">
				<?php
					preg_match("#titleimage=(.*?)\n#", $item->attribs , $Img);
					if(!empty($Img[1]))
					{
						echo '<img src="'.$Img[1].'" />';
					}
				?>
			</td>
			<td valign="top" width="100%">
			<div class="comment_item_content">
				<span class="article_time">
					<?php 						
						echo JHTML::_('date', $item->created, JText::_('DATE_FORMAT_LC5')); 
					?>
				</span>
				<div class="main_title"><a href="<?php echo  JRoute::_(ContentHelperRoute::getArticleRoute($item->slug, $item->catslug,$item->sectionid));?>">
					<?php echo $item->title;?>
				</a>
				<?php if ($this->access->canEdit and !empty($item->link)) : ?>
                                    <a href="<?php echo $item->link; ?>&task=edit"><img src="images/M_images/edit.png" alt="რედაქტირება" border="0"/></a>
				<?php endif; ?>
				</div>
			<?php echo $item->introtext; ?>
			</div>
			</td>
		  </tr>
		</table>
	</div>
<?php endforeach; ?>
<?php if ($this->params->get('show_pagination')) : ?>
	<div class="sectiontablefooter<?php echo $this->params->get( 'pageclass_sfx' ); ?>">
		<?php echo $this->pagination->getPagesLinks(); ?>
	</div>
<?php endif; ?>
</div>