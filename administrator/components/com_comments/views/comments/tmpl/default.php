<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
JHTML::_( 'behavior.tooltip' );
// Set toolbar items for the page
JToolBarHelper::title( JText::_( 'Comments Manager' ), 'generic.png' );
JToolBarHelper::publishList();
JToolBarHelper::unpublishList();
JToolBarHelper::deleteList( JText::_( 'VALIDDELETEITEMS' ) );
JToolBarHelper::editListX();
JToolBarHelper::addNewX( 'edit' );
JToolBarHelper::custom( 'confPlugin', 'config.png', '', JText::_( 'Comments Config' ), false );
?>

<form action="<?php echo $this->action; ?>" method="post" name="adminForm">
	<table>
		<tr>
			<td align="left" width="100%">
				<?php echo JText::_( 'Filter' ); ?>:
				<input type="text" name="search" id="search" value="<?php echo $this->lists['search']; ?>" class="text_area" onchange="document.adminForm.submit();" />
				<button onclick="this.form.submit();"><?php echo JText::_( 'Go' ); ?></button>
				<button onclick="document.getElementById('search').value='';this.form.getElementById('article_id').value='';this.form.getElementById('filter_state').value='';this.form.submit();"><?php echo JText::_( 'Reset' ); ?></button>
			</td>
			<td align="left" nowrap="nowrap">	
				<?php echo JText::_( 'Article ID' ); ?>
			</td>
			<td align="left" nowrap="nowrap">	
				<input type="text" name="article_id" id="article_id" value="<?php echo $this->lists['article_id']; ?>" class="text_area" onchange="document.adminForm.submit();" />
			</td>
			<td align="left" nowrap="nowrap">			
				<button onclick="this.form.submit();"><?php echo JText::_( 'Filter' ); ?></button>
			</td>
			<td nowrap="nowrap">
				<?php
				echo $this->lists['state'];
				?>
			</td>
		</tr>
	</table>

	<!-- Admin list -->
	<table class="adminlist" width="100%">
		<thead>
			<tr>
				<th width="30">
					<?php echo JText::_( 'NUM' ); ?>			</th>
				<th width="20">
					<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count( $this->items ); ?>);" />			</th>
				<th class="title" >
					<?php echo JHTML::_( 'grid.sort', 'Comment', 'a.comment', $this->lists['order_Dir'], $this->lists['order'] ); ?>			</th>
				<th width="15%" >
					<?php echo JHTML::_( 'grid.sort', 'Content Item', 'container', $this->lists['order_Dir'], $this->lists['order'] ); ?>			</th>
				<th width="100" >
					<?php echo JHTML::_( 'grid.sort', 'Author', 'author', $this->lists['order_Dir'], $this->lists['order'] ); ?>			</th>
				<th width="8%" nowrap="nowrap">
					<?php echo JHTML::_( 'grid.sort', 'Date', 'a.added', $this->lists['order_Dir'], $this->lists['order'] ); ?>			</th>
				<th width="5%" nowrap="nowrap">
					<?php echo JHTML::_( 'grid.sort', 'Accepted', 'a.published', $this->lists['order_Dir'], $this->lists['order'] ); ?>			</th>

				<th width="100"  align="center"><a href="javascript:void(0);">Author E-Mail</a></th>
				<th width="60" align="center" ><a href="javascript:void(0);">Remote IP</a></th>
				<th width="20" nowrap="nowrap">
					<?php echo JHTML::_( 'grid.sort', 'ID', 'a.id', $this->lists['order_Dir'], $this->lists['order'] ); ?>			</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="10">
					<?php echo $this->pagination->getListFooter(); ?>			</td>
			</tr>
		</tfoot>
		<tbody>
			<?php
			$k = 0;
			for ( $i = 0, $n = count( $this->items ); $i < $n; $i++ ):
				$row = &$this->items[$i];
				$row->editor = '';
				// Section Item
				$link['edit'] = JRoute::_( 'index.php?option=com_comments&task=edit&view=comment&id=' . $row->id );


				$row->added = JHTML::_( 'date', $row->added, JText::_( '%d %B %Y %H:%M' ) );

				mb_internal_encoding( "UTF-8" );
				$tooltip = strip_tags( $row->comment );
				$row->container = mb_substr( $row->container, 0, 50 ) . '...   ';
				$row->comment = mb_substr( $row->comment, 0, 50 ) . '...   ';
				$tooltipHTML = JHTML::tooltip( $tooltip, JText::_( 'Comment' ), $row->comment, $row->comment, '', 1 );

				$checked = JHTML::_( 'grid.checkedout', $row, $i );
				$published = JHTML::_( 'grid.published', $row, $i );
				?>
				<tr class="<?php echo 'row' . $k; ?>">
					<td>
						<div align="center"><?php echo $this->pagination->getRowOffset( $i ); ?>			</div></td>
					<td>
						<?php echo $checked; ?>			</td>
					<td>
						<?php
						if ( JTable::isCheckedOut( $this->user->get( 'id' ), $row->checked_out ) )
						{
							echo $tooltipHTML;
						}
						else
						{
							?>
							<a href="<?php echo $link['edit']; ?>">
								<?php echo $tooltipHTML; ?>					</a>
							<?php
						}
						?>			</td>

					<td>
						<?php echo $row->container; ?><br /><strong>Article ID : <?php echo $row->article_id; ?></strong></td>
					<td>
						<div align="center">
							<?php echo $row->author; ?>
						</div></td>
					<td class="order">
						<?php echo $row->added; ?>			</td>
					<td align="center">
						<?php echo $published; ?>			</td>
					<td>
						<div align="center">
							<a href="mailto:<?php echo $row->mail; ?>">
								<?php echo $row->mail; ?>
							</a>
						</div>
					</td>
					<td>
						<div align="center">
							<?php echo $row->ip; ?>
						</div>
					</td>
					<td align="center">
						<?php echo $row->id; ?>
					</td>
				</tr>
				<?php
				$k = 1 - $k;
			endfor;
			?>
		</tbody>
	</table>
	<input type="hidden" id="option" name="option" value="com_comments" />
	<input type="hidden" id="c" name="c" value="comment" />
	<input type="hidden" id="task" name="task" value="showList" />
	<input type="hidden" id="boxchecked" name="boxchecked" value="0" />
	<input type="hidden" id="filter_order" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
	<input type="hidden" id="filter_order_Dir" name="filter_order_Dir" value="<?php echo $this->lists['order_Dir']; ?>" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
