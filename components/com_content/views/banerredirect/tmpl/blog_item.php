<?php
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
?>
<?php
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'wslib.media.multipic' );
$pic = new wsMultiPic;
$pic->setCacheDir( 'pictures' );
?>
<div class="other_news_item1">
	<div class="blog_title<?php echo $this->params->get( 'pageclass_sfx' ) ?>">

		<?php
		$tep = $this->item->params->get( 'image' );


		if ( $tep )
		{

			$image = $pic->getImage( 'image1', $tep );
			?>
			<div class="listing_block">
				<img src="<?php echo $image; ?>"  alt="<?php echo $this->item->title; ?>" title="<?php echo $this->item->title; ?>" align="left" />
			</div>
			<?php
		}
		?>
		<?php
		if ( !empty( $this->item->readmore_link ) )
		{
			?>		
			<a href="<?php echo $this->item->readmore_link; ?>" title="<?php echo $this->item->title; ?>">
				<?PHP
			}
			if ( !empty( $this->item->title ) )
			{
				echo $this->item->title;
			}
			if ( !empty( $this->item->readmore_link ) || !empty( $this->item->title ) )
			{
				?>
			</a>
			<?PHP
		}
		?>
	</div>
	<div class="listing_cat_date">
		<?php if ( $this->item->params->get( 'show_category' ) && $this->item->catid ) : ?>
			<div class="catnews_catlink">
				<span>
					<?php if ( $this->item->params->get( 'link_category' ) ) : ?>
						<?php echo '<a href="' . JRoute::_( ContentHelperRoute::getCategoryRoute( $this->item->catslug, $this->item->sectionid ) ) . '">'; ?>
					<?php endif; ?>
					<?php echo $this->item->category; ?>
					<?php if ( $this->item->params->get( 'link_category' ) ) : ?>
						<?php echo '</a>'; ?>
					<?php endif; ?>
				</span>
			</div>
		<?php endif; ?>

		<?php //echo $this->item->event->beforeDisplayContent;   ?>
		<?php
		if ( $this->item->params->get( 'show_create_date' ) )
		{
			?>
			<div class="listing_date<?php echo $this->params->get( 'pageclass_sfx' ) ?>">
				<span class="time">
					<?php echo JHTML::_( 'date', $this->item->publish_up, JText::_( 'DATE_FORMAT_LC5' ) ); ?>
				</span>
			</div>
		<?php } ?>
		<div class="cls"></div>
	</div>


	<div class="blog_text<?php echo $this->params->get( 'pageclass_sfx' ); ?>">
		<?php echo $this->item->introtext; ?>
	</div>
	<?php //echo $this->item->event->afterDisplayContent;  ?>
	<?php
	if ( !empty( $this->item->readmore_link ) )
	{
		?>
		<div class="article_foot">
			<span class="read_more">
				<a href="<?php echo $this->item->readmore_link; ?>" class="readon_a">
	<?php echo JText::_( 'Read more...' ); ?>
				</a>
			</span>
		</div>
	<?php }
	?>
	<div class="cls"></div>
</div>