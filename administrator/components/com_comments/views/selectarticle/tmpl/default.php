<?php
/**
 * @version		$Id: default.php  2008-07-29
 * Teimuraz Kevlishvili
 */
// პირდაპირი წვდომის აკრძალვა
defined( '_JEXEC' ) or die( 'Restricted access' );
?>
<form name="adminForm" method="post" action="index.php">
	<div id="editcell">
		<table border="0" cellspacing="0" cellpadding="0" width="100%">
			<tr>
				<td height="32" valign="top">
					<div align="left"><?php echo JText::_( 'Filter' ); ?>:
						<input type="text" name="asearch" id="asearch" value="<?php echo $this->asearch; ?>" class="text_area" onchange="document.adminForm.submit();" />
						<button onclick="this.form.submit();"><?php echo JText::_( 'Go' ); ?></button>
						<button onclick="document.getElementById('asearch').value = '';
									document.getElementById('catfilter').value = '0';
									document.getElementById('datefrom').value = '';
									document.getElementById('datetill').value = '';
									this.form.submit();"><?php echo JText::_( 'Reset' ); ?></button>
					</div>
				</td>

				<td align="right" valign="top">
<?php echo $this->lists['catfilter']; ?>	
				</td>
			</tr>
		</table>
		<table width="100%" border="0" cellspacing="1" cellpadding="0" class="adminlist">
			<thead>
				<tr>
					<th width="21"><div align="center"><a href="#" onclick="return false">#</a></div></th>		
			<th ><div align="left"><a href="#" onclick="return false"><?php echo JText::_( 'Article Title' ); ?></a></div></th>
			<th ><div align="center"><a href="#" onclick="return false"><?php echo JText::_( 'Section' ); ?> </a></div></th>
			<th ><div align="center"><a href="#" onclick="return false"><?php echo JText::_( 'Category' ); ?> </a></div></th>
			<th><div align="center"><a href="#" onclick="return false"><?php echo JText::_( 'Created' ); ?></a></div></th>
			<th><div align="center"><a href="#" onclick="return false"><?php echo JText::_( 'Published' ); ?></a></div></th>
			<th width="30"><div align="center"><a href="#" onclick="return false">ID</a></div></th>
			</tr>
			</thead>
<?php
if ( count( $this->articles ) )
{
	?>
				<tbody>
				<?php
				$k = 0;
				$i = 0;

				foreach ( $this->articles as $row )
				{
					?>
						<tr class="<?php echo 'row' . $k; ?>">
							<td><div align="center"><?php echo $i + 1 + $this->pagination->limitstart; ?></div></td>
							<td>
								<a onclick="window.parent.jSelectArticle('<?php echo $row->id; ?>', '<?php echo htmlspecialchars( addslashes( $row->title ), ENT_QUOTES ); ?>', '<?php echo $this->object; ?>');" style="cursor: pointer;">
		<?php echo $row->title; ?>		
								</a>	
							</td>
							<td width="10%">
								<div align="center">
		<?php echo $row->sectitle; ?>
								</div>
							</td>    
							<td width="10%">
								<div align="center">
		<?php echo $row->cattitle; ?>
								</div>
							</td>
							<td width="10%"><div align="center"><?php echo $row->created; ?></div></td>
							<td width="10%"><div align="center"><?php echo $row-> publish_up; ?></div></td>
							<td><div align="center"><?php echo $row->id; ?></div></td>
						</tr>	
		<?php
		$i++;
		$k = 1 - $k;
	}
	?>
				</tbody>
				<tfoot>
					<tr>
						<td colspan="7">
	<?php echo $this->pagination->getListFooter(); ?>
						</td>
					</tr>
				</tfoot> 
	<?php
}
?>
		</table>

		<input type="hidden" name="c" value="selectarticle" />
		<input type="hidden" name="view" value="selectarticle" />
		<input type="hidden" name="option" value="com_mmanager" />	
		<input type="hidden" name="object" value="<?php echo $this->object;?>" />
		<input type="hidden" name="tmpl" value="component" />
	</div>
</form>