<?php
// no direct access
defined('_JEXEC') or die('Restricted access');
$cparams = & JComponentHelper::getParams('com_media');
?>
<div id="page_blog<?php echo $this->params->get('pageclass_sfx'); ?>">
    <?php if ($this->params->get('show_page_title', 1)) : ?>
        <div class="page_title<?php echo $this->params->get('pageclass_sfx'); ?>">
            <span>
                <?php
                echo $this->escape($this->params->get('page_title'));

                if (!empty($this->tag_title))
                {
                    echo ' : ' . $this->tag_title;
                }
                ?>
            </span>
        </div>
    <?php endif; ?>
    <div class="page_body">
        <?php
        $k = 0;
        for ($a = $this->pagination->limitstart; $a < count($this->items) + $this->pagination->limitstart; $a++)
        {
            if ($k == 1)
            {
                echo '<div class="cls"></div>';
            }
            $k = 1;
            $this->item = & $this->getItem($a, $this->params);
            echo $this->loadTemplate('item');
        }
        ?>

        <?php if ($this->params->get('show_pagination')) : ?>
            <?php echo $this->pagination->getPagesLinks(); ?>
        <?php endif; ?>
    </div>
</div>