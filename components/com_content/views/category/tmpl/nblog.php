<?PHP
/**
 * @version		$Id: default.php  2008-07-29
 * Teimuraz Kevlishvili
 */
// პირდაპირი წვდომის აკრძალვა
defined( '_JEXEC' ) or die( 'Restricted access' );
$canEdit = ($this->user->authorize( 'com_content', 'edit', 'content', 'all' ) || $this->user->authorize( 'com_content', 'edit', 'content', 'own' ));
$row = $this->data;
?>
<div class="block_container_r">
	<div class="block_header_m">
		<div class="block_title_m">
			<?
			if ( isset( $row['blocktitle'] ) )
			{
				echo $row['blocktitle'];
			}
			?>
		</div>
	</div>
	<?
	if ( isset( $row[0] ) )
	{
		$title = '';
		if ( !empty( $row[0]->titleimg ) && $row[0]->add )
		{
			$title .='<img alt="Image" title="' . $row[0]->title . '" src="' . $row[0]->titleimg . '" align="left" />';
		}
		$title .='<div class="main_title"><span class="article_time">' . $row[0]->Time . '</span>&nbsp;<a href="' . $row[0]->link . '">' . $row[0]->title . '</a></div>';
		?>
		<div class="main_article_m">
			<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
				<tr>
					<td valign="top">		
						<?php if ( $canEdit ) : ?>
							<a href="<?php echo $row[0]->link; ?>&task=edit"><img src="images/M_images/edit.png" alt="Image" title="რედაქტირება" border="0"/></a>
						<?php endif; ?>
						<?php //echo str_replace('{title}', $title, $row[0]->text);?>
						<?php echo $title . $row[0]->text; ?>
						<div align="right">
							<span class="readmore_article">
								<a href="<?php echo $row[0]->link; ?>" class="readon">
									<?php echo JText::_( 'Read more...' ); ?>
								</a>
							</span>
						</div>
					</td>
				</tr>
			</table>
		</div>
		<?
	}
	?>
	<div class="table_row_top_m">
		<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
			<tr>
				<td valign="top" width="50%">
					<div class="inner_td_l">
						<?
						if ( !empty( $row[1]->id ) )
						{
							?>
							<div class="article_title">

								<?
								if ( !empty( $row[1]->titleimg ) )
								{
									?>
									<img alt="Image" title="<?php echo $row[1]->title; ?>" src="<?php echo $row[1]->titleimg; ?>" align="left" />
									<?
								}
								?><span class="article_time">
									<?php echo $row[1]->Time; ?></span><a href="<?php echo $row[1]->link; ?>"><?php echo $row[1]->title; ?></a>		<?php if ( $canEdit ) : ?>
									<a href="<?php echo $row[1]->link; ?>&task=edit"><img src="images/M_images/edit.png" alt="Image" title="რედაქტირება" border="0"/></a>
								<?php endif; ?></div> 
							<?php ($row[1]->id) ? print($row[1]->text )  : print('' ); ?>	
							<?
						}
						?>
					</div>
				</td>
				<td valign="top" width="50%">
					<div class="inner_td_r">
						<?
						if ( !empty( $row[2]->id ) )
						{
							?>
							<div class="article_title">

								<?
								if ( !empty( $row[2]->titleimg ) )
								{
									?>
									<img alt="Image" title="<?php echo $row[2]->title; ?>" src="<?php echo $row[2]->titleimg; ?>" align="left" />
									<?
								}
								?>
								<span class="article_time">
									<?php echo $row[2]->Time; ?>
								</span>
								<a href="<?php echo $row[2]->link; ?>"><?php echo $row[2]->title; ?></a>
								<?php if ( $canEdit ) : ?>
									<a href="<?php echo $row[2]->link; ?>&task=edit"><img src="images/M_images/edit.png" alt="Image" title="რედაქტირება" border="0"/></a>
								<?php endif; ?></div> 
							<?php ($row[2]->id) ? print($row[2]->text )  : print('' ); ?>
							<?
						}
						?>				
					</div>
				</td>
			</tr>	
		</table>
	</div>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td width="50%"><div class="inner_td_line_l"><div class="inner_td_line_in"></div></div></td>
			<td width="50%"><div class="inner_td_line_r"><div class="inner_td_line_in"></div></div></td>
		</tr>
	</table>
	<div class="table_row_bot">
		<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
			<tr>
				<td valign="top" width="50%">
					<div class="inner_td_l">
						<?
						if ( !empty( $row[3]->id ) )
						{
							?>
							<div class="article_title">

								<?
								if ( !empty( $row[3]->titleimg ) )
								{
									?>
									<img alt="Image" title="<?php echo $row[3]->title; ?>" src="<?php echo $row[3]->titleimg; ?>" align="left" />
									<?
								}
								?>
								<span class="article_time">
									<?php echo $row[3]->Time; ?>
								</span>
								<a href="<?php echo $row[3]->link; ?>"><?php echo $row[3]->title; ?></a>
								<?php if ( $canEdit ) : ?>
									<a href="<?php echo $row[3]->link; ?>&task=edit"><img src="images/M_images/edit.png" alt="Image" title="რედაქტირება" border="0"/></a>
								<?php endif; ?>	</div> 
							<?php ($row[3]->id) ? print($row[3]->text )  : print('' ); ?>
							<?
						}
						?>
					</div>
				</td>
				<td valign="top" width="50%">
					<div class="inner_td_r">
						<?
						if ( !empty( $row[4]->id ) )
						{
							?>
							<div class="article_title">

								<?
								if ( !empty( $row[4]->titleimg ) )
								{
									?>
									<img alt="Image" title="<?php echo $row[4]->title; ?>" src="<?php echo $row[4]->titleimg; ?>" align="left" />
									<?
								}
								?><span class="article_time">
								<?php echo $row[4]->Time; ?>
								</span><a href="<?php echo $row[4]->link; ?>"><?php echo $row[4]->title; ?></a>
								<?php if ( $canEdit ) : ?>
									<a href="<?php echo $row[4]->link; ?>&task=edit"><img src="images/M_images/edit.png" alt="Image" title="რედაქტირება" border="0"/></a>
								<?php endif; ?>	</div> 
							<?php ($row[4]->id) ? print($row[4]->text )  : print('' ); ?>
							<?
						}
						?>
					</div>
				</td>
			</tr>
		</table>
	</div>
