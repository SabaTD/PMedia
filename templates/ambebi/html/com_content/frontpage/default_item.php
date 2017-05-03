<?PHP
/**
 * @version		$Id: default.php  2008-07-29
 * Teimuraz Kevlishvili
 */
// პირდაპირი წვდომის აკრძალვა
defined( '_JEXEC' ) or die( 'Restricted access' );
$row = $this->row;
$canEdit = $this->canEdit;
?>
<div class="left_part">	
	<div class="left_part_in<?php echo $this->c; ?>">
		<div class="block_header">
			<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">	  <tr>
					<td valign="top">	
						<span class="block_title">
							<span>
								<?php
								if ( isset( $row[1]->block_title ) )
								{
									echo $row[1]->block_title;
								}
								?>
							</span>
						</span>
					</td>
					<td align="right">
						<div class="block_banner">
							<?php
							if ( isset( $row['main_advert'] ) )
							{
								echo $row['main_advert'];
							}
							?>
						</div>	
					</td>
				</tr>
			</table>
		</div>
		<div class="block_container">
			<?php
			if ( isset( $row[0] ) )
			{
				$title = '<div class="main_title"><span class="article_time">' . $row[0]->Time . '</span>&nbsp;<a href="' . $row[0]->link . '">' . $row[0]->title . '</a></div>';
				?>

				<div class="main_article">
					<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
						<tr>
							<td valign="top">	<?php if ( $canEdit ) : ?>
									<a href="<?php echo $row[0]->link; ?>&task=edit"><img src="/ambebi/images/M_images/edit.png" alt="რედაქტირება" border="0"/></a>
	<?php endif; ?>
	<?php //echo str_replace('{title}', $title, $row[0]->text);  ?>			  	
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
<?php }
?>
			<div class="table_row_top">
				<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
					<tr>
						<td valign="top" width="50%">
							<div class="inner_td_l">
<?php
if ( !empty( $row[1]->id ) )
{
	?>
									<div class="article_title">
										<span class="article_time">
										<?php echo $row[1]->Time; ?>&nbsp;					</span>	
										<?php
										if ( !empty( $row[1]->titleimg ) )
										{
											?>
											<img alt="<?php echo $row[1]->title; ?>" src="<?php echo $row[1]->titleimg; ?>" align="left" />
											<?php
										}
										?>
										<a href="<?php echo $row[1]->link; ?>"><?php echo $row[1]->title; ?></a>				<?php if ( $canEdit ) : ?>
											<a href="<?php echo $row[0]->link; ?>&task=edit"><img src="/ambebi/images/M_images/edit.png" alt="რედაქტირება" border="0"/></a>
									<?php endif; ?></div> 
									<?php ($row[1]->id) ? print($row[1]->text ) : print('' ); ?>		
									<?php /* ?>
									  <div align="right">
									  <span class="readmore_article">
									  <a href="<?php echo $row[2]->link; ?>" class="readon">
									  <?php echo JText::_('Read more...'); ?>
									  </a>
									  </span>
									  </div>
									  <?php */ ?>
<?php }
?>
							</div>
						</td>
						<td valign="top" width="50%">
							<div class="inner_td_r">
										<?php
										if ( !empty( $row[2]->id ) )
										{
											?>
									<div class="article_title">
										<span class="article_time">
										<?php echo $row[2]->Time; ?>&nbsp;
										</span>
										<?php
										if ( !empty( $row[2]->titleimg ) )
										{
											?>
											<img alt="<?php echo $row[2]->title; ?>" src="<?php echo $row[2]->titleimg; ?>" align="left" />
										<?php }
										?><a href="<?php echo $row[2]->link; ?>"><?php echo $row[2]->title; ?></a>
										<?php if ( $canEdit ) : ?>
												<a href="<?php echo $row[0]->link; ?>&task=edit"><img src="/ambebi/images/M_images/edit.png" alt="რედაქტირება" border="0"/></a>
										<?php endif; ?></div> 
										<?php ($row[2]->id) ? print($row[2]->text ) : print('' ); ?>
										<?php /* ?>
										  <div align="right">
										  <span class="readmore_article">
										  <a href="<?php echo $row[2]->link; ?>" class="readon">
										  <?php echo JText::_('Read more...'); ?>
										  </a>
										  </span>
										  </div>
										  <?php */ ?>
		<?php
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
											<?php
											if ( !empty( $row[3]->id ) )
											{
												?>
										<div class="article_title">
											<span class="article_time">
											<?php echo $row[3]->Time; ?>&nbsp;
											</span>
											<?php
											if ( !empty( $row[3]->titleimg ) )
											{
												?>
												<img alt="<?php echo $row[3]->title; ?>" src="<?php echo $row[3]->titleimg; ?>" align="left" />
											<?php
										}
										?><a href="<?php echo $row[3]->link; ?>"><?php echo $row[3]->title; ?></a>
										<?php if ( $canEdit ) : ?>
												<a href="<?php echo $row[0]->link; ?>&task=edit"><img src="/ambebi/images/M_images/edit.png" alt="რედაქტირება" border="0"/></a>
										<?php endif; ?></div> 
										<?php ($row[3]->id) ? print($row[3]->text ) : print('' ); ?>

										<?php /* ?>							<div align="right">
										  <span class="readmore_article">
										  <a href="<?php echo $row[3]->link; ?>" class="readon">
										  <?php echo JText::_('Read more...'); ?>
										  </a>
										  </span>
										  </div>			<?php */ ?>		
										<?php
									}
									?>
								</div>
							</td>
							<td valign="top" width="50%">
								<div class="inner_td_r">
											<?php
											if ( !empty( $row[4]->id ) )
											{
												?>
										<div class="article_title">
											<span class="article_time">
											<?php echo $row[4]->Time; ?>&nbsp;
											</span>
											<?php
											if ( !empty( $row[4]->titleimg ) )
											{
												?>
												<img alt="<?php echo $row[4]->title; ?>" src="<?php echo $row[4]->titleimg; ?>" align="left" />
											<?php
										}
										?><a href="<?php echo $row[4]->link; ?>"><?php echo $row[4]->title; ?></a>
										<?php if ( $canEdit ) : ?>
												<a href="<?php echo $row[0]->link; ?>&task=edit"><img src="/ambebi/images/M_images/edit.png" alt="რედაქტირება" border="0"/></a>
										<?php endif; ?></div> 
										<?php ($row[4]->id) ? print($row[4]->text ) : print('' ); ?>

										<?php /* ?>							<div align="right">
										  <span class="readmore_article">
										  <a href="<?php echo $row[4]->link; ?>" class="readon">
										  <?php echo JText::_('Read more...'); ?>
										  </a>
										  </span>
										  </div>			<?php */ ?>
		<?php
	}
	?>
								</div>
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</div>
	<div class="right_part">
	<?php
	if ( !empty( $row['comment'] ) )
	{
		?>
			<div class="comments_block">
				<div class="comments_f">
					<div class="comment_title_a">
						<span class="comment_title">
					<?php echo JText::_( 'Comment' ); ?>
						</span>
					</div>				
								<?php
								foreach ( $row['comment'] as $comment )
								{
									?>
						<div class="comment_block_row">
							<span class="comment_row_title" >
								<a href="<?php echo $comment->link; ?>">
						<?php echo $comment->title; ?>
								</a>
							</span>
				<?php echo $comment->text; ?>
						</div>
				<?php
			}
			?></div>
			</div>
				<?php
			}
			?>
		<div class="right_banners">
	<?php
	if ( isset( $row['right_advert'] ) )
	{
		echo $row['right_advert'];
	}
	?>
	</div>
</div>
<span class="cls"></span>