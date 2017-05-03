<?php
/**
 * Display media form, follow weblinks model 
 */
defined( '_JEXEC' ) or die( 'Restricted access' );
$editor = & JFactory::getEditor();
// ToolBar
$text = ($this->item->id) ? JText::_( 'Edit' ) : JText::_( 'New' );

JToolBarHelper::title( 'Comment Item: <small><small>[' . $text . ' ]</small></small>' );
JToolBarHelper::save();
JToolBarHelper::cancel();
?>

<script language="javascript" type="text/javascript">
	function submitbutton(pressbutton)
	{
		var form = document.adminForm;
		if (pressbutton == 'cancel')
		{
			submitform(pressbutton);
			return;
		}
		// Content
		if (form.a_name.value == "")
		{
			alert("<?php echo JText::_( 'You must select a content', true ); ?>");
			return;
		}
<?php echo $editor->save( 'comment' ); ?>
		submitform(pressbutton);
	}
</script>
<style type="text/css">
	table.paramlist td.paramlist_key {
		width: 92px;
		text-align: left;
		height: 30px;
	}
	table.admintable{
		width: 100%;
	}
</style>

<form action="<?php echo $this->action; ?>" method="post" name="adminForm" id="adminForm">
	<!-- Properties -->
	<div class="col width-60">
		<fieldset class="adminform">
			<table class="admintable" width="100%">
				<!-- Title -->

				<!-- Comment -->
				<tr>
					<td width="100" align="right" valign="center" class="key">
						<label for="comment">
							<?php echo JText::_( 'Comment' ); ?>:				</label>			</td>
					<td>
						<?php
						echo $editor->display( 'comment', htmlspecialchars( $this->item->comment, ENT_QUOTES ), '500', '300', '30', '10', array( 'readmore', 'pagebreak' ) );
						?>
					</td>
				</tr>
			</table>		
		</fieldset>

		<fieldset class="adminform">
			<legend><?php echo JText::_( 'Optional Params' ); ?></legend>
			<table class="admintable">			
				<!-- Optional Params -->		
				<tr>
					<td width="100" align="right" class="key">
						<label for="title">
							<?php echo JText::_( 'Author' ); ?>:				</label>			</td>
					<td>
						<input class="inputbox" size="64" type="text" name="author" id="author" maxlength="250" value="<?php echo $this->item->author; ?>" />			</td>
				</tr>
				<tr>
					<td width="100" align="right" class="key">
						<label for="title">
							<?php echo JText::_( 'Email' ); ?>:				</label>			</td>
					<td>
						<input class="inputbox" size="64" type="text" name="mail" id="mail" maxlength="250" value="<?php echo $this->item->mail; ?>" />			</td>
				</tr>	
			</table>
		</fieldset>
	</div>	

	<!-- detail -->
	<div class="col width-40">
		<fieldset class="adminform">

			<table class-"admintable">		
						 <tr>
					<td valign="top" align="right" class="key">
						<label><?php echo JText::_( 'Accepted' ); ?>:</label>
					</td>
					<td>
						<?php echo $this->lists['published']; ?>
					</td>
				</tr>
				<tr>
					<td valign="top" align="right" class="key">
						<label><?php echo JText::_( 'Container' ); ?>:</label>
					</td>
					<td>
						<?php echo $this->lists['article']; ?>
					</td>
				</tr>			
			</table>

			<?php if ( $this->item->id )
			{ ?><br />
				<table style="border: 1px dashed silver; padding: 5px; margin-bottom: 10px;" width="100%">
					<tbody>

						<tr>
							<td><strong class="createdate">Added Date:</strong></td>
							<td><?php echo $this->item->added; ?></td>
						</tr>
						<tr>
							<td>
								<strong>Comment ID:</strong>				</td>
							<td><?php echo $this->item->id; ?></td>
						</tr>
					</tbody>
				</table>		
<?php } ?>

		</fieldset>	
	</div>		
	<div class="clr"></div>	
	<input type="hidden" name="added" value="<?php echo $this->item->added; ?>" />
	<input type="hidden" name="id" value="<?php echo $this->item->id; ?>" />	
	<input type="hidden" name="ip" value="<?php echo $this->item->ip; ?>" />	
	<input type="hidden" name="option" value="com_comments" />
	<input type="hidden" name="c" value="comment" />
	<input type="hidden" name="task" value="" />
<?php echo JHTML::_( 'form.token' ); ?>
</form>
