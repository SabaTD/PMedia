<?php
/**
 * @version		$Id: mod_flash_jquery.php 50 2011-08-15 11:21:07Z a.kikabidze $
 * @package	Modules
 * @copyright	Copyright (C) 2009 - 2011 WebSolutions LLC. All rights reserved.
 * @license		GNU General Public License version 2 or later
 */
// no direct access
defined('_JEXEC') or die('Restricted access');

$rnd = mt_rand(1, 1000000);
jimport('wslib.helper');
?>
<div id="flashInteract<?php echo $rnd; ?>">
    <div class="movie" style="text-align: center; padding-top:50px;"></div>
</div>

<?php
$doc = JFactory::getDocument();

$js = '
			flashMovie = null;
			$(document).ready(
				function () {
					flashMovie = $("#flashInteract' . $rnd . ' .movie");
					flashMovie.flash(
						{
							swf: "' . JURI::root() . DS . 'images' . DS . 'banners' . DS . 'broweuli.swf' . '",
							width: "500",
							height: "400",
							play: true
						}
					);
                              

setTimeout("window.location.href=\'http://data.axmag.com/data/201309/20130930/U101938_F241842/FLASH/index.html\'",4000);
				}
			);
		';
$doc->addScriptDeclaration($js);