</div>
<?
if ( !empty( $row['big_advert'] ) )
{
	?>
	<div class="big_advert">
		<?
		echo $row['big_advert'];
		?>
	</div>	
	<?
}
echo wsHelper::getModule( 'category_images' );
/*
  if ( !empty( $row['comments'] ) )
  {
  ?><div class="bottom_part_m">
  <div class="main_comment_title_a">
  <span class="comment_title">
  <?
  if ( !empty( $row['comments'][0]->exclusive_title ) )
  {
  ?>
  <a href="<?php echo $row['comments'][0]->catlink; ?>">
  <?php echo $row['comments'][0]->exclusive_title; ?>
  </a>
  <?
  }
  else
  {
  echo JText::_( 'Comment' );
  }
  ?>
  </span>
  </div>
  <div class="main_comment_block">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
  <?
  $a = 0;
  $width = 100 / count( $row['comments'] );
  foreach ( $row['comments'] as $comment )
  {
  if ( $a > 0 )
  {
  ?>
  <td valign="top" class="block_separator">&nbsp;

  </td>
  <?
  }
  ?>
  <td width="<?php echo $width ?>%" valign="top">
  <div class="maincomment_block_row">
  <?
  if ( !empty( $comment->TImg ) )
  {
  ?>
  <span class="comment_row_img" >
  <img src="<?php echo $comment->TImg; ?>" alt="" />
  </span>
  <?
  }
  ?>


  <span class="comment_row_title" >
  <a href="<?php echo $comment->link; ?>">
  <?php echo $comment->title; ?>
  </a>
  </span>
  <?php echo $comment->text; ?>
  </div>
  </td>
  <?
  $a++;
  }
  ?>
  </tr>
  </table>
  </div>
  </div>
  <?
  }

  if ( !empty( $row['conference'] ) )
  {
  ?><div class="bottom_part_m_conf">
  <div class="main_comment_title_a">
  <span class="comment_title">
  <?
  if ( !empty( $row['conference'][0]->conference_title ) )
  {
  ?>
  <a href="<?php echo $row['conference'][0]->catlink; ?>">
  <?php echo $row['conference'][0]->conference_title; ?>
  </a>
  <?
  }
  else
  {
  echo JText::_( 'Conference' );
  }
  ?>
  </span>
  </div>
  <div class="main_conference_block">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
  <?
  $width = 100 / count( $row['conference'] );
  $a = 0;
  foreach ( $row['conference'] as $conference )
  {
  if ( $a > 0 )
  {
  ?>
  <td valign="top" class="block_separator">&nbsp;

  </td>
  <?
  }
  ?>
  <td width="<?php echo $width ?>%" valign="top">
  <div class="maincomment_block_row">
  <?
  if ( !empty( $conference->TImg ) )
  {
  ?>
  <span class="comment_row_img" >
  <img src="<?php echo $conference->TImg; ?>" alt="" />
  </span>
  <?
  }
  ?>
  <span class="comment_row_title" >
  <a href="<?php echo $conference->link; ?>">
  <?php echo $conference->title; ?>
  </a>
  </span>
  <?php echo $conference->text; ?>
  </div>
  </td>
  <?
  $a++;
  }
  ?>
  </tr>
  </table>
  </div>
  </div>
  <?
  }

  if ( !empty( $row['gallery'] ) )
  {
  ?><div class="bottom_part_m_gallery">
  <div class="main_comment_title_a">
  <span class="comment_title">
  <?
  if ( !empty( $row['gallery']['galleryname'] ) )
  {
  ?>
  <a href="<?php echo $row['gallery']['galleryurl']; ?>">
  <?php echo $row['gallery']['galleryname']; ?>
  </a>
  <?
  }
  else
  {
  echo JText::_( 'Gallery' );
  }
  unset( $row['gallery']['galleryname'] );
  unset( $row['gallery']['galleryurl'] );
  ?>
  </span>
  </div>
  <div class="main_gallery_block">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
  <?
  if ( count( $row['gallery'] ) )
  {
  $count = count( $row['gallery'] );
  }
  else
  {
  $count = 1;
  }
  $width = 100 / $count;
  $a = 0;
  foreach ( $row['gallery'] as $item )
  {
  if ( $a > 0 )
  {
  ?>
  <td valign="top" class="block_separator">&nbsp;

  </td>
  <?
  }
  ?>
  <td width="<?php echo $width ?>%" valign="top" align="center">
  <div class="maingallery_block_row">
  <a href="<?php echo $item['link']; ?>">
  <img src="<?php echo $item['thrumb']; ?>"  alt="Image" title="<?php echo $item['name']; ?>"/>
  </a>
  <div class="gallery_title">
  <a href="<?php echo $item['link']; ?>">
  <?php echo $item['name']; ?>
  </a>
  </div>
  </div>
  </td>
  <?
  $a++;
  }
  ?>
  </tr>
  </table>
  </div>
  </div>
  <?
  }
 */
if ( !empty( $row['main_advert'] ) )
{
	?>
	<div class="advert_m">
		<?
		echo $row['main_advert'];
		?>
	</div>	
	<?
}

if ( !empty( $row['other'] ) )
{
	?>			
	<div class="block_container_o">
		<div class="other_news_title">
			<div class="other_title">
				<?php echo $row['othernews'] ?>:
			</div>
		</div>
		<?
		$num = 0;
		for ( $a = 0; $a < count( $row['other'] ); $a++ )
		{
			?>
			<div class="other_news_item<?php echo $num ?>">
				<div class="article_time_o">
					<?php echo $row['other'][$a]->Time; ?>&nbsp;
				</div>
				<a href="<?php echo $row['other'][$a]->link; ?>"><?php echo $row['other'][$a]->title; ?></a>	
				<?php if ( $canEdit ) : ?>
					<a href="<?php echo $row['other'][$a]->link; ?>&task=edit"><img src="images/M_images/edit.png"alt="Image" title="რედაქტირება" border="0"/></a>
				<?php endif; ?>

				<div class="intro">
					<?php echo $row['other'][$a]->text; ?>
				</div>	
			</div>
			<?
			$num = 1 - $num;
		}
		?>
	</div>
	<?
}

