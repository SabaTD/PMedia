<?php
// no direct access
global $mainframe;
header( "Location: /" );
defined( '_JEXEC' ) or die( 'Restricted access' );
?>
<script language="javascript" type="text/javascript">
//<!--
	function setgood() {
		// TODO: Put setGood back
		return true;
	}
	var sectioncategories = new Array;
<?php
$i = 0;
foreach ( $this->lists['sectioncategories'] as $k => $items )
{
	foreach ( $items as $v )
	{
		echo "sectioncategories[" . $i++ . "] = new Array( '$k','" . addslashes( $v->id ) . "','" . addslashes( $v->title ) . "' );\n\t\t";
	}
}
?>


	function submitbutton(pressbutton) {
		var form = document.adminForm;
		if (pressbutton == 'cancel') {
			submitform(pressbutton);
			return;
		}
		try {
			form.onsubmit();
		} catch (e) {
			alert(e);
		}

		// do field validation
		var text = <?php echo $this->editor->getContent( 'text' ); ?>
		if (form.title.value == '') {
			return alert("<?php echo JText::_( 'Article must have a title', true ); ?>");
		} else if (text == '') {
			return alert("<?php echo JText::_( 'Article must have some text', true ); ?>");
		} else if (parseInt('<?php echo $this->article->sectionid; ?>')) {
			// for articles
			if (form.catid && getSelectedValue('adminForm', 'catid') < 1) {
				return alert("<?php echo JText::_( 'Please select a category', true ); ?>");
			}
		}
<?php echo $this->editor->save( 'text' ); ?>
		submitform(pressbutton);
	}
//-->
</script>
<div class="editor_div">
<?php if ( $this->params->get( 'show_page_title', 1 ) ) : ?>
		<div class="componentheading<?php echo $this->params->get( 'pageclass_sfx' ) ?>"><?php echo $this->escape( $this->params->get( 'page_title' ) ); ?></div>
<?php endif; ?>
	<form action="<?php echo $this->action ?>" method="post" name="adminForm" onSubmit="setgood();">
		<fieldset class="editor_fieldset">
			<legend><?php echo JText::_( 'Editor' ); ?></legend>
			<table class="adminform" width="100%">
				<tr>
					<td>
						<div style="float: left;">
							<label for="title">
<?php echo JText::_( 'Title' ); ?>:
							</label>
							<input class="inputbox" type="text" id="title" name="title" size="50" maxlength="100" value="<?php echo $this->escape( $this->article->title ); ?>" />
							<input class="inputbox" type="hidden" id="alias" name="alias" value="<?php echo $this->escape( $this->article->alias ); ?>" />
						</div>
						<div style="float: right;">
							<button type="button" onclick="submitbutton('save')">
<?php echo JText::_( 'Save' ) ?>
							</button>
							<button type="button" onclick="submitbutton('cancel')">
<?php echo JText::_( 'Cancel' ) ?>
							</button>
						</div>
					</td>
				</tr>
			</table>

<?php
echo $this->editor->display( 'text', $this->article->text, '100%', '400', '70', '15' );
?>
		</fieldset>
		<fieldset  class="editor_fieldset">
			<legend><?php echo JText::_( 'Publishing' ); ?></legend>
			<table class="adminform">
				<tr>
					<td class="key">
						<label for="sectionid">
<?php echo JText::_( 'Section' ); ?>:		</label>	</td>
					<td>
							<?php echo $this->lists['sectionid']; ?>	</td>
				</tr>
				<tr>
					<td class="key">
						<label for="catid">
				<?php echo JText::_( 'Category' ); ?>:		</label>	</td>
					<td>
<?php echo $this->lists['catid']; ?>	</td>
				</tr>
							<?php if ( $this->user->authorize( 'com_content', 'publish', 'content', 'all' ) ) : ?>
					<tr>
						<td class="key">
							<label for="state">
					<?php echo JText::_( 'Published' ); ?>:		</label>	</td>
						<td>
	<?php echo $this->lists['state']; ?>	</td>
					</tr>
							<?php endif; ?>
				<tr>
					<td width="120" class="key">
						<label for="frontpage">
<?php echo JText::_( 'Show on Front Page' ); ?>:		</label>	</td>
					<td>
							<?php echo $this->lists['frontpage']; ?>	</td>
				</tr>
				<tr>
					<td class="key">
						<label for="created_by_alias">
<?php echo JText::_( 'Author Alias' ); ?>:		</label>	</td>
					<td>
						<input type="text" id="created_by_alias" name="created_by_alias" size="50" maxlength="100" value="<?php echo $this->article->created_by_alias; ?>" class="inputbox" />	</td>
				</tr>
				<tr>
					<td class="key">
						<label for="publish_up">
<?php echo JText::_( 'Start Publishing' ); ?>:		</label>	</td>
					<td>
						<div class="editor_calendar">
							<?php echo JHTML::_( 'calendar', $this->article->publish_up, 'publish_up', 'publish_up', '%Y-%m-%d %H:%M:%S', array( 'class' => 'inputbox', 'size' => '25', 'maxlength' => '19' ) ); ?>		</div>	</td>
				</tr>
				<tr>
					<td class="key">
						<label for="publish_down">
<?php echo JText::_( 'Finish Publishing' ); ?>:		</label>	</td>
					<td>
							<?php echo JHTML::_( 'calendar', $this->article->publish_down, 'publish_down', 'publish_down', '%Y-%m-%d %H:%M:%S', array( 'class' => 'inputbox', 'size' => '25', 'maxlength' => '19' ) ); ?>	</td>
				</tr>
				<tr>
					<td valign="top" class="key">
						<label for="access">
<?php echo JText::_( 'Access Level' ); ?>:		</label>	</td>
					<td>
<?php echo $this->lists['access']; ?>	</td>
				</tr>
			</table>
		</fieldset>

		<fieldset  class="editor_fieldset">
			<legend><?php echo JText::_( 'Metadata' ); ?></legend>
			<table class="adminform" width="100%">
				<tr>
					<td valign="top" class="key">
						<label for="metadesc">
<?php echo JText::_( 'Description' ); ?>:		</label>	</td>
					<td>
						<div align="right">
							<textarea rows="5" cols="45" style="width:450px; height:120px" class="inputbox" id="metadesc" name="metadesc"><?php echo str_replace( '&', '&amp;', $this->article->metadesc ); ?></textarea>
						</div></td>
				</tr>
				<tr>
					<td  valign="top" class="key">
						<label for="metakey">
<?php echo JText::_( 'Keywords' ); ?>:		</label>	</td>
					<td>
						<div align="right">
							<textarea rows="5" cols="45" style="width:450px; height:50px" class="inputbox" id="metakey" name="metakey"><?php echo str_replace( '&', '&amp;', $this->article->metakey ); ?></textarea>
						</div></td>
				</tr>
			</table>
		</fieldset>

		<input type="hidden" name="option" value="com_content" />
		<input type="hidden" name="id" value="<?php echo $this->article->id; ?>" />
		<input type="hidden" name="version" value="<?php echo $this->article->version; ?>" />
		<input type="hidden" name="created_by" value="<?php echo $this->article->created_by; ?>" />
		<input type="hidden" name="referer" value="<?php echo @$_SERVER['HTTP_REFERER']; ?>" />
<?php echo JHTML::_( 'form.token' ); ?>
		<input type="hidden" name="task" value="" />
	</form>
</div>
<?php echo JHTML::_( 'behavior.keepalive' ); ?>
