<?PHP
/**
 * @version		$Id: default.php  2008-07-29
 * Teimuraz Kevlishvili
 */
// პირდაპირი წვდომის აკრძალვა
defined( '_JEXEC' ) or die( 'Restricted access' );
$c = 0;
$canEdit = ($this->user->authorize( 'com_content', 'edit', 'content', 'all' ) || $this->user->authorize( 'com_content', 'edit', 'content', 'own' ));
$row = $this->data;
$this->canEdit = $canEdit;
foreach ( $this->data as $this->row )
{

	$this->c = $c;
	echo $this->loadTemplate( 'item' );
	$c = 1 - $c;
}
?>
<div id="frontpage_bot">
</div>